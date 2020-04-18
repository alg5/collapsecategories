<?php
/**
*
* @author Alg
* @version $Id: acp_live_search.php,v 1.0.0. Alg$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\collapsecategories\acp;

class acp_collapsecategories_common_info
{
	public function module()
	{
		return array(
			'filename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_common_module',
			'title'		=> 'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON'. '',
			'modes'		=> array(
			'settings'	=> array(
					'title'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_COMMON',
					'auth'	=> 'ext_alg/collapsecategories && acl_a_board',
					'cat'	=> array('ACP_COLLAPSECATEGORIES')
				),
			),
		);
	}
	function install()
	{
	}

	function uninstall()
	{
	}
}
