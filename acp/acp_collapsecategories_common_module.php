<?php
/**
*
* @author Alg
* @version 1.0.0.0
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
			global $db, $user, $template, $request, $config, $phpbb_container, $table_prefix;

			$this->db = $db;
			$this->user = $user;
			$this->template = $template;
			$this->request = $request;
			$this->config = $config;
			$this->phpbb_container = $phpbb_container;
			$this->table_prefix = $table_prefix;
			$this->controller = $this->phpbb_container->get('alg.collapsecategories.collapsecategories_handler');

			$this->user->add_lang('acp/common');
			$this->user->add_lang('acp/styles');
			$this->tpl_name = 'acp_collapsecategories_common';
			$this->page_title = $user->lang('ACP_COLLAPSECATEGORIES');
			$this->set_styles_list();

			$sql = 'SELECT * FROM ' . $this->table_prefix . 'collapse_blocks ORDER BY block_id';
			$result = $this->db->sql_query($sql);
			foreach ($result as $row)
			{
				$template->assign_block_vars('clpsblocks', array(
						'BLOCK_ID'		=> $row['block_id'],
						'TEXT_OPEN'		=> $row['text_open'],
						'TEXT_CLOSE'		=> $row['text_close'],
						'CUSTOM_CSS'		=> '' /*$row['custom_css']*/,

				));
			  }

			$this->template->assign_vars(array(
				'S_COLLAPSE__ON_INDEX_ONLY'	=> true,
				'S_ADM_COLLAPSECATEGORIES_PAGE'	=> true,
				'S_SHOW_ONLY_ON_INDEX'	=> (bool) $this->config['collapsecategories_only_on_index'],
				'S_ID_ARR'			    => $this->config['collapsecategories_id_arr'],
				'S_CLASS_ARR'			    => $this->config['collapsecategories_class_arr'],
				'U_COLLAPSECATEGORIES_PATH_SAVE'	=> $this->controller->get_router_path('save'),
	//               'U_COLLAPSECATEGORIES_PATH_DELETE'	=> $this->controller->get_router_path('delete'),
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
	//                print_r('id =' . $style['style_id'] . '; pos = ' . $pos . '***\n/n/r' );

				$this->template->assign_block_vars('styles_list', array(
					'ID'                       => $style['style_id'],
					'NAME'                   => $style['style_name'],
					'IS_COLLAPSIBLE'    =>  $pos !== false,
					)
				);
			}

	}
}
