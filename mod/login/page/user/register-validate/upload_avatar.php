<?php

$config_avatar=$config_mod['register']['parameters']['avatar'];

if(!is_dir($GLOBALS['config']['path_avatar']))
{
	if(!mkdir($GLOBALS['config']['path_avatar'], 755);
	{
		new \exception\Error($lang['error']['create_dir'], 'page');
		header('location: '.$Router->createLink(array(
			'application' => $config_mod['application'],
			'action'      => $config_mod['register']['action'],
		)));
		exit();
	}
}

if(!in_array(strtolower(pathinfo($FILES['avatar']['name'], PATHINFO_EXTENSION), $config_mod['register']['parameters']['extensions']))
{
	new \exception\Error($lang['error']['extension'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}

$file=finfo_open(FILEINFO_MIME_TYPE);
$type=finfo_file($file, $_FILES['avatar']['tmp_name']);
finfo_close($file);

if(substr($type, 0, 5)!=='image')
{
	new \exception\Error($lang['error']['type'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}

if($_FILES['avatar']['size']<$config_avatar['min_size'] || $_FILES['avatar']['size']>$config_avatar['max_size'])
{
	new \exception\Error($lang['error']['size'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
$size=getimagesize($_FILES['tmp_name']);
if(!is_array($size))
{
	new \exception\Error($lang['error']['getimagesize'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
if($size[0]<$config_avatar['width_min'] || $size[0]>$config_avatar['width_max'])
{
	new \exception\Error($lang['error']['width'], 'page');
	header('location :'.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
if($size[1]<$config_avatar['height_min'] || $size[1]>$config_avatar['height_max'])
{
	new \exception\Error($lang['error']['height'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
if(substr(image_type_to_mime_type($size[2]), 0, 5)!=='image')
{
	new \exception\Error($lang['error']['type'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
if(!isset($_FILES['avatar']['error']) || is_array($_FILES['avatar']['error']))
{
	new \exception\Error($lang['error']['bad_error'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
if($_FILES['avatar']['error']!==UPLOAD_ERR_OK)
{
	new \exception\Error($lang['error']['upload'].$lang['error']['upload-error'][$_FILES['avatar']['error']], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}
$matches=array();
$matches[0]=uniqid().'.'.pathinfo($FILES['avatar']['name'], PATHINFO_EXTENSION);
move_uploaded_file($_FILES['avatar']['tmp_name'], $GLOBALS['config']['path_avatar'].$matches[0]);
if(!file_exists($GLOBALS['config']['path_avatar'].$matches[0])
{
	new \exception\Error($lang['error']['unknown'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['register']['action'],
	)));
	exit();
}

?>
