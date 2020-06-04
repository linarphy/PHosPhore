<?php

$lang=$GLOBALS['lang']['home']['validate_creation_character'];

if (!isset($_POST['name']) && !isset($_POST['race']) && !isset($_POST['class']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'creation_character')));
	exit();
}
if (!isset($_POST['attr_str']))
{
	$str=0;
}
else
{
	$str=(int)$_POST['attr_str'];
}
if (!isset($_POST['attr_dex']))
{
	$dex=0;
}
else
{
	$dex=(int)$_POST['attr_dex'];
}
if (!isset($_POST['attr_con']))
{
	$con=0;
}
else
{
	$con=(int)$_POST['attr_con'];
}
if (!isset($_POST['attr_int_']))
{
	$int_=0;
}
else
{
	$int_=(int)$_POST['attr_int_'];
}
if (!isset($_POST['attr_cha']))
{
	$cha=0;
}
else
{
	$cha=(int)$_POST['attr_cha'];
}
if (!isset($_POST['attr_agi']))
{
	$agi=0;
}
else
{
	$agi=(int)$_POST['attr_agi'];
}
if (!isset($_POST['attr_mag']))
{
	$mag=0;
}
else
{
	$mag=(int)$_POST['attr_mag'];
}
if (!isset($_POST['attr_acu']))
{
	$acu=0;
}
else
{
	$acu=(int)$_POST['attr_acu'];
}
if (empty($_POST['name']) && !is_numeric($_POST['race']) && !is_numeric($_POST['class']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'creation_character')));
	exit();
}
$attributes=array();
foreach (\character\Attributes::AV_ATTR as $attribute)
{
	$attributes[$attribute]=$_POST['attr_'.$attribute];
}
$Attributes=new \character\Attributes($attributes);
$Attributes->create();
$id_attributes=$Attributes->getId();
$Item=new \item\Consumable(array(
	'id' => 105,
));
$Item->retrieve();
$Character->addToInventory($Item, 50);
$Character=new \character\Character(array(
	'name'          => $_POST['name'],
	'id_race'       => $_POST['race'],
	'id_class'      => $_POST['class'],
	'id_attributes' => $id_attributes,
	'id_inventory'  => \character\Inventory::determineNewId(),
	'id_author'     => $Visitor->getId(),
));
$Character->init();
$Character->create();


$Notification = new \user\Notification(array(
	'type' => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
exit();

?>