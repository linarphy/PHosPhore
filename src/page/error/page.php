<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

if (isset($GLOBALS['exception']))
{
	$message = $GLOBALS['exception']->getMessage();
}
else
{
	$message = $GLOBALS['locale']['page']['error']['no_error'];
}
$Content = new \content\pageelement\PageElement([
	'elements' => [
		'important' => $GLOBALS['locale']['page']['error']['important'],
		'message'   => $message,
		'version'   => implode('.', $GLOBALS['config']['core']['version']),
	],
	'template' => 'error/content.html',
]);
$PageElement->addElement('body', $Content);
$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['error']['title'] . '</title>');

?>
