<?php

$lang=$GLOBALS['lang']['page'][$GLOBALS['config']['mod']['role-manager']['application']][$GLOBALS['config']['mod']['role-manager']['delete']['action']];
$config_mod=$GLOBALS['config']['mod']['role-manager'];

$Parameters=$Visitor->getPage()->getParameters();
if (isset($Parameters['id']))
{
	$id=(int)$Parameters['id'];
}
else
{
	new \exception\Error($lang['error']['no_id'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
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
if ($Permission->getApplication() && $Permission->getAction())
{
	$Permission->delete();
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
	new \exception\Error($lang['error']['unknown_permission'].' '.$id, 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

?>
