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

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, $forums_cat_status_table)
	{
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->forums_cat_status_table = $forums_cat_status_table;
		$this->first_row = 0;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'			=> 'user_setup',
			'core.display_forums_modify_template_vars'		=> 'display_forums_modify_template_vars',
			'core.display_forums_modify_category_template_vars'		=> 'display_forums_modify_category_template_vars',
		);
	}
	public function user_setup($event)
	{
		$sql = 'SELECT * FROM ' . $this->forums_cat_status_table .
						' WHERE  user_id=' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$cat_status_ary = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$cat_status_ary[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->cat_status_ary = $cat_status_ary;
		$this->user->add_lang_ext('alg/CollapseCategories', 'collapsecategories');

	}
	public function display_forums_modify_template_vars($event)
	{
		$forum_row = $event['forum_row'];
		$row = $event['row'];
		$forum_cat_status = 0;
		$this->first_row++;
		if($this->user->data['is_registered'] &&  ($this->first_row == 1 || $forum_row['S_IS_CAT'] || $forum_row['S_NO_CAT'] ))
		{
				$forum_cat_status =  $this->get_cat_status($forum_row['FORUM_ID']);
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
			$forum_cat_status =  $this->get_cat_status($cat_row['FORUM_ID']);
		}
		$cat_row = array_merge($cat_row, array(
			'S_FORUM_CAT_STATUS' =>  $forum_cat_status,
			'S_USER_ID' => $this->user->data['user_id'],
		));
		$event['cat_row'] = $cat_row;
	}
	private function get_cat_status($forum_id)
	{
		foreach ($this->cat_status_ary as $row)
		{
			if ($row['forum_id'] == $forum_id)
			{
				return 1;
			}
		}
		return 0;
	}
}
