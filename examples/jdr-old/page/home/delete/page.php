<?php

$lang=$GLOBALS['lang']['home']['delete'];
if (!isset($Visitor->getPage()->getParameters()['id']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_missing_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}

if (!is_numeric($Visitor->getPage()->getParameters()['id']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}

$Character=new \character\Character(array(
	'id' => $Visitor->getPage()->getParameters()['id'],
));
$Character->retrieve();

if (!$Visitor->authorizationModification($Character))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_no_right'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}

$Character->delete();

$Notification=new \user\Notification(array(
	'type'    => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'].' ('.$Character->displayName().')',
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
exit();

?>