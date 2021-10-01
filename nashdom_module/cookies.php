<?php
/**
*
* @package Cookie and server settings tool
* @copyright (c) 2008 ktuk.net
* @copyright (c) 2011 phpbb.com
* @license GPL
*
*/

// Standard definitions/includes
$page_title = 'phpBB3 Cookies';
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$script_name = (isset($request) && ($request instanceof \phpbb\request\request_interface)) ? $request->server('SCRIPT_NAME', '') : $_SERVER['SCRIPT_NAME'];

$cookie_data = array();
$server_data = array();
$sent = request_var('sent', '');

// Gather cookie settings from config array
$cookie_data[] = $config['cookie_domain'];
$cookie_data[] = $config['cookie_name'];
$cookie_data[] = $config['cookie_path'];
$cookie_data[] = $config['cookie_secure'];

$server_data[] = $config['force_server_vars'];
$server_data[] = $config['script_path'];
$server_data[] = $config['server_name'];
$server_data[] = $config['server_port'];
$server_data[] = $config['server_protocol'];

$cookie_checked = ($cookie_data[3]) ? "checked = \"checked\"" : '';
$force_checked = ($server_data[0]) ? "checked = \"checked\"" : '';


if (!$sent)
{
   print "<html>
   <head><title>$page_title</title></head>
   <body>
   
   <form action=\"" . $script_name . "\" method=\"post\"
   <fieldset>
   <table>
      <tr><h2>Cookie Settings</h2></tr>
      <tr><td>Cookie Domain:</td><td><input type=\"text\" name=\"cookie_domain\" value=\"" . $cookie_data[0] . "\"></td></tr>
      <tr><td>Cookie Name:</td><td><input type=\"text\" name=\"cookie_name\" value=\"" . $cookie_data[1] . "\"></td></tr>
      <tr><td>Cookie Path:</td><td><input type=\"text\" name=\"cookie_path\" value=\"" . $cookie_data[2] . "\"></td></tr>
      <tr><td>Cookie Secure:</td><td><input type=\"checkbox\" name=\"cookie_secure\" value=\"1\" $cookie_checked ></td></tr>
   </table>

   <table>
      <tr><h2>Server Settings</h2></tr>
      <tr><td>Force Server Vars:</td><td><input type=\"checkbox\" name=\"force_server_vars\" value=\"1\"  $force_checked ></td></tr>
      <tr><td>Script Path:</td><td><input type=\"text\" name=\"script_path\" value=\"" . $server_data[1] . "\"></td></tr>
      <tr><td>Server Name:</td><td><input type=\"text\" name=\"server_name\" value=\"" . $server_data[2] . "\"></td></tr>
      <tr><td>Server Port:</td><td><input type=\"text\" name=\"server_port\" value=\"" . $server_data[3] . "\"></td></tr>
      <tr><td>Server Protocol:</td><td><input type=\"text\" name=\"server_protocol\" value=\"" . $server_data[4] . "\"></td></tr>
      <tr><td>Submit:</td><td><input type=\"submit\" name=\"sent\" value=\"submit\"></td></tr>
   </table>
   </fieldset>
   </body>
   <html>
   ";
}

if ($sent)
{
   $cookie_domain      = request_var('cookie_domain', '');
   $cookie_name      = request_var('cookie_name', '');
   $cookie_path      = request_var('cookie_path', '');
   $cookie_secure      = request_var('cookie_secure', 0);
   $force_server_vars   = request_var('force_server_vars', 0);
   $script_path      = request_var('script_path', '');
   $server_name      = request_var('server_name', '');
   $server_port      = request_var('server_port', 80);
   $server_protocol   = request_var('server_protocol', 'http://');

   $sql_ary = array(
       'cookie_domain'      => $cookie_domain,
       'cookie_name'      => $cookie_name,
       'cookie_path'      => $cookie_path,
       'cookie_secure'      => $cookie_secure,
       'force_server_vars'   => $force_server_vars,
       'script_path'      => $script_path,
       'server_name'      => $server_name,
       'server_port'      => $server_port,
       'server_protocol'   => $server_protocol
   );

   foreach ($sql_ary as $config_name => $config_value)
   {
      set_config($config_name, $config_value);
   }

   print "Settings are updated!";
   print "<meta http-equiv=\"refresh\" content=\"4;./cookie.php\">";
}