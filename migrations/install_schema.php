<?php
/**
 *
 * Collapse Categories. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, alg
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace alg\collapsecategories\migrations;

class install_schema extends \phpbb\db\migration\migration
{
//	public function effectively_installed()
//	{
//		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_acme');
//	}

	static public function depends_on()
	{
		return array('\alg\collapsecategories\migrations\install_acp_module');
	}

	public function update_schema()
	{
		return 	array
		(
			'add_tables' => array
			(
				$this->table_prefix . 'forums_cat_status' => array
				(
					'COLUMNS'		=> array
					(
							'forum_id'		=> array('UINT', 0),
							'user_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('forum_id', 'user_id'),
				),
	//				),
				
				$this->table_prefix . 'collapse_blocks' => array
				(
					'COLUMNS'		=> array
					(
							'block_id'		=>  array('VCHAR:60', ''),
							'text_open'	=>  array('VCHAR:60', ''),
							'text_close'	=>  array('VCHAR:60', ''),
							'custom_css'	=>  array('VCHAR:60', ''),),
					'PRIMARY_KEY'	=> array('block_id'),
				),
			 ),
		);
	}

	public function revert_schema()
	{
			return 	array(
					'drop_tables'	=> array($this->table_prefix . 'forums_cat_status'),
					'drop_tables'	=> array($this->table_prefix . 'collapse_blocks'),
	//                    'drop_columns' => array($this->table_prefix . 'styles' => array('style_collapsible'),
	//            ), 
			);
	}
}
