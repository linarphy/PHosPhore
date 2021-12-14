<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['home']['title'] . '</title>');

$body = new \content\pageelement\PageElement(array(
	'template' => 'home/body.html',
	'elements' => array(
		'message' => $GLOBALS['locale']['page']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	),
));
$PageElement->addElement('body', $body);

?>
