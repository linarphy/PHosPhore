<?php

session_start();
date_default_timezone_set('UTC');

require('./func/func.php');
spl_autoload_register('loadClass');

init_conf();
new \exception\Notice($GLOBALS['lang']['init_conf']);
$Router=new \core\Router(init_router());
new \exception\Notice($GLOBALS['lang']['init_router']);
$Visitor=new \user\Visitor(init_visitor());
new \exception\Notice($GLOBALS['lang']['init_visitor']);

try
{
	if ($Visitor->connection($_SESSION['password']))
	{
		new \exception\Notice($GLOBALS['lang']['connected']);
		echo $Visitor->loadPage($Router->decodeRoute($_SERVER['REQUEST_URI']));
	}
	else
	{
		new \exception\FatalError($GLOBALS['lang']['error_connection']);
	}
}
catch (Exception $e)
{
	echo $Visitor->loadPage($GLOBALS['config']['error_page']);
}

new \exception\Notice($GLOBALS['lang']['end']);
exit();

?>