<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['delete-all']['action']];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete-all']['action']];

$Parameters=$Visitor->getPage()->getParameters();
$PermissionManager=new \user\PermissionManager(\core\DBFactory::MysqlConnection());

$infos=array();

if ($Parameters['perm-application'])
{
	$infos['application']=$Parameters['perm-application'];
	if ($Parameters['role'])
	{
		$infos['role']=$Parameters['role'];
	}
}
else if ($Parameters['role'])
{
	$infos['role']=$Parameters['role'];
}
else
{
	new \exception\Warning($lang['delete_all'], 'page');
}

$number_permission=$PermissionManager->countBy($infos);
if ($number_permission==0)
{
	new \exception\Error($lang['no_delete'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

$PermissionManager->deleteBy($infos, array());

new \exception\Notice($lang['success_begin'].$number_permission.$lang['success_end'], 'page');
$Notification=new \user\Notification(array(
	'type' => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success_begin'].$number_permission.$lang['success_end'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array(
	'application' => $config_mod['application'],
	'action'      => $config_mod['role']['action'],
)));
exit();

?>
