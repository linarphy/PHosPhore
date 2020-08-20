<?php

$config_mod=$GLOBALS['config']['mod']['login'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['login-validate']['action']];
$lang_mod=$GLOBALS['lang']['mod']['login'];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['login-validate']['action']];

switch (strtoupper($config_mod['login']['method']))
{
	case 'GET':
		$Parameters=$Visitor->getPage()->getParameters();
		if (isset($Parameters['nickname']) && isset($Parameters['password']))
		{
			$nickname=$Parameters['nickname'];
			$password=$Parameters['password'];
		}
		else
		{
			new \exception\Error($lang['error']['no_credential'], 'page');
			header('location: '.$Router->createLink(array(
				'application' => $config_mod['application'],
				'action'      => $config_mod['login']['action'],
			)));
			exit();
		}
		break;
	case 'POST':
		if (isset($_POST['nickname']) && isset($_POST['password']))
		{
			$nickname=$_POST['nickname'];
			$password=$_POST['password'];
		}
		else
		{
			new \exception\Error($lang['error']['no_credential'], 'page');
			header('location: '.$Router->createLink(array(
				'application' => $config_mod['application'],
				'action'      => $config_mod['login']['action'],
			)));
			exit();
		}
		break;
	default:
		new \exception\FatalError($lang_mod['unknown_method'], 'page');
		break;
}

if (empty($password) || empty($nickname))
{
	new \exception\Error($lang['error']['empty_credential'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['login']['action'],
	)));
	exit();
}

$newVisitor=new \user\Visitor(array(
	'nickname' => $nickname,
));
$newVisitor->retrieve();

if ($newVisitor->connection($password))
{
	new \exception\Notice($lang['success']);
	$Notification=new \user\Notification(array(
		'type'    => \user\Notification::TYPE_SUCCESS,
		'content' => $lang['success'],
	));
	$Visitor->getPage()->addNotificationSession($Notification);
	header('location: '.$Router->createLink($config_mod['after_login']));
	exit();
}
else
{
	new \exception\Error($lang['error']['incorrect_credential']);
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['login']['action'],
	)));
	exit();
}

?>
