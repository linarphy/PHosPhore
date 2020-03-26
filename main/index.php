<?php
session_start();

date_default_timezone_set('UTC');

require('func/func.php');
spl_autoload_register('loadClass');

require('config/config.php');
require($GLOBALS['config']['path_lang'].$GLOBALS['config']['user_config']['lang'].'.lang.php');

$Router=new \core\Router(init_router());

$Visitor=new \user\Visitor(init_visitor());

try
{
	if ($Visitor->connection($_SESSION['password']))
	{
		echo $Visitor->loadPage($Router->decodeRoute($_SERVER['REQUEST_URI']));
	}
	else
	{
		throw new \Exception($GLOBALS['lang']['general_error_connection']);
	}
}
catch (Exception $e)
{
	echo $Visitor->loadPage($GLOBALS['config']['error_page']);
}

exit();

?>