<?php
/** 
*
* collapcecategories [Russian]
*
* @package collapcecategories
* @copyright (c) 2014 alg
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
    'ACP_COLLAPSECATEGORIES_SETTINGS'		=> 'Настройки',
    'ACP_COLLAPSECATEGORIES'			=> 'Сворачивание категорий',
    'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON'	=> 'Общие настройки',
    'ACP_COLLAPSECATEGORIES_ONLY_ON_INDEX'		=> 'Сворачивание категорий только на главной странице',
    'ACP_COLLAPSECATEGORIES_ONLY_ON_INDEX_EXPLAIN'	=> 'Выберите сворачивание категорий только на главной странице или на любой странице форума',

));
