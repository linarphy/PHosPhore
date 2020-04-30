<?php

$lang=$GLOBALS['lang']['giveaway']['validate'];

if (!isset($_POST['0']))
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_exist_participant'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

if (!isset($_POST['nbr_winner']))
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_exist_winner'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

if (!is_numeric($_POST['nbr_winner']) || empty($_POST['nbr_winner']))
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_type'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

$nbr_winner=$_POST['nbr_winner'];
unset($_POST['nbr_winner']);

$max=0;
foreach ($_POST as $key => $value)
{
	if (is_numeric($key))
	{
		if ((int)$key>$max)
		{
			$max=(int)$key;
		}
	}
}

if ($nbr_winner<1 || $nbr_winner-1>$max)
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_value'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

$winner=htmlspecialchars($_POST[(string)random_int(0, $max)]);
$winners=array();
for ($i=0; $i < $nbr_winner; $i++)
{
	do
	{
		$winner=(string)random_int(0, $max);
	} while (!isset($_POST[$winner]));
	$winners[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'giveaway/validate/winner.html',
		'elements' => array(
			'congrat_start' => $lang['congrat_start'],
			'winner'        => htmlspecialchars($_POST[$winner]),
			'congrat_end'   => $lang['congrat_end'],
		),
	));
	unset($_POST[$winner]);
}

$Visitor->getPage()->getPageElement()->getElement('head')->addValueElement('css', 'asset/css/form.css');
$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', $lang['title']);

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'giveaway/validate/template.html',
	'elements' => array(
		'winners' => $winners,
	),
));

$Visitor->getPage()->getPageElement()->addElement('body', $Content);

?>