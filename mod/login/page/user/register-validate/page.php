<?php

$config_mod=$GLOBALS['config']['mod']['login'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['register-validate']['action']];
$lang_mod=$GLOBALS['lang']['mod']['login'];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['register-validate']['action']];

$value=array();
foreach ($config_mod['register']['default'] as $name => $data)
{
	$value[$name]=$data;
}

if (!isset($_POST['nickname']) && !isset($_POST['password']))
{
	new \exception\Error($lang['error']['no_credential'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}

foreach($config_mod['register']['parameters'] as $input => $param)
{
	if(!isset($_POST[$input]) && $param['necessary'])
	{
		new \exception\Error($lang['error']['no_input'].$input, 'page');
		header('location: '.$Router->createLink(array(
			'application' => $config_mod['application'],
			'action'      => $config_mod['register']['action'],
		)));
		exit();
	}
	if (isset($_POST[$input]))
	{
		if ($input === 'avatar')
		{
			require('upload_avatar.php');
		}
		else if(!preg_match('#'.$param['pattern'].'#', $_POST[$input], $matches))
		{
			if (!$config_mod['register']['parameters'][$input]['necessary'])
			{
				new \exception\Warning($lang['error']['missmatch_pattern_unnecessary'], 'page');
				break;
			}
			else
			{
				new \exception\Error($lang['error']['missmatch_pattern'], 'page');
				header('location: '.$Router->createLink(array(
					'application' => $config_mod['application'],
					'action'      => $config_mod['register']['action'],
				)));
				exit();
			}
		}
		$value[$input]=$matches[0];
	}
}

if(!isset($config_mod['register']['parameters']['nickname']) || !isset($config_mod['register']['parameters']['password']))
{
	new \exception\Error($lang_mod['credential_necessary'], 'mod\login');
	header('location: '.$Router->createLink(array(
		'application' => $GLOBALS['config']['default_application'],
	)));
	exit();
}
$password=$value['password'];
unset($value['password']);
$newVisitor=new \user\Visitor($value, false);
$newVisitor->registration($password, $config_mod['role']);

new \exception\Notice($lang['success'], 'page');
$Notification=new \user\Notification(array(
	'type'    => \user\Notification::TYPE_SUCCESS,
	'content' => $lang['success'],
));
$Visitor->getPage()->addNotificationSession($Notification);
header('location: '.$Router->CreateLink($config['after_register']));
exit();

?>
