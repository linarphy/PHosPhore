<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['home']['title'] . '</title>');

$Notification = new \user\Notification([
	'content' => 'this is a notification',
	'date'    => \date($GLOBALS['config']['core']['format']['date']),
	'type'    => \user\Notification::TYPES['info'],
]);
$Notification->addToSession();

$body = new \content\pageelement\PageElement([
	'template' => 'home/body.html',
	'elements' => [
		'message' => $GLOBALS['locale']['page']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	],
]);
$PageElement->addElement('body', $body);

?>
