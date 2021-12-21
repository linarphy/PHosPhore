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
		'locale'    => $GLOBALS['locale']['core']['locale']['abbr'],
		'title'     => $GLOBALS['locale']['page']['error']['title'],
		'important' => $GLOBALS['locale']['page']['error']['important'],
		'message'   => $message,
	],
	'template' => 'error/content.html',
]);
$PageElement->addElement('content', $Content);

?>
