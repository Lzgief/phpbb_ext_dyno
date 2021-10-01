<?php
	define('IN_PHPBB', true);
	define('PHPBB_ROOT_PATH', './');
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);

	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'includes/functions_user.' . $phpEx);	
	include ($phpbb_root_path . 'includes/acp/acp_forums.' . $phpEx);
    include ($phpbb_root_path . 'includes/functions_acp.' . $phpEx);
    include ($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

	global $cache, $db, $auth;

	$forum_name = request_var('fias_val', '', true);
		
    $forum_data = array(
        'parent_id'                => 1 ,
        'forum_type'            => FORUM_POST,
        'type_action'            => '',
        'forum_status'            => ITEM_UNLOCKED,
        'forum_parents'            => '',
        'forum_name'            => $forum_name,
        'forum_link'            => '',
        'forum_link_track'        => false,
        'forum_desc'            => '',  
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
    $result = $db->sql_query($sql);
    $rows = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);
    $forum_exist = 0;
    foreach ($rows as $row){
        if($row['forum_name'] == $forum_name) {
            $forum_exist = true;
        }
    }
	
	$_SESSION['forum_exist'] = $forum_exist;
	
    if(!$forum_exist){
        \acp_forums::update_forum_data($forum_data);
        $cache->destroy('sql', FORUMS_TABLE);
        $forum_perm_from = 1;
        if ($forum_perm_from) {
            copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
        }
       
		$forum_parent_id = $forum_data['forum_id'];
        for($i = 1; $i <= 7; $i++) {
            switch ($i) {
                case 1:
                    $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Нужен совет или помощь",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            => "Здесь вы можете получить совет или помощь по какому-нибудь вопросу.",
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
				
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
				case 2:
					$forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Срочно",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            => "Здесь вы можете создавать наиболее важные темы, требующие быстрого ответа или решения проблемы.",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
				case 3:
                    $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Вопросы ЖКХ",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            => "Здесь решаются вопросы, касающиеся ЖКХ услуг.",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;					
					case 4:
                   $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Общее собрание",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            =>"Здесь организуются собрания, сборы, голосования.",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
                case 5:
                    $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "План работы по обслуживанию дома",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            =>"Здесь вы можете просмотреть расписание работ по обслуживанию дома",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
                case 6:
                    $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Соседи по дому",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            =>  "Здесь вы можете посмотреть список зарегистрированных жильцов дома",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
                case 7:
                    $forum_data = array(
                        'parent_id'                => $forum_parent_id,
                        'forum_type'            => FORUM_POST,
                        'type_action'            => '',
                        'forum_status'            => ITEM_UNLOCKED,
                        'forum_parents'            => '',
                        'forum_name'            => "Разное",
                        'forum_link'            => '',
                        'forum_link_track'        => false,
                        'forum_desc'            => "Здесь находится информация различного вида",
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
                    \acp_forums::update_forum_data($forum_data);
                    $cache->destroy('sql', FORUMS_TABLE);
                    $forum_perm_from = $forum_parent_id;
                    if ($forum_perm_from) {
                        copy_forum_permissions($forum_perm_from, $forum_data['forum_id'], false);
                    }
                   
					break;
            }
					
		}
		
	}
?>