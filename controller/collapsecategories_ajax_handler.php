<?php
/**
*
* @author Alg
* @version 1.0.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\CollapseCategories\controller;

/**
* @ignore
*/

/*if (!defined('IN_PHPBB'))
{
	exit;
}*/

class collapsecategories_ajax_handler
{
protected $thankers = array();
	public function __construct(\phpbb\db\driver\driver_interface $db, $forums_cat_status_table)
	{
		$this->db = $db;
		$this->forums_cat_status_table = $forums_cat_status_table;

	}

	public function main($forum, $status, $user)
	{
		if($status)
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
}
