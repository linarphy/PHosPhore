<?php

$lang=$GLOBALS['lang']['home']['edit'];
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

$PageElement=$Visitor->getPage()->getPageElement();

$options_stat=array();
foreach (array('hp', 'mana', 'ap', 'max_hp', 'max_mana', 'max_ap', 'name', 'str', 'dex', 'con', 'int_', 'cha', 'agi', 'mag', 'acu', 'name') as $stat)
{
	$options_stat[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/edit/option.html',
		'elements' => array(
			'value'   => $stat,
			'display' => $lang[$stat],
		),
	));
}

$PageElement->getElement('head')->addElement('title', $lang['title']);

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/edit/template.html',
	'elements' => array(
		'action'       => $Router->createLink(array('application' => 'home', 'action' => 'validate_edit', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))),
		'method'       => 'POST',
		'legend'       => $lang['legend'],
		'stat'         => $lang['stat'],
		'options_stat' => $options_stat,
		'value'        => $lang['value'],
		'strict'       => $lang['strict'],
		'submit'       => $lang['submit'],
	),
));

$PageElement->addElement('body', $content);

?>