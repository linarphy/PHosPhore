<?php

$lang=$GLOBALS['lang']['page'][$GLOBALS['config']['mod']['role-manager']['application']][$GLOBALS['config']['mod']['role-manager']['add-validate']['action']];
$config_mod=$GLOBALS['config']['mod']['role-manager'];

switch(strtoupper($config_mod['add']['method']))
{
	case 'GET':
		$Parameters=$Visitor->getPage()->getParameters();
		if (isset($Parameters['role']) && isset($Parameters['application']) && isset($Parameters['action']))
		{
			$role=$Parameters['role'];
			$application=$Parameters['application'];
			$action=$Parameters['action'];
		}
		else
		{
			new \exception\Error($lang['error']['no_parameters'], 'page');
			header('location: '.$Router->createLink(array(
				'application' => $config_mod['application'],
				'action'      => $config_mod['role']['action'],
			)));
			exit();
		}
		break;
	case 'POST':
		if (isset($_POST['role']) && isset($_POST['application']) && isset($_POST['action']))
		{
			$role=$_POST['role'];
			$application=$_POST['application'];
			$action=$_POST['action'];
		}
		else
		{
			new \exception\Error($lang['error']['no_parameters'], 'page');
			header('location: '.$Router->createLink(array(
				'application' => $config_mod['application'],
				'action'      => $config_mod['role']['action'],
			)));
			exit();
		}
		break;
	default:
		new \exception\FatalError($lang['error']['unknown_method'], 'page');
		break;
}

if (empty($role) || empty($application) || empty($action))
{
	new \exception\Error($lang['error']['invalid_parameters'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

$Permission=new \user\Permission(array(
	'role_name'   => $role,
	'application' => $application,
	'action'      => $action,
));

$Permission->create();

new \exception\Notice($lang['success'], 'page');
$Notification=new \user\Notification(array(
	'type'    => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->createLink(array(
	'application' => $config_mod['application'],
	'action'      => $config_mod['role']['action'],
)));
exit();

?>
