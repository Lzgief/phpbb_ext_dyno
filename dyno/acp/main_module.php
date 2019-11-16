<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace greg\dyno\acp;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
    exit;
}

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_root_path, $phpEx, $db;

		$this->db = $db;
        /*** 2011-03-27 END ***/
        $user->add_lang('acp/common');
		$this->tpl_name = 'demo_body';
		$this->page_title = $user->lang('ACP_DEMO_TITLE');
		add_form_key('greg/dyno');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('greg/dyno'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('acme_demo_goodbye', $request->variable('acme_demo_goodbye', 0));

            include ($phpbb_root_path . 'includes/acp/acp_forums.' . $phpEx);

//            $forum_data = array(
//                'parent_id'                => 0,  // Keep in mind that a category is also a parent!
//                'forum_type'            => FORUM_POST,
//                'type_action'            => '',
//                'forum_status'            => ITEM_UNLOCKED,
//                'forum_parents'            => '',
//                'forum_name'            => 'Da',
//                'forum_link'            => '',
//                'forum_link_track'        => false,
//                'forum_desc'            => '',  // Description, if you want to add one
//                'forum_desc_uid'        => '',
//                'forum_desc_options'    => 7,
//                'forum_desc_bitfield'    => '',
//                'forum_rules'            => '',
//                'forum_rules_uid'        => '',
//                'forum_rules_options'    => 7,
//                'forum_rules_bitfield'    => '',
//                'forum_rules_link'        => '',
//                'forum_image'            => '',
//                'forum_style'            => 0,
//                'display_subforum_list'    => false,
//                'display_on_index'        => false,
//                'forum_topics_per_page'    => 0,
//                'enable_indexing'        => true,
//                'enable_icons'            => false,
//                'enable_prune'            => false,
//                'enable_post_review'    => true,
//                'enable_quick_reply'    => false,
//                'prune_days'            => 7,
//                'prune_viewed'            => 7,
//                'prune_freq'            => 1,
//                'prune_old_polls'        => false,
//                'prune_announce'        => false,
//                'prune_sticky'            => false,
//                'forum_password'        => '',
//                'forum_password_confirm'=> '',
//                'forum_password_unset'    => false,
//                'forum_options'=> 0,
//                'show_active'=> true,
//            );
//
//            if ($forum_data['forum_desc'])
//            {
//                generate_text_for_storage($forum_data['forum_desc'], $forum_data['forum_desc_uid'], $forum_data['forum_desc_bitfield'], $forum_data['forum_desc_options'], false, false, false);
//            }
//
//            \acp_forums::update_forum_data($forum_data);

            $sql = 'SELECT forum_name FROM ' . FORUMS_TABLE;
            $result=$this->db->sql_query($sql);
            $rows = $this->db->sql_fetchrowset($result);
            $this->db->sql_freeresult($result);
            foreach($rows as $row){
                if($row['forum_name'] == 'Дом 2') {
                    $forum_exist = 1;
                    echo $forum_exist;
                }
            }



        	trigger_error($user->lang('ACP_DEMO_SETTING_SAVED') . adm_back_link($this->u_action));
		}


		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
			'ACME_DEMO_GOODBYE'		=> $config['acme_demo_goodbye'],
		));


	}
}


