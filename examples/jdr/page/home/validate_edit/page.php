<?php

$lang=$GLOBALS['lang']['home']['validate_edit'];
if (!isset($Visitor->getPage()->getParameters()['id']) && !isset($_POST['stat']) && !isset($_POST['value']) && !isset($_POST['strict']))
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

if (is_numeric($_POST['value']))
{
	$_POST['value']=(int)$_POST['value'];
}

if ($_POST['stat']==='name' || $_POST['stat']==='hp' || $_POST['stat']==='mana' || $_POST['stat']=='ap' || $_POST['stat']=='max_hp' || $_POST['stat']=='max_mana' || $_POST['stat']=='max_ap')
{
	if (!$_POST['strict'])
	{
		$method=$this->getGet($_POST['stat']);
		$_POST['value']=$Character->$method()+$_POST['value'];
	}
	$Character=new \character\Character(array_merge($Character->table(), array($_POST['stat'] => $_POST['value'])));
	$Character->change();
}
else
{
	$Attributes=$Character->retrieveAttributes();
	if (!$_POST['strict'])
	{
		$method=$this->getGet($_POST['stat']);
		$_POST['value']=$Attributes->$method()+$_POST['value'];
	}
	$Attributes=new \character\Attributes(array_merge($Attributes->table(), array($_POST['stat'] => $_POST['value'])));
	$Attributes->change();
}

$Notification=new \user\Notification(array(
	'type'    => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'play_character', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))));
exit();

?>