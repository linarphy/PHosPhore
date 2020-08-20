<?php

/* The application used by the mod */
$GLOBALS['config']['mod']['login']['application']='user';
/* Actions list of the mod */
$GLOBALS['config']['mod']['login']['actions']=array('login', 'login-validate', 'register', 'register-validate');
/* Name of the role which can register and log in */
$GLOBALS['config']['mod']['login']['log_role']=$GLOBALS['guest_role'];
/* Name of the role added to logged member */
$GLOBALS['config']['mod']['login']['role']='member';
/* Link to the page displayed after login */
$GLOBALS['config']['mod']['login']['after_login']=array();
/* Link to the page displayed after register */
$GLOBALS['config']['mod']['login']['after_register']=array();
/* ACTIONS */
foreach ($GLOBALS['config']['mod']['login']['actions'] as $action)
{
	if (stream_resolve_include_path($GLOBALS['config']['path_config'].'mod/login/'.$action.'/config.php'))
	{
		include_once($GLOBALS['config']['path_config'].'mod/login/'.$action.'/config.php');
		new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_config'].'mod/login/'.$action.'/config.php', 'mod/login');
	}
}

?>
