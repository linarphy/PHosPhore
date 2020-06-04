<?php

$lang=$GLOBALS['lang']['home']['open_chest'];

$PageElement=$Visitor->getPage()->getPageElement();

$Parameters=$Visitor->getPage()->getParameters();

if (!isset($Parameters['id']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}
if (!is_numeric($Parameters['id']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}

$Character=new \character\Character(array(
	'id' => $Parameters['id'],
));
$Character->retrieve();

if (!$Visitor->authorizationModification($Character))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_no_right'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}

$PageElement->getElement('head')->addElement('title', $lang['title']);

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/open_chest/template.html',
	'elements' => array(
		'action'  => $Router->createLink(array('application' => 'home', 'action' => 'validate_open_chest', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))),
		'legend'  => $lang['legend'],
		'quality' => $lang['quality'],
		'max'     => '7',
		'min'     => '1',
		'value'   => $Character->getLevel()+1,
		'submit'  => $lang['submit'],
	),
));

$PageElement->addElement('body', $content);

?>