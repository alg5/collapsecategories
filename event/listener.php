<?php
/**
 *
 * @package CollapseCategories
 * @copyright (c) 2014 alg, alg 
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace alg\CollapseCategories\event;

/**
* @ignore
*/
/*if (!defined('IN_PHPBB'))
{
	 exit;
}*/

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
	{

		global $table_prefix;

		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->db = $db;
		$this->config = $config;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->first_row = 0;
		if (!defined('FORUMS_CAT_STATUS_TABLE'))
		{
			define('FORUMS_CAT_STATUS_TABLE', $table_prefix . 'forums_cat_status');
		}

	}

	static public function getSubscribedEvents()
	{
		return array(
				'core.display_forums_modify_template_vars'		=> 'display_forums_modify_template_vars',
				'core.display_forums_modify_category_template_vars'		=> 'display_forums_modify_category_template_vars',
		);
	}

	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$row = $event['row'];
		$forum_cat_status = 0;
		$this->first_row++;
		if($this->user->data['is_registered'] &&  ($this->first_row == 1 || $forum_row['S_IS_CAT'] || $forum_row['S_NO_CAT'] ))
		{
				$sql = 'SELECT count(*) as counter  FROM ' . FORUMS_CAT_STATUS_TABLE .
								' WHERE forum_id=' . $forum_row['FORUM_ID'] . ' AND user_id=' . $this->user->data['user_id'];
				$result = $this->db->sql_query($sql);
				$forum_cat_status =  $this->db->sql_fetchfield('counter');
				$this->db->sql_freeresult($result);
		}
		$forum_row = array_merge($forum_row, array(
			'S_FORUM_CAT_STATUS' => $forum_cat_status,
			'S_USER_ID' => $this->user->data['user_id'],
		));
		$event['forum_row'] = $forum_row;
	}
	public function display_forums_modify_category_template_vars($event)
	{

		$cat_row = $event['cat_row'];
		$forum_cat_status = 0;
		if($this->user->data['is_registered'] &&  ( $cat_row['S_IS_CAT'] || $cat_row['S_NO_CAT'] ))
		{
				$sql = 'SELECT count(*) as counter FROM ' . FORUMS_CAT_STATUS_TABLE .
								' WHERE forum_id=' . $cat_row['FORUM_ID'] . ' AND user_id=' . $this->user->data['user_id'];
				$result = $this->db->sql_query($sql);
				$forum_cat_status =  $this->db->sql_fetchfield('counter');
				$this->db->sql_freeresult($result);
		}
		$cat_row = array_merge($cat_row, array(
			'S_FORUM_CAT_STATUS' => $forum_cat_status,
			'S_USER_ID' => $this->user->data['user_id'],
		));
		$event['cat_row'] = $cat_row;

//		print_r( $event['cat_row']);
	}

}
