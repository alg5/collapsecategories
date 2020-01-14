<?php
/**
 *
 * Collapse Categories. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, alg
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace alg\collapsecategories;

/**
 * Collapse Categories Extension base
 *
 * It is recommended to remove this file from
 * an extension if it is not going to be used.
 */
class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
			global $phpbb_extension_manager;
			return !$phpbb_extension_manager->is_enabled('alecto/CollapseCategoriesLight');
	}
}
