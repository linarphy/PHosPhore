<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['main']['home']['title'] . '</title>');

$body = new \content\pageelement\PageElement([
	'template' => 'main' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'body.html',
	'elements' => [
		'message' => $GLOBALS['locale']['page']['main']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	],
]);
$PageElement->addElement('body', $body);

?>
