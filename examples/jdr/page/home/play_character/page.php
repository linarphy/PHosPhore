<?php

$lang=$GLOBALS['lang']['home']['play_character'];

if (!isset($Visitor->getPage()->getParameters()['id']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
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
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_not_your'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}

if ($Visitor->isAdmin($Character))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_WARNING,
		'content' => $GLOBALS['lang']['home']['warning_admin'],
	));
	$Notification->sendNotification($Visitor->getPage()->getPageElement(), new \content\pageelement\html\HTMLNotification);
}

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$CharacterSheet=new \content\pageelement\html\CharacterSheet($Character);
$Attributes=$Character->retrieveAttributes();
$attributes=array();
foreach ($Attributes::AV_ATTR as $attribute)
{
	$roll=$Attributes->calcRoll($attribute);
	$attributes[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/play_character/attribute.html',
		'elements' => array(
			'name'             => $lang[$attribute],
			'critical_failure' => $roll['critical_failure'],
			'failure'          => $roll['failure'],
			'success'          => $roll['success'],
			'critical_success' => $roll['critical_success'],
		),
	));
}

$action_links=array();
foreach (array('atk_hth', 'atk_dis', 'atk_mag', 'hea_mag') as $element)
{
	$action_links['href_'.$element]=$Router->createLink(array('application' => 'home', 'action' => 'action', $GLOBALS['config']['route_parameter'] => array('name' => $element, 'id' => $Character->getId())));
}
$admin='';
if ($Visitor->isAdmin($Character))
{
	$admin=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/play_character/admin.html',
		'elements' => array(
			'href_chest'  => $Router->createLink(array('application' => 'home', 'action' => 'open_chest', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))),
			'title_chest' => $lang['title_chest'],
			'chest'       => $lang['chest'],
		),
	));
}

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/play_character/template.html',
	'elements' => array(
		'title'           => $lang['title'],
		'character_sheet' => $CharacterSheet,
		'actions_title'   => $lang['actions_title'],
		'atk'             => $lang['atk'],
		'atk_hth'         => $lang['hth'],
		'href_atk_hth'    => $action_links['href_atk_hth'],
		'title_atk_hth'   => $lang['title_atk_hth'],
		'atk_dis'         => $lang['range'],
		'href_atk_dis'    => $action_links['href_atk_dis'],
		'title_atk_dis'   => $lang['title_atk_dis'],
		'atk_mag'         => $lang['magic'],
		'href_atk_mag'    => $action_links['href_atk_mag'],
		'title_atk_mag'   => $lang['title_atk_mag'],
		'healing'         => $lang['healing'],
		'href_hea_mag'    => $action_links['href_hea_mag'],
		'title_hea_mag'   => $lang['title_hea_mag'],
		'hea_mag'         => $lang['magic'],
		'rolls'           => $lang['rolls'],
		'attributes'      => $attributes,
		'href_delete'     => $Router->createLink(array('application' => 'home', 'action' => 'delete', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))),
		'title_delete'    => $lang['title_delete'],
		'delete'          => $lang['delete'],
		'href_edit'       => $Router->createLink(array('application' => 'home', 'action' => 'edit', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))),
		'title_edit'      => $lang['title_edit'],
		'edit'            => $lang['edit'],
		'admin'           => $admin,
	),
));

$PageElement->addElement('body', $content);

?>