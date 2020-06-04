<?php

$lang=$GLOBALS['lang']['generator']['character'];

$PageElement=$Visitor->getPage()->getPageElement();

if (!isset($Visitor->getPage()->getParameters()['name']) || !isset($Visitor->getPage()->getParameters()['class']) || !isset($Visitor->getPage()->getParameters()['race']))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_miss_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	exit();
}
else
{
	$name=$Visitor->getPage()->getParameters()['name'];
	$rpgClass=$Visitor->getPage()->getParameters()['class'];
	$race=$Visitor->getPage()->getParameters()['race'];
}
if (empty($name) || !is_numeric($rpgClass) || !is_numeric($race))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_value_parameters'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	exit();
}
foreach (\character\Attributes::AV_ATTR as $attribute)
{
	if (isset($Visitor->getPage()->getParameters()[$attribute]))
	{
		if (!isset($attributes))
		{
			$attributes=array();
		}
		$attributes[$attribute]=$Visitor->getPage()->getParameters()[$attribute];
	}
}

$character=array(
	'name'      => $name,
	'id_class'  => $rpgClass,
	'id_race'   => $race,
	'id_author' => $Visitor->getId(),
);
if (isset($attributes))
{
	foreach (\character\Attributes::AV_ATTR as $attribute)
	{
		if (!isset($attributes[$attribute]))
		{
			$attributes[$attribute]=0;
		}
	}
	$Attributes=new \character\Attributes($attributes);
	$Attributes->create();
	$character['id_attributes']=$Attributes->getId();
}
$Character=new \character\Character($character);
$Character->init();

$content=new \content\pageelement\html\CharacterSheet($Character);

$PageElement->addElement('body', $content);

$Character->retrieveAttributes()->delete();
$Character->retrieveMaxAttributes()->delete();

?>