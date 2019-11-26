<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace greg\dyno\event;

/**
* @ignore
*/

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
            'core.ucp_register_register_after' => 'add_forum_on_event',
		);
	}

	/* @var \phpbb\db\driver\driver_interface */
	protected $db;

    /**
     * Constructor
     * @param \phpbb\db\driver\driver_interface $db Driver Interface
     */
	public function __construct( \phpbb\db\driver\driver_interface $db )
	{
        $this->db = $db;
	}

	public function add_forum_on_event($event){

	    global $phpbb_root_path, $phpEx, $auth, $sql;

	    $cp_data = $event['cp_data'];
	    $forum_name = $cp_data['pf_phpbb_address'];

	    include ($phpbb_root_path . 'includes/acp/acp_forums.' . $phpEx);
	    include ($phpbb_root_path . 'includes/functions_acp.' . $phpEx);
	    include ($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

        $forum_data = array(
            'parent_id'                => 0,
            'forum_type'            => FORUM_POST,
            'type_action'            => '',
            'forum_status'            => ITEM_UNLOCKED,
            'forum_parents'            => '',
            'forum_name'            => $forum_name,
            'forum_link'            => '',
            'forum_link_track'        => false,
            'forum_desc'            => '',  // Description, if you want to add one
            'forum_desc_uid'        => '',
            'forum_desc_options'    => 7,
            'forum_desc_bitfield'    => '',
            'forum_rules'            => '',
            'forum_rules_uid'        => '',
            'forum_rules_options'    => 7,
            'forum_rules_bitfield'    => '',
            'forum_rules_link'        => '',
            'forum_image'            => '',
            'forum_style'            => 0,
            'display_subforum_list'    => false,
            'display_on_index'        => false,
            'forum_topics_per_page'    => 0,
            'enable_indexing'        => true,
            'enable_icons'            => false,
            'enable_prune'            => false,
            'enable_post_review'    => true,
            'enable_quick_reply'    => false,
            'prune_days'            => 7,
            'prune_viewed'            => 7,
            'prune_freq'            => 1,
            'prune_old_polls'        => false,
            'prune_announce'        => false,
            'prune_sticky'            => false,
            'forum_password'        => '',
            'forum_password_confirm'=> '',
            'forum_password_unset'    => false,
            'forum_options'=> 0,
            'show_active'=> true,
        );

        $sql = 'SELECT forum_name FROM ' . FORUMS_TABLE;
        $result = $this->db->sql_query($sql);
        $rows = $this->db->sql_fetchrowset($result);
        $this->db->sql_freeresult($result);
        $forum_exist = 0;
        foreach ($rows as $row){
            if($row['forum_name'] == $forum_name) {
                $forum_exist = true;
            }
        }

        if(!$forum_exist){
            \acp_forums::update_forum_data($forum_data);
            global $cache;
            $cache->destroy('sql', FORUMS_TABLE);
            $forum_perm_from = 1;
            if ($forum_perm_from) {
                copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
            }
            $auth->acl_clear_prefetch();
        } else {
            $sql = "SELECT forum_id FROM ". FORUMS_TABLE ." WHERE forum_name = " . "'" . $forum_name ."'";
            $result = $this->db->sql_query($sql);
            $rows = $this->db->sql_fetchrowset($result);
            $forum_data['forum_id'] = $rows[0]['forum_id'];
            $this->db->sql_freeresult($result);
        }


        $user_id = $event['user_id'];

        $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $this->db->sql_build_array('INSERT', array(
            'user_id'        => $user_id,
            'forum_id'       => $forum_data['forum_id'],
            'auth_role_id'   => 15
            ));

        $this->db->sql_query($sql);
    }
}
