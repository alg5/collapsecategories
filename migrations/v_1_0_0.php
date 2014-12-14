<?php
/**
*
* @package CollapseCategories
* @copyright (c) alg
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\CollapseCategories\migrations;


class v_1_0_0 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['CollapseCategories']) && version_compare($this->config['CollapseCategories'], '1.0.3', '>=');
	}

	static public function depends_on()
	{
			return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return 	array(
		'add_tables' => array(
				$this->table_prefix . 'forums_cat_status' => array(
					'COLUMNS'		=> array(
						'forum_id'		=> array('UINT', 0),
						'user_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('forum_id', 'user_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables'	=> array($this->table_prefix . 'forums_cat_status'),
		);
	}

	public function update_data()
	{
		return array(

			// Current version
			array('config.add', array('CollapseCategories', '1.0.3')),

		);
	}
	public function revert_data()
	{
		return array(
			// remove from configs
			// Current version
			array('config.remove', array('CollapseCategories')),

		);
	}
}
