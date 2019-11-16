<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}


$lang = array_merge($lang, array(
    'DEMO_PAGE'			=> 'Dyno',
    'DEMO_HELLO'		=> 'Dyno %s!',
    'DEMO_GOODBYE'		=> 'Dyno %s!',

    'ACP_DEMO_TITLE'			=> 'Dyno Module',
    'ACP_DEMO'					=> 'Settinger',
    'ACP_DEMO_GOODBYE'			=> 'Should say dyno?',
    'ACP_DEMO_SETTING_SAVED'	=> 'Im a dynosaur!',
));
