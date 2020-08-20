<?php

foreach ($GLOBALS['config']['mod']['login']['actions'] as $action)
{
	$Permission=new \user\Permission(array(
		'role_name'   => $GLOBALS['config']['mod']['login']['log_role'],
		'application' => $GLOBALS['config']['mod']['login']['application'],
		'action'      => $GLOBALS['config']['mod']['login'][$action]['action'],
	));
	$Permission->create();
}

?>
