<?php

$lang=$GLOBALS['lang']['giveaway']['create'];

if (!isset($_POST['number_participant']))
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_exist'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

if (!is_numeric($_POST['number_participant']) || empty($_POST['number_participant']))
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_type'],
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

$nbr_participant=(int)$_POST['number_participant'];

if ($nbr_participant<1 || $nbr_participant>$GLOBALS['config']['giveaway']['nb_max_participants'])
{
	$Notification=new \user\Notification(array(
		'content' => $lang['error_value'].'[1-'.$GLOBALS['config']['giveaway']['nb_max_participants'].']',
		'type'    => \user\Notification::TYPE_ERROR,
	));
	$Visitor->getpage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink(array('application' => 'giveaway', 'action' => 'prepare')));
	exit();
}

$members=array();
for ($i=0; $i < $nbr_participant; $i++)
{
	$members[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'giveaway/create/member.html',
		'elements' => array(
			'name' => (string)$i,
		),
	));
}

$Visitor->getPage()->getPageElement()->getElement('head')->addValueElement('css', 'asset/css/form.css');
$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', $lang['title']);

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'giveaway/create/template.html',
	'elements' => array(
		'legend'         => $lang['legend'],
		'action'         => $Router->createLink(array('application' => 'giveaway', 'action' => 'validate')),
		'legend_members' => $lang['legend_members'],
		'members'        => $members,
		'label'          => $lang['label'],
		'max_winner'     => (string)$nbr_participant,
		'submit'         => $lang['submit'],
	),
));

$Visitor->getPage()->getPageElement()->addElement('body', $Content);

?>