<?php
/**
*
* @author Alg
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\collapsecategories\controller;

class collapsecategories_handler
{
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\request\request_interface $request, \phpbb\config\config $config, \phpbb\controller\helper $controller_helper, $collapse_forums_cat_status_table, $collapse_blocks_table)
	{
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->config = $config;
		$this->controller_helper = $controller_helper;
		$this->collapse_forums_cat_status_table = $collapse_forums_cat_status_table;
		$this->collapse_blocks_table = $collapse_blocks_table;
		$this->error = [];
	}

	public function main($forum, $status, $user)
	{
		if ($status)
		{
			$sql = "INSERT IGNORE  INTO " . $this->collapse_forums_cat_status_table .
					" (forum_id, user_id) " .
					" VALUES ( '" . $forum . "', " .  $user  . ")" ;
			$this->db->sql_query($sql);
		}
		else
		{
			$sql = "DELETE FROM " . $this->collapse_forums_cat_status_table .
					" WHERE forum_id='" . $forum . "' AND user_id=" . $user;
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
		$icon_open = $this->request->variable('icon_open', '', true) == "on" ? 1 : 0;
		$text_close = $this->request->variable('text_close', '', true) ;
		$icon_close = $this->request->variable('icon_close', '', true) == "on" ? 1 : 0;
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
				" (block_id, text_open, text_close, icon_open, icon_close, custom_css) " .
				" VALUES ( '" . $block_id . "'" .
						", '" .  $text_open  . "'" .
						", '" .  $text_close  . "'" .
						", '" .  $icon_open  . "'" .
						", '" .  $icon_close  . "'" .
						", '" .  $custom_css  . "'" .
						")" ;
		$this->db->sql_query($sql);
		$this->return = array(
			'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_BLOCK_ADDED_SUCCESSFULLY'] ,
			'BLOCK_ID'		=> $block_id ,
			'TEXT_OPEN'		=> $text_open ,
			'TEXT_CLOSE'		=> $text_close ,
			'ICON_OPEN'		=> $icon_open ,
			'ICON_CLOSE'		=> $icon_close ,
			'CUSTOM_CSS'		=> $custom_css ,
		);
		$json_response = new \phpbb\json_response;
		$json_response->send($this->return);
	}

	public function edit_block()
	{
	   $this->user->add_lang_ext('alg/collapsecategories', 'info_acp_collapsecategories');
		$block_id = $this->request->variable('block_id', '', true);
		$icon_open = $this->request->variable('icon_open', '', true) ;
		$text_close = $this->request->variable('text_close', '', true) ;
		$icon_close = $this->request->variable('icon_close', '', true) ;
		$custom_css = $this->request->variable('custom_css', '', true);
		$sql = "UPDATE " . $this->collapse_blocks_table .
				" SET text_open='" .   $text_open . "'" .
						", text_close='" .  $text_close  . "'" .
						", icon_open='" .  $icon_open  . "'" .
						", icon_close='" .  $icon_close  . "'" .
						", custom_css='" .  $custom_css  . "'" .
				" WHERE block_id='" . $block_id  .  "'" ;
		$this->db->sql_query($sql);
		$this->return = array(
//			'SQL' =>$sql,
			'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_BLOCK_EDITED_SUCCESSFULLY'] ,
			'BLOCK_ID'		=> $block_id ,
			'TEXT_OPEN'		=> $text_open ,
			'TEXT_CLOSE'		=> $text_close ,
			'ICON_OPEN'		=> $icon_open ,
			'ICON_CLOSE'		=> $icon_close ,
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

		$collapsecategories_save = $this->request->variable('collapsecategories_save', 1);
		$this->config->set('collapsecategories_save', $collapsecategories_save);

		$collapsecategories_id_arr = $this->request->variable('collapsecategories_id_arr', '');
		//TODO check to valid string
		$this->config->set('collapsecategories_id_arr', $collapsecategories_id_arr);

		$collapsecategories_class_arr = $this->request->variable('collapsecategories_class_arr', '');
		//TODO check to valid string
		$this->config->set('collapsecategories_class_arr', $collapsecategories_class_arr);

		//STYLES
		$collapsecategories_style_ids =  $this->request->variable('ids', array('', ''));
		$collapsecategories_style_ids = implode(",", $collapsecategories_style_ids);
		$this->config->set('collapsecategories_style_ids', $collapsecategories_style_ids);
		$this->return = array(
			 'style_collapsible_ids' => $collapsecategories_style_ids,
			'MESSAGE'		=> $this->user->lang['ACP_COLLAPSECATEGORIES_SAVED'] ,
		);
		$json_response = new \phpbb\json_response;
		$json_response->send($this->return);
	}
	public function get_router_path($action)
	{
		$action_path = 'alg_collapsecategories_controller_' . $action;
		return $this->controller_helper->route($action_path);
	}
	public function get_styles()
	{
		$sql = 'SELECT * FROM ' . STYLES_TABLE;
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $rows;
	}
}
