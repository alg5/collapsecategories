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

if (!defined('IN_PHPBB'))
{
	exit;
}

class CollapseCategories_ajax_handler
{
protected $thankers = array();
   public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, $phpbb_root_path, $php_ext, \phpbb\request\request_interface $request, $table_prefix)
    {
		$this->config = $config;
		$this->db = $db;
		$this->auth = $auth;
        $this->template = $template;
        $this->user = $user;
		$this->cache = $cache;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->request = $request;
		if (!defined('FORUMS_CAT_STATUS_TABLE'))
		{
			define('FORUMS_CAT_STATUS_TABLE', $table_prefix . 'forums_cat_status');
		}

    }

	public function main($forum, $status, $user)
	{
        if($status)
        {
            $sql = "INSERT IGNORE  INTO " . FORUMS_CAT_STATUS_TABLE .
                                " (forum_id, user_id) " .
                                " VALUES ( " . $forum . ", " .  $user  . ")" ;
            $this->db->sql_query($sql);		
        }
        else
        {
                $sql = "DELETE FROM " . FORUMS_CAT_STATUS_TABLE . 
                            ' WHERE forum_id=' . $forum . ' AND user_id=' . $user;
	        $this->db->sql_query($sql);		
        }
        $json_response = new \phpbb\json_response;
		   // $json_response->send('OK');
		    $json_response->send($sql);

	}
 
}
