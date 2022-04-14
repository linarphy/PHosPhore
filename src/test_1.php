<?php

$tests = 0;

require(
	\join(DIRECTORY_SEPARATOR, [
		'..',
		'src',
		'func',
		'core',
		'init.php',
	])
);

if (load_class('\\core\\Hook') !== True)
{
	throw new \Exception('test ' . $tests . ' : load_class should return True or throw an exception, so this message should never be shown');
}

$tests += 1;

$GLOBALS['Hook']    = new \core\Hook();
$GLOBALS['Logger']  = new \core\Logger();
$GLOBALS['Router']  = new \route\Router(init_router());
$GLOBALS['Visitor'] = new \user\Visitor(init_visitor());

$Page = new \user\Page([
	'id' => $GLOBALS['config']['core']['route']['error']['id'],
]);
$Page->retrieve();
$Page->get('route')->retrieveFolder();
$Page->retrieveParameters();

if ($Page->get('id') !== $GLOBALS['config']['core']['route']['error']['id'])
{
	throw new \Exception('test ' . $tests . ' : the page id should be the same as the one which defined it');
}

$tests += 1;

if ($Page->get('name') !== 'error')
{
	throw new \Exception('test ' . $tests . ' : the error page name should be error ');
}

$tests += 1;

if ($Page->get('route')->get('id') !== $Page->get('id'))
{
	throw new \Exception('test ' . $tests . ' : the error page and route should have the same id');
}

if ($GLOBALS['Router']->createLink([$Page->get('route')]) !== 'root/error/')
{
	throw new \Exception('test ' . $tests . ' : the error link should be "root/error"');
}

$tests += 1;

if ($GLOBALS['Router']->createLink([$Page->get('route')], ['parameter']) !== 'root/error/%20/parameter/')
{
	throw new \Exception('test ' . $tests . ' : the error link with a parameter "parameter" added should be "root/error/ /parameter"');
}

$tests += 1;

if ($GLOBALS['Router']->decodeRoute('root/error')->get('id') !== $GLOBALS['config']['core']['route']['error']['id'])
{
	throw new \Exception('test ' . $tests . ' : the error page id should be the same that the one given in configuration');
}

$tests += 1;
echo 'every tests (' . $tests . ') passed';

?>
