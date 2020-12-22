<?php

$lang=$GLOBALS['lang']['user']['validate_register'];

if (!isset($_POST['nickname']) || !isset($_POST['password']) || !isset($_POST['password2']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_form'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'register')));
	exit();
}
if (empty($_POST['nickname']) || empty($_POST['password']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_form'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'register')));
	exit();
}
$Manager=new \user\VisitorManager(\core\DBFactory::MysqlConnection());
if ($Manager->countBy(array('nickname' => trim($_POST['nickname'])), array('nickname' => '='))>0)
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_nickname'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'register')));
	exit();
}
if ($_POST['password']!==$_POST['password2'])
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_missmatch'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'register')));
	exit();
}
if (!isset($_POST['email']))
{
	$_POST['email']='';
}
$newVisitor=new \user\Visitor(array(
	'nickname'          => trim($_POST['nickname']),
	'avatar'            => $GLOBALS['config']['default_avatar'],
	'date_registration' => date($GLOBALS['config']['db_date_format']),
	'date_login'        => date($GLOBALS['config']['db_date_format']),
	'banned'            => $GLOBALS['config']['default_status'],
	'email'             => $_POST['email'],
));
$newVisitor->registration($_POST['password'], $GLOBALS['config']['default_role']);
$newVisitor=new \user\Visitor(array(
	'nickname' => trim($_POST['nickname']),
));

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
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_unknown'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'user', 'action' => 'register')));
	exit();
}

?>