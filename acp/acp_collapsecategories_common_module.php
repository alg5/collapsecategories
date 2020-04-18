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
class acp_collapsecategories_common_module
{
	public function main($id, $mode)
	{
		global $db, $user, $template, $config, $phpbb_container;

		$this->db = $db;
		$this->user = $user;
		$this->template = $template;
		$this->config = $config;
		$this->phpbb_container = $phpbb_container;
		$this->controller = $this->phpbb_container->get('alg.collapsecategories.collapsecategories_handler');

		$this->user->add_lang('acp/common');
		$this->user->add_lang('acp/styles');
		$this->tpl_name = 'acp_collapsecategories_common';
		$this->page_title = $user->lang('ACP_COLLAPSECATEGORIES');
		$this->set_styles_list();

		$this->template->assign_vars(array(
			'S_COLLAPSE__ON_INDEX_ONLY'	=> (bool) $this->config['collapsecategories_only_on_index'],
			'S_ADM_COLLAPSECATEGORIES_PAGE'	=> true,
			'S_SHOW_SAVE'	=> (bool) $this->config['collapsecategories_save'],
			'U_COLLAPSECATEGORIES_PATH_SAVE'	=> $this->controller->get_router_path('save'),
		));
	}
	protected function get_styles()
	{
		$sql = 'SELECT *
				FROM ' . STYLES_TABLE;
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $rows;
	}

	/**
	* List installed styles
	*/
	protected function set_styles_list()
	{
		//Get collapsibaled styles id
		$ids = $this->config['collapsecategories_style_ids'];
		// Get all installed styles
		$styles = $this->get_styles();
		// Show styles list
		foreach ($styles as $style)
		{
			$pos = strpos($ids, $style['style_id']);
			$this->template->assign_block_vars('styles_list', array(
				'ID'                       => $style['style_id'],
				'NAME'                   => $style['style_name'],
				'IS_COLLAPSIBLE'    =>  $pos !== false,
				)
			);
		}
	}
}
