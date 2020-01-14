<?php
/**
*
* @author Alg
* @version 1.0.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\collapsecategories\controller;

/**
* @ignore
*/

/*if (!defined('IN_PHPBB'))
{
	exit;
}*/

class collapsecategories_handler
{
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\request\request_interface $request, \phpbb\config\config $config, \phpbb\controller\helper $controller_helper, $forums_cat_status_table, $collapse_blocks_table)
	{
			$this->db = $db;
			$this->user = $user;
			$this->request = $request;
			$this->config = $config;
			$this->controller_helper = $controller_helper;
			$this->forums_cat_status_table = $forums_cat_status_table;
			$this->collapse_blocks_table = $collapse_blocks_table;
			$this->error = [];

	}

	public function main($forum, $status, $user)
	{
			if ($status)
			{
					$sql = "INSERT IGNORE  INTO " . $this->forums_cat_status_table .
															" (forum_id, user_id) " .
															" VALUES ( " . $forum . ", " .  $user  . ")" ;
					$this->db->sql_query($sql);
			}
			else
			{
							$sql = "DELETE FROM " . $this->forums_cat_status_table .
													' WHERE forum_id=' . $forum . ' AND user_id=' . $user;
					$this->db->sql_query($sql);
			}
			$json_response = new \phpbb\json_response;
					$json_response->send($sql);

	}
	public function delete_block()
	{
		$this->user->add_lang_ext('alg/collapsecategories', 'info_acp_collapsecategories');
		$block_id = $this->request->variable('block_id', '');
		$row_id = $this->request->variable('row_id', 0);
		$sql = "DELETE FROM " . $this->collapse_blocks_table  . " WHERE block_id='" . $block_id . "'";
		$this->db->sql_query($sql);
		$result = $this->db->sql_affectedrows($sql);
		if ($result == 0)
		{
				$this->error[] = array('ERROR' => $this->user->lang['INCORRECT_SEARCH']);
				$json_response = new \phpbb\json_response;
				$json_response->send($this->error);

				return;
		}
		$this->return = array(
				'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_DELETED'] ,
				'ROW_ID'		=> $row_id ,
		);
		$json_response = new \phpbb\json_response;
		$json_response->send($this->return);

	}
	public function add_block()
	{
	   $this->user->add_lang_ext('alg/collapsecategories', 'info_acp_collapsecategories');
		$block_id = $this->request->variable('block_id', '', true);
		$text_open = $this->request->variable('text_open', '', true);
		$text_close = $this->request->variable('text_close', '', true);
		$custom_css = $this->request->variable('custom_css', '', true);
		if ($block_id == '')
		{
				$this->error[] = array('ERROR' => $this->user->lang['ACP_COLLAPSECATEGORIES_ERROR_ID_MISSED']);
		}
		if (!sizeof($this->error))
		{
			$sql = "SELECT count(block_id) counter FROM " . $this->collapse_blocks_table  . " WHERE block_id='" . $block_id . "'";
			$result = $this->db->sql_query($sql);
			$counter = (int) $this->db->sql_fetchfield('counter');
			$this->db->sql_freeresult($result);
			if ($counter >0)
			{
				$this->error[] = array('ERROR' => sprintf($this->user->lang['ACP_COLLAPSECATEGORIES_ERROR_ID_EXISTS'], $block_id ));
			}
		}
		 if (sizeof($this->error))
		 {
			$json_response = new \phpbb\json_response;
			 $json_response->send($this->error);
		 }
		$sql = "INSERT IGNORE  INTO " . $this->collapse_blocks_table .
												" (block_id, text_open, text_close, custom_css) " .
												" VALUES ( '" . $block_id . "'" .
																", '" .  $text_open  . "'" .
																", '" .  $text_close  . "'" .
																", '" .  $custom_css  . "'" .
															")" ;
		$this->db->sql_query($sql);
		$this->return = array(
				'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_BLOCK_ADDED_SUCCESSFULLY'] ,
				'BLOCK_ID'		=> $block_id ,
				'TEXT_OPEN'		=> $text_open ,
				'TEXT_CLOSE'		=> $text_close ,
				'CUSTOM_CSS'		=> $custom_css ,
			);
	   $json_response = new \phpbb\json_response;
		$json_response->send($this->return);
	}

	public function edit_block()
	{
	   $this->user->add_lang_ext('alg/collapsecategories', 'info_acp_collapsecategories');
		$block_id = $this->request->variable('block_id', '', true);
		$text_open = $this->request->variable('text_open', '', true);
		$text_close = $this->request->variable('text_close', '', true);
		$custom_css = $this->request->variable('custom_css', '', true);
		$sql = "UPDATE " . $this->collapse_blocks_table .
					" SET text_open='" .   $text_open . "'" .
							", text_close='" .  $text_close  . "'" .
						   ", custom_css='" .  $custom_css  . "'" .
					" WHERE block_id='" . $block_id  .  "'" ;
		$this->db->sql_query($sql);
		$this->return = array(
				'SQL' =>$sql,
				'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_BLOCK_EDITED_SUCCESSFULLY'] ,
				'BLOCK_ID'		=> $block_id ,
				'TEXT_OPEN'		=> $text_open ,
				'TEXT_CLOSE'		=> $text_close ,
				'CUSTOM_CSS'		=> $custom_css ,
			);
	   $json_response = new \phpbb\json_response;
		$json_response->send($this->return);

	}

	public function save_options()
	{
		$this->user->add_lang_ext('alg/collapsecategories', 'info_acp_collapsecategories');

		$collapsecategories_only_on_index = $this->request->variable('collapsecategories_only_on_index', 1);
		$this->config->set('collapsecategories_only_on_index', $collapsecategories_only_on_index);

		$collapsecategories_id_arr = $this->request->variable('collapsecategories_id_arr', '');
		//TODO check to valid string
		$this->config->set('collapsecategories_id_arr', $collapsecategories_id_arr);

		$collapsecategories_class_arr = $this->request->variable('collapsecategories_class_arr', '');
		//TODO check to valid string
		$this->config->set('collapsecategories_class_arr', $collapsecategories_class_arr);

		//STYLES
		$collapsecategories_style_ids =  request_var('ids', array('', ''));
		$collapsecategories_style_ids = implode(",", $collapsecategories_style_ids);
		$this->config->set('collapsecategories_style_ids', $collapsecategories_style_ids);

//        $sql = "UPDATE  " . STYLES_TABLE . " SET style_collapsible=0";
//        $this->db->sql_query($sql);
//$rows = $this->get_styles();
//$style_collapsible_ids = $this->request->variable('style_collapsible',  '');
//        $collapsecategories_style_ids = '';
//        $style_collapsible_ids =  request_var('ids', array('', ''));
//        if(sizeof($style_collapsible_ids)  > 0)
//        {
//
////
////            //Read all selected styles
//            $sql = "SELECT style_id FROM " . STYLES_TABLE  .
//                    " WHERE " . $this->db->sql_in_set('style_id', $style_collapsible_ids, false);
//	$sql = 'UPDATE ' . STYLES_TABLE . ' SET  style_collapsible=1'  . " WHERE " . $this->db->sql_in_set('style_id', $style_collapsible_ids, false);
//            $this->db->sql_query($sql);
//            $collapsecategories_style_ids = implode(",", $style_collapsible_ids);
//            $this->config->set('collapsecategories_style_ids', $collapsecategories_style_ids);
//
//        //print_r('$collapsecategories_only_on_index = ' . $collapsecategories_only_on_index);
//        }

		$this->return = array(
			 'style_collapsible_ids' => $collapsecategories_style_ids,
	//            'SQL' => $sql,
			'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_SAVED'] ,
		);
		$json_response = new \phpbb\json_response;
		$json_response->send($this->return);
	}
	public function get_router_path($action)
	{
		$action_path = 'alg_collapsecategories_controller_' . $action;
		//print_r('$action = ' . $action . '; $action_path = ' . $action_path);
		return $this->controller_helper->route($action_path);
	}
	public function get_styles()
	{
			$sql = 'SELECT *
					FROM ' . STYLES_TABLE;
			$result = $this->db->sql_query($sql);

			$rows = $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			return $rows;
	}
}
