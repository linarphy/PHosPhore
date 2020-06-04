<?php

$lang=$GLOBALS['lang']['home']['action'];

$PageElement=$Visitor->getPage()->getPageElement();

if (!isset($Visitor->getPage()->getParameters()['name']) || !isset($Visitor->getPage()->getParameters()['id']))
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
		'content' => $lang['error_no_right'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'hub')));
	exit();
}

if (!in_array($Visitor->getPage()->getParameters()['name'], array('atk_hth', 'atk_dis', 'atk_mag', 'hea_mag')))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_ERROR,
		'content' => $lang['error_unknown_value'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'play_character', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))));
	exit();
}

switch ($Visitor->getPage()->getParameters()['name'])
{
	case 'atk_hth':
		$url='attack/hth/';
		break;
	case 'atk_dis':
		$url='attack/range/';
		break;
	case 'atk_hth':
		$url='attack/magic/';
		break;
	case 'atk_hth':
		$url='healing/magic/';
		break;
	default:
		$Notification = new \user\Notification(array(
			'type' => \user\Notification::TYPE_ERROR,
			'content' => $lang['error_unknown_value'],
		));
		$Visitor->getPage()->addNotificationSession($Notification);
		header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'play_character', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))));
		exit();
		break;
}

$XML=simplexml_load_file('./asset/xml/action/'.$url.$Visitor->getConfiguration('lang').'.xml');

if ($Character->getAp()<(int)$XML->ap)
{
	
		$Notification = new \user\Notification(array(
			'type' => \user\Notification::TYPE_WARNING,
			'content' => $lang['error_not_enought_ap'],
		));
		$Visitor->getPage()->addNotificationSession($Notification);
		header('location: '.$Router->createLink(array('application' => 'home', 'action' => 'play_character', $GLOBALS['config']['route_parameter'] => array('id' => $Character->getId()))));
		exit();
}

$PageElement->getElement('head')->addElement('title', $lang['title']);

$turns=array();
foreach ($XML->operation->turn as $turn)
{
	switch ((string)$turn['type'])
	{
		case 'choice':
			$limit=array();
			foreach ($turn->limit as $limit)
			{
				$limit[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'home/action/close.html',
					'elements' => array(
						'display' => (string)$limit->close,
					),
				));
			}
			$attributes=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'home/action/choice.html',
				'elements' => array(
					'type'       => $lang['choice'],
					'limit'      => $limit,
				),
			));
	}
	$turns[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/action/turn.html',
		'elements' => array(
			'description' => (string)$turn->description,
			'attributes'  => $attributes,
		),
	));
}

$operation=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/action/operation.html',
	'elements' => array(
		'name'     => (string)$XML->name,
		'ap'       => $lang['ap'],
		'ap_value' => (string)$XML->ap,
		'turns'    => $turns,
	),
));

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/action/template.html',
	'elements' => array(
		'warning'    => $lang['warning'],
		'operation'  => $operation,
		'href'       => $Router->createLink(array('application' => 'home', 'action' => 'waiting_action')),
		'title'      => $lang['link_title'],
		'link'       => $lang['link'],
	),
));

$PageElement->addElement('body', $content);

?>