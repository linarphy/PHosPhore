<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update-validate']['action']];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']];

$Parameters=$Visitor->getPage()->getParameters();
if (isset($Parameters['id']))
{
	$id=(int)$Parameters['id'];
}
else
{
	new \exception\Error($lang['error']['no_id'], 'page');
	header('location :'.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

if (isset($_POST['perm-action']) && isset($_POST['perm-application']) && isset($_POST['perm-role']))
{
	$action=$_POST['perm-action'];
	$application=$_POST['perm-application'];
	$role=$_POST['perm-role'];
}
else
{
	new \exception\Error($lang['error']['missing_parameters'], 'page');
	header('location :'.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['update']['action'],
		$GLOBALS['config']['route_parameter'] => array(
			'id' => $id,
		),
	)));
	exit();
}

$Permission=new \user\Permission(array(
	'id' => $id,
));
try
{
	$Permission->retrieve();
}
catch (\exception\Warning $error)
{
	new \exception\Error($lang['error']['retrieve'].$error->getMessage(), 'page', 0, $error);
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

if (empty($action) || empty($application) || empty($role))
{
	new \exception\Error($lang['error']['empty_parameters'], 'page');
	header('location: '.$Router->createLink(array(
		'application'                         => $config_mod['application'],
		'action'                              => $config_mod['update']['action'],
		$GLOBALS['config']['route_parameter'] => array(
			'id' => $id,
		),
	)));
	exit();
}

if ($Permission->getApplication() && $Permission->getAction())
{
	$newPermission=new \user\Permission(array(
		'id'          => $id,
		'role'        => $role,
		'application' => $application,
		'action'      => $action,
	));
	$newPermission->change();
	new \exception\Notice($lang['success'], 'page');
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_SUCCESS,
		'content' => $lang['success'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}
else
{
	new \exception\Error($lang['error']['badformed_permission'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

?>
