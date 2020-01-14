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

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['collapsecategories']) && version_compare($this->config['collapsecategories'], '2.0.*', '>=');

	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314');
	}

	public function update_data()
	{
		return array(
		//ADD ACP module
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_COLLAPSECATEGORIES'
			)),
			array('module.add', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_common_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON',
					'module_mode'		=> 'collapsecategories_common',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
				),
			)),
			array('module.add', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_blocks_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS',
					'module_mode'		=> 'collapsecategories_blocks',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
				),
			)),
		//ADD to Config
		//current version
		array('config.add', array('collapsecategories', '2.0.0')),
		array('config.add', array('collapsecategories_only_on_index', '1')),                   
//                                        array('config.add', array('collapsecategories_id_arr', '')),
//                                        array('config.add', array('collapsecategories_class_arr', '')),
//                                        array('config.add', array('collapsecategories_style_ids', '')),
		);
	}

public function revert_data()
	{
	return array(
				// remove from configs
				// Current version
				array('config.remove', array('collapsecategories')),
				array('config.remove', array('collapsecategories_only_on_index')),
//                    array('config.remove', array('collapsecategories_id_arr')),
//                    array('config.remove', array('collapsecategories_class_arr')),
//                   array('config.remove', array('collapsecategories_style_ids')),
// remove from ACP modules
			array('if', array(
				array('module.exists', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_common_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON',
					'module_mode'		=> 'collapsecategories',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
					),
				)),
				array('module.remove', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_common_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON',
					'module_mode'		=> 'collapsecategories',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
					),
				)),
			)),
			array('if', array(
				array('module.exists', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_blocks_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS',
					'module_mode'		=> 'collapsecategories',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
					),
				)),
				array('module.remove', array('acp', 'ACP_COLLAPSECATEGORIES', array(
					'module_basename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_blocks_module',
					'module_langname'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS',
					'module_mode'		=> 'collapsecategories',
					'module_auth'		=> 'ext_alg/collapsecategories && acl_a_board',
					),
				)),
			)),
			array('module.remove', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_COLLAPSECATEGORIES')),

		);
	}
}
