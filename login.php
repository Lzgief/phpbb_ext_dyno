<?php

ini_set('display_errors', '0');

define('IN_PHPBB', true);
define('PHPBB_ROOT_PATH', './');
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
include ($phpbb_root_path . 'includes/acp/acp_forums.' . $phpEx);
include ($phpbb_root_path . 'includes/functions_acp.' . $phpEx);
include ($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

global $db, $cache, $auth;

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup('ucp');

// Initialize  login result array
$login = array();

// Handle logouot button if pressed
if(isset($_POST['logout']) && $user->data['user_id'] != ANONYMOUS)
{
	$user->session_kill();
}

if(isset($_POST['register']) && $user->data['user_id'] == ANONYMOUS)
{
	$username = request_var('username', '', true);
	$password = request_var('password', '', true);
	$email = request_var('email', '', true);
	$forum_name = request_var('address', '', true);
	$autologin	= (!empty($_POST['autologin'])) ? true : false;
	$user_row = array(
    'username'              => $username,
    'user_password'         => phpbb_hash($password),
    'user_email'            => $email,
    'group_id'              => 2,
    'user_timezone'         => 'UTC',
    'user_lang'             => 'ru',
	'user_type'				=> 0,
    'user_actkey'           => $user_actkey,
    'user_regdate'          => time(),
    'user_inactive_reason'  => 0,
    'user_inactive_time'    => 0,
    );
	
    $user_id = user_add($user_row);
    
    
    $sql = "SELECT forum_id FROM ". FORUMS_TABLE ." WHERE forum_name = " . "'" . $forum_name ."'";
    $result = $db->sql_query($sql);
    $rows = $db->sql_fetchrowset($result);
    $forum_data['forum_id'] = $rows[0]['forum_id'];
    $db->sql_freeresult($result);
    for($i = 1; $i <= 7; $i++) {
        switch ($i) {
            case 1:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                       'user_id'        => $user_id,
                       'forum_id'       => $forum_data['forum_id']+1,
                       'auth_role_id'   => 17
                    ));
                    $db->sql_query($sql);
                    break;
            case 2:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+2,
                        'auth_role_id'   => 17
                    ));
                $db->sql_query($sql);
                break;
            case 3:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+3,
                        'auth_role_id'   => 17
                    ));
                $db->sql_query($sql);
                break;
            case 4:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+4,
                        'auth_role_id'   => 17
                    ));
                $db->sql_query($sql);
                break;
            case 5:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+5,
                        'auth_role_id'   => 17
                    ));
                $db->sql_query($sql);
                break;
            case 6:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+6,
                        'auth_role_id'   => 17
                    ));
                $db->sql_query($sql);
                break;
            case 7:
                $sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
                        'user_id'        => $user_id,
                        'forum_id'       => $forum_data['forum_id']+7,
                        'auth_role_id'   => 17
                       ));
                $db->sql_query($sql);
                break;
            }
        }
		$sql = 'INSERT INTO ' . ACL_USERS_TABLE  . $db->sql_build_array('INSERT', array(
            'user_id'        => $user_id,
            'forum_id'       => $forum_data['forum_id'],
            'auth_role_id'   => 17
        ));

    $db->sql_query($sql);
    }
   
}

/* Send headers
header('Content-type: text/html; charset=UTF-8');
header('Cache-Control: private, no-cache="set-cookie"');
header('Expires: 0');
header('Pragma: no-cache');

// Check if user has tried to log in and greet him if login is successful
if((!empty($login) && $login['status'] == LOGIN_SUCCESS) || $user->data['user_id'] != ANONYMOUS)
{
	// Reset permissions data if user has just logged in
	if(!empty($login))
	{
		$auth->acl($user->data);
	}
	echo 'Hello, ' . get_username_string('full', $user->data['user_id'], $user->data['username'], $user->data['user_colour']);
	echo '<form method="post" action="login.php">';
	echo '	<input type="submit" name="logout" value="LOGOUT" />';
	echo '</form>';
}
else
{
	// Handle login errors if exist and display error message right above the login form
	if(isset($login['error_msg']) && $login['error_msg'])
	{
		$err = $user->lang[$login['error_msg']];
		// Assign admin contact to some error messages
		if ($login['error_msg'] == 'LOGIN_ERROR_USERNAME' || $login['error_msg'] == 'LOGIN_ERROR_PASSWORD')
		{
			$err = (!$config['board_contact']) ? sprintf($user->lang[$login['error_msg']], '', '') : sprintf($user->lang[$login['error_msg']], '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">', '</a>');
		}
				
		echo $err . '<br />';
	}
	
	// Show login form
	echo '<form method="post" action="login.php">';
	echo $user->lang['USERNAME'] . ':&nbsp;<input type="text" name="username" id="username" size="10" title="' . $user->lang['USERNAME'] . '" /> ';
	echo $user->lang['PASSWORD'] . ':&nbsp;<input type="password" name="password" id="password" size="10" title="' . $user->lang['PASSWORD'] . '" />';
	echo '	<input type="submit" name="login" value="LOGIN" />';
	if ($config['allow_autologin'])
	{
		echo '  <br /><input type="checkbox" name="autologin" /> ' . $user->lang['LOG_ME_IN'];
	}
	echo '</form>';
}

*/



