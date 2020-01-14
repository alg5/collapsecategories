<?php
/**
*
* @author Alg
* @version v 1.0.0. Alg$
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace alg\collapsecategories\acp;

class acp_collapsecategories_blocks_info
{
 public function module()
	{
			return array(
					'filename'	=> '\alg\collapsecategories\acp\acp_collapsecategories_blocks_module',
					'title'		=> 'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS',
					'modes'		=> array(
							'settings'	=> array(
									'title'	=> 'ACP_COLLAPSECATEGORIES_SETTINGS_BLOCKS',
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
