<?php
/**
*
* @author Alg
* @version 2.*
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\collapsecategories\acp;

/**
* @package acp
*/
class acp_collapsecategories_blocks_module
{
	public function main($id, $mode)
	{
		global $db, $user, $template, $phpbb_container, $table_prefix;

		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->phpbb_container = $phpbb_container;
		$this->table_prefix = $table_prefix;
		$this->controller = $this->phpbb_container->get('alg.collapsecategories.collapsecategories_handler');

		$this->user->add_lang('acp/common');
		$this->user->add_lang('acp/styles');
		$this->tpl_name = 'acp_collapsecategories_blocks';
		$this->page_title = $user->lang('ACP_COLLAPSECATEGORIES');

		$sql = 'SELECT * FROM ' . $this->table_prefix . 'collapse_blocks ORDER BY block_id';
		$result = $this->db->sql_query($sql);
		foreach ($result as $row)
		{
			$template->assign_block_vars('clpsblocks', array(
					'BLOCK_ID'		=> $row['block_id'],
					'TEXT_OPEN'		=> $row['text_open'],
					'TEXT_CLOSE'	=> $row['text_close'],
					'ICON_OPEN'		=> $row['icon_open'],
					'ICON_CLOSE'	=> $row['icon_close'],					
					'CUSTOM_CSS'	=> $row['custom_css'],

			));
		  }

		$this->template->assign_vars(array(
			'S_ADM_COLLAPSECATEGORIES_PAGE'		=> true,
			'U_COLLAPSECATEGORIES_PATH_ADD'		=> $this->controller->get_router_path('add'),
			'U_COLLAPSECATEGORIES_PATH_EDIT'		=> $this->controller->get_router_path('edit'),
			'U_COLLAPSECATEGORIES_PATH_DELETE'	=> $this->controller->get_router_path('delete'),
		));
	}
}
