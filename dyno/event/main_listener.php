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
//            'user.user_setup' => 'shoutout',
        );
    }

    /* @var \phpbb\db\driver\driver_interface */
    protected $db;

    /**
     * Constructor
     * @param \phpbb\db\driver\driver_interface $db Driver Interface
     */
    public function __construct(\phpbb\db\driver\driver_interface $db)
    {
        $this->db = $db;
    }

    public function add_forum_on_event($event)
    {

        global $phpbb_root_path, $phpEx, $auth, $sql;

        $cp_data = $event['cp_data'];
        $forum_name = $cp_data['pf_phpbb_address'];

        include($phpbb_root_path . 'includes/acp/acp_forums.' . $phpEx);
        include($phpbb_root_path . 'includes/functions_acp.' . $phpEx);
        include($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

        $forum_data = array(
            'parent_id' => 0,
            'forum_type' => FORUM_POST,
            'type_action' => '',
            'forum_status' => ITEM_UNLOCKED,
            'forum_parents' => '',
            'forum_name' => $forum_name,
            'forum_link' => '',
            'forum_link_track' => false,
            'forum_desc' => '',  // Description, if you want to add one
            'forum_desc_uid' => '',
            'forum_desc_options' => 7,
            'forum_desc_bitfield' => '',
            'forum_rules' => '',
            'forum_rules_uid' => '',
            'forum_rules_options' => 7,
            'forum_rules_bitfield' => '',
            'forum_rules_link' => '',
            'forum_image' => '',
            'forum_style' => 0,
            'display_subforum_list' => false,
            'display_on_index' => false,
            'forum_topics_per_page' => 0,
            'enable_indexing' => true,
            'enable_icons' => false,
            'enable_prune' => false,
            'enable_post_review' => true,
            'enable_quick_reply' => false,
            'prune_days' => 7,
            'prune_viewed' => 7,
            'prune_freq' => 1,
            'prune_old_polls' => false,
            'prune_announce' => false,
            'prune_sticky' => false,
            'forum_password' => '',
            'forum_password_confirm' => '',
            'forum_password_unset' => false,
            'forum_options' => 0,
            'show_active' => true,
        );

        $sql = 'SELECT forum_name FROM ' . FORUMS_TABLE;
        $result = $this->db->sql_query($sql);
        $rows = $this->db->sql_fetchrowset($result);
        $this->db->sql_freeresult($result);
        $forum_exist = 0;
        foreach ($rows as $row) {
            if ($row['forum_name'] == $forum_name) {
                $forum_exist = true;
            }
        }

        $user_id = $event['user_id'];

        if (!$forum_exist) {
            \acp_forums::update_forum_data($forum_data);
            global $cache;
            $cache->destroy('sql', FORUMS_TABLE);
            $forum_perm_from = 1;
            if ($forum_perm_from) {
                copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
            }
            $auth->acl_clear_prefetch();
            for ($i = 1; $i <= 7; $i++) {
                switch ($i) {
                    case 1:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Нужен совет или помощь",
                            "Здесь вы можете получить совет или помощь по какому-нибудь вопросу."
                        );
                        break;
                    case 2:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Срочно",
                            "Здесь вы можете создавать наиболее важные темы, требующие быстрого ответа или решения проблемы."
                        );
                        break;
                    case 3:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Вопросы ЖКХ",
                            "Здесь решаются вопросы, касающиеся ЖКХ услуг."
                        );
                        break;
                    case 4:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Общее собрание",
                            "Здесь организуются собрания, сборы, голосования."
                        );
                        break;
                    case 5:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "План работы по обслуживанию дома",
                            "Здесь вы можете просмотреть расписание работ по обслуживанию дома"
                        );
                        break;
                    case 6:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Соседи по дому",
                            "Здесь вы можете посмотреть список зарегистрированных жильцов дома"
                        );
                        break;
                    case 7:
                        $this->create_subforum(
                            $forum_data['forum_id'],
                            $user_id,
                            "Разное",
                            "Здесь находится информация различного вида"
                        );
                        break;
                }
            }
        } else {
            $sql = "SELECT forum_id FROM " . FORUMS_TABLE . " WHERE forum_name = " . "'" . $forum_name . "'";
            $result = $this->db->sql_query($sql);
            $rows = $this->db->sql_fetchrowset($result);
            $forum_data['forum_id'] = $rows[0]['forum_id'];
            $this->db->sql_freeresult($result);
            for ($i = 1; $i <= 7; $i++) {
                switch ($i) {
                    case 1:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 1);
                        break;
                    case 2:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 2);
                        break;
                    case 3:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 3);
                        break;
                    case 4:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 4);
                        break;
                    case 5:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 5);
                        break;
                    case 6:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 6);
                        break;
                    case 7:
                        $this->give_forum_perm($user_id, $forum_data['forum_id'] + 7);
                        break;
                }
            }
        }
        $this->give_forum_perm($user_id, $forum_data['forum_id']);
    }

    public function create_subforum($parent_id, $user_id, $subforum_name, $forum_desc)
    {

        global $cache, $auth;

        $forum_data = array(
            'parent_id' => $parent_id,
            'forum_type' => FORUM_POST,
            'type_action' => '',
            'forum_status' => ITEM_UNLOCKED,
            'forum_parents' => '',
            'forum_name' => $subforum_name,
            'forum_link' => '',
            'forum_link_track' => false,
            'forum_desc' => $forum_desc,
            'forum_desc_uid' => '',
            'forum_desc_options' => 7,
            'forum_desc_bitfield' => '',
            'forum_rules' => '',
            'forum_rules_uid' => '',
            'forum_rules_options' => 7,
            'forum_rules_bitfield' => '',
            'forum_rules_link' => '',
            'forum_image' => '',
            'forum_style' => 0,
            'display_subforum_list' => false,
            'display_on_index' => false,
            'forum_topics_per_page' => 0,
            'enable_indexing' => true,
            'enable_icons' => false,
            'enable_prune' => false,
            'enable_post_review' => true,
            'enable_quick_reply' => false,
            'prune_days' => 7,
            'prune_viewed' => 7,
            'prune_freq' => 1,
            'prune_old_polls' => false,
            'prune_announce' => false,
            'prune_sticky' => false,
            'forum_password' => '',
            'forum_password_confirm' => '',
            'forum_password_unset' => false,
            'forum_options' => 0,
            'show_active' => true,
        );
        \acp_forums::update_forum_data($forum_data);
        $cache->destroy('sql', FORUMS_TABLE);
        $forum_perm_from = $parent_id;
        if ($forum_perm_from) {
            copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
        }
        $auth->acl_clear_prefetch();
        $this->give_forum_perm($user_id, $forum_data['forum_id']);

    }

    public function give_forum_perm($user_id, $forum_id)
    {
        $sql = 'INSERT INTO ' . ACL_USERS_TABLE . $this->db->sql_build_array('INSERT', array(
                'user_id' => $user_id,
                'forum_id' => $forum_id,
                'auth_role_id' => 15
            ));

        $this->db->sql_query($sql);

    }
}
