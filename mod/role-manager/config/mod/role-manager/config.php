<?php

/* Application used by this mod */
$GLOBALS['config']['mod']['role-manager']['application']='admin';
/* Role which can access to the pages */
$GLOBALS['config']['mod']['role-manager']['access_role']='admin';
/* Actions used by this mod */
$GLOBALS['config']['mod']['role-manager']['actions']=array('role', 'add', 'delete', 'add-validate', 'update', 'update-validate', 'delete-all');
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
