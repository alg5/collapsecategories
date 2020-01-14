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
	'ACP_COLLAPSECATEGORIES'			=> 'Вы можете добавлять/менять/удалять сворачиваемые блоки. <br />Блок обязательно  должен иметь уникальный ID',
	'ACP_COLLAPSECATEGORIES_BLOCKS_EXPLAIN'		=> 'Сворачивание категорий',
	'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON'	=> 'Общие настройки',
	'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS'	=> 'Настройки сворачиваемых блоков',

	'ACP_COLLAPSECATEGORIES_SETTINGS_STYLES'		=>  'Настройка стилей',
	'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS'		=>  'Настройка сворачиваемых блоков',
	'ACP_COLLAPSECATEGORIES_ONLY_ON_INDEX'		=> 'Сворачивание категорий только на главной странице',
	'ACP_COLLAPSECATEGORIES_ONLY_ON_INDEX_EXPLAIN'	=> 'Выберите сворачивание категорий только на главной странице или на любой странице форума',
	'ACP_COLLAPSECATEGORIES_ID_ARR'			=> 'ID сворачиваемых блоков',
	'ACP_COLLAPSECATEGORIES_ID_ARR_EXPLAIN'		=> 'Перечислите ID сворачиваемых блоков через запятую',
	'ACP_COLLAPSECATEGORIES_CLASS_ARR'		=> 'Названия классов сворачиваемых блоков',
	'ACP_COLLAPSECATEGORIES_CLASS_ARR_EXPLAIN'	=> 'Перечислите названия классов сворачиваемых блоков через запятую',
	'ACP_COLLAPSECATEGORIES_STYLE_COLLAPSIBLE'	=> 'Сворачиваемый стиль',
	'ACP_COLLAPSECATEGORIES_SAVED'			=> 'Настройки сохранены успешно',
	'ACP_COLLAPSECATEGORIES_BLOCKS_TITLE'		 => 'Сворачиваемые блоки',
	'ACP_COLLAPSECATEGORIES_NO_BLOCKS_TITLE'		=> 'Нет сворачиваемых блоков',
	'ACP_COLLAPSECATEGORIES_BLOCK_ID_CAPTION'		=> 'ID',
	'ACP_COLLAPSECATEGORIES_TEXT_OPEN_CAPTION'		 => 'Текст для развернутого блока',
	'ACP_COLLAPSECATEGORIES_TEXT_CLOSE_CAPTION'		 => 'Текст для свёрнутого блока',
	'ACP_COLLAPSECATEGORIES_CUSTOM_CSS_CAPTION'		=> 'Кастомный класс',
	'ACP_COLLAPSECATEGORIES_BLOCK_ID_CAPTION_EXPLAIN'		=> 'ID сворачиваемого блока',
	'ACP_COLLAPSECATEGORIES_TEXT_OPEN_CAPTION_EXPLAIN'		=> 'Текст для развернутого блока',
	'ACP_COLLAPSECATEGORIES_TEXT_CLOSE_CAPTION_EXPLAIN'		=> 'Текст для свёрнутого блока',
	'ACP_COLLAPSECATEGORIES_CUSTOM_CSS_CAPTION_EXPLAIN'		=> 'Кастомный класс',
	'ACP_COLLAPSECATEGORIES_DELETED'						=> 'Сворачиваемый блок удалён',
	'ACP_COLLAPSECATEGORIES_ADD_NEW_BLOCK'					 => 'Добавить  блок',
	'ACP_COLLAPSECATEGORIES_TEXT_OPEN_DEFAULT'				 => 'Скрыть',
	'ACP_COLLAPSECATEGORIES_TEXT_CLOSE_DEFAULT'			=> 'Показать',  
	'ACP_COLLAPSECATEGORIES_ERROR_ID_MISSED'			 => 'ID сворачиваемого блока не задан',
	'ACP_COLLAPSECATEGORIES_ERROR_ID_EXISTS'			=> 'Блок %s уже находится в таблице',
	'ACP_COLLAPSECATEGORIES_BLOCK_ADDED_SUCCESSFULLY'  => 'Сворачиваемый блок добавлен', 
	'ACP_COLLAPSECATEGORIES_BLOCK_EDITED_SUCCESSFULLY'  => 'Сворачиваемый блок изменён', 
	'ACP_COLLAPSECATEGORIES_BTN_EDIT'					=> 'Редактировать ',
	'ACP_COLLAPSECATEGORIES_BTN_DELETE'					=> 'Удалить ',
	'ACP_COLLAPSECATEGORIES_BTN_SAVE'					=> 'Сохранить ',
	'ACP_COLLAPSECATEGORIES_BTN_CANCEL'					=> 'Вернуть ',

	));

