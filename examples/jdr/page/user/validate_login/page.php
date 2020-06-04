<?php

$lang=$GLOBALS['lang']['user']['validate_login'];

if (!isset($_POST['nickname']) || !isset($_POST['password']))
{
	$Notification = new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_form'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'login')));
	exit();
}
$newVisitor=new \user\Visitor(array(
	'nickname' => trim($_POST['nickname']),
));
$newVisitor->retrieve();

if ($newVisitor->connection($_POST['password']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_SUCCESS,
		'content' => $lang['success'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}
else
{
	$Notification = new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_login'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'login')));
	exit();
}

?>