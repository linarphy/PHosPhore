<?php

$PageElement=$Visitor->getPage()->getPageElement();

$Parameters=$Visitor->getPage()->getParameters();

if (!(isset($Parameters['quality'])))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	exit();
}
if (!is_numeric($Parameters['quality']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	exit();
}

$quality=(int)$Parameters['quality'];

if (!in_array($quality, \item\Item::AV_QUAL_INT))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_unknown_quality'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	exit();
}

$chest=array();
$nbr_item=getRandomWeightedElement($GLOBALS['config']['generator']['chest']['nbr_item_weigth']);
for ($i=0; $i < $nbr_item; $i++)
{
	do
	{
		$real_quality=$quality+getRandomWeightedElement($GLOBALS['config']['generator']['chest']['quality_modifier_weigth']);
	} while (!in_array($real_quality, \item\Item::AV_QUAL_INT) || $real_quality===0);
	$Item=\item\Item::generateItem(array(
		'type'    => 'random',
		'quality' => $real_quality,
	));
	$chest[]=$Item;
}

$content=\content\pageelement\xml\XMLSerializer::generateXml($chest);
$PageElement->addElement('content', $content);

?>