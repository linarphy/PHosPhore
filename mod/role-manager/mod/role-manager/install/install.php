<?php

foreach ($GLOBALS['config']['mod']['role-manager']['actions'] as $action)
{
	$Permission=new \user\Permission(array(
		'role_name'   => $GLOBALS['config']['mod']['role-manager']['access_role'],
		'application' => $GLOBALS['config']['mod']['role-manager']['application'],
		'action'      => $GLOBALS['config']['mod']['role-manager'][$action]['action'],
	));
	$Permission->create();
}

?>
