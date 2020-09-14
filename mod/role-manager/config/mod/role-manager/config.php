<?php

/* Application used by this mod */
$GLOBALS['config']['mod']['role-manager']['application']='admin';
/* Actions used by this mod */
$GLOBALS['config']['mod']['role-manager']['actions']=array('role');
/* Load action config */
foreach ($GLOBALS['config']['mod']['role-manager']['actions'] as $action)
{
	if (stream_resolve_include_path($GLOBALS['config']['path_config'].'mod/role-manager/'.$action.'/config.php'))
	{
		include_once($GLOBALS['config']['path_config'].'mod/role-manager/'.$action.'/config.php');
		new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_config'].'mod/role-manager/'.$action.'/config.php', 'mod/login');
	}
}

?>
