<?php

$lang=$GLOBALS['lang']['home']['validate_open_chest'];

$PageElement=$Visitor->getPage()->getPageElement();

$Parameters=$Visitor->getPage()->getParameters();

if (!isset($Parameters['id']) || !isset($_POST['quality']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}

if (!is_numeric($Parameters['id']) || !is_numeric($_POST['quality']))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}

$quality=(int)$_POST['quality'];
$Character=new \character\Character(array(
	'id' => $Parameters['id'],
));
$Character->retrieve();

if (!$Visitor->authorizationModification($Character))
{
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_no_right'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home')));
	exit();
}

$chest=array();
$nbr_item=getRandomWeightedElement($GLOBALS['config']['home']['validate_open_chest']['nbr_item_weigth']);
for ($i=0; $i < $nbr_item; $i++)
{
	do
	{
		$real_quality=$quality+getRandomWeightedElement($GLOBALS['config']['home']['validate_open_chest']['quality_modifier_weigth']);
	} while (!in_array($real_quality, \item\Item::AV_QUAL_INT) || $real_quality===0);
	$Item=\item\Item::generateItem(array(
		'type'    => 'random',
		'quality' => $real_quality,
	));
	$chest[]=$Item;
	$Character->addToInventory($Item->store());
}

$Notification=new \user\Notification(array(
	'type'    => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array('application' => 'home' , 'action' => 'play_character', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))));
exit();

?>