<?php
/**
 *
 * @package collapsecategories
 * @copyright (c) 2014 alg, alg
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace alg\collapsecategories\event;

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

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request_interface $request, \phpbb\config\config $config, $forums_cat_status_table, $collapse_blocks_table)
	{
			$this->db = $db;
			$this->template = $template;
			$this->user = $user;
			$this->request = $request;
			$this->config = $config;

			$this->forums_cat_status_table = $forums_cat_status_table;
			$this->collapse_blocks_table = $collapse_blocks_table;
			$this->first_row = 0;
			$this->is_style_collapsebaled = true;
			$this->collapsecategories_only_on_index = true;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'                                                  => 'user_setup',
			'core.display_forums_modify_template_vars'              => 'display_forums_modify_template_vars',
			'core.display_forums_modify_category_template_vars' => 'display_forums_modify_category_template_vars',
		);
	}
	public function user_setup($event)
	{

//                  return; //todo
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

		$sql = 'SELECT * FROM ' . $this->collapse_blocks_table;
		$result = $this->db->sql_query($sql);
		$collapse_blocks_ary = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
				$collapse_blocks_ary[] = $row;
		}
		$this->db->sql_freeresult($result);
		$this->collapse_blocks_ary = $collapse_blocks_ary;       

		$this->user->add_lang_ext('alg/collapsecategories', 'collapsecategories');

		$this->collapsecategories_only_on_index = $this->config['collapsecategories_only_on_index'];
		$lang_set_ext = $event['lang_set_ext'];
		$style_id = $event['style_id'];
		if (!$style_id )
		{
			$style_id = $event['user_data']['user_style'];
		}
		//print_r('user_style = ' .  $event['user_data']['user_style']);
		$style_ids = $this->config['collapsecategories_style_ids'];
		$pos = strrpos($style_ids, $style_id);
		$this->is_style_collapsebaled = ($pos !== false);

		$categories_collapsebaled =  (bool) $this->is_style_collapsebaled;
	//       print_r('$categories_collapsebaled :1= ' . $categories_collapsebaled . '$pos =' . $pos . ' $style_ids = ' . $style_ids . 'style_id=' .$style_id);
	//      print_r('***' .  (bool) $categories_collapsebaled . '***');
	   if ($categories_collapsebaled && $this->collapsecategories_only_on_index)
	//         if (true)

		{

			$f = $this->request->variable('f', 0);
			$t = $this->request->variable('t', 0);
			$p = $this->request->variable('p', 0);
	//            print_r('f = ' . $f);

			$categories_collapsebaled = (bool) !$f && !$t && !$p;   //Inpex page or custom pages
		}
		$this->template->assign_vars(array(
					'S_COLLAPSECATEGORIES_ONLY_ON_INDEX'	=> (bool)  $this->collapsecategories_only_on_index,
					'S_STYLE_COLLAPSEBALED'	=> (bool) $this->is_style_collapsebaled,
					'S_CATEGORIES_COLLAPSEBALED'	=> (bool) $categories_collapsebaled,
					'S_ID_ARR'	=>  $this->config['collapsecategories_id_arr'],
					'S_CLASS_ARR'	=>  $this->config['collapsecategories_class_arr'],
					'S_COLLAPSE_BLOCKS'	=>  json_encode($collapse_blocks_ary),

			));

	}
	public function display_forums_modify_template_vars($event)
	{
						//print_r($event);
	//                    if (!$this->is_style_collapsebaled)
	//                    {
	//                        return;
	//                    }
					$forum_row = $event['forum_row'];
	//                    print_r('forum_id = ' . $forum_row['FORUM_ID']);
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
//                    if (!$this->is_style_collapsebaled)
//                    {
//                        return;
//                    }            
                    $cat_row = $event['cat_row'];
//                                        print_r('cat_id = ' . $cat_row['FORUM_ID']);
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
