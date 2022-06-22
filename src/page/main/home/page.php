<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['main']['home']['title'] . '</title>');

$QueryConstructor = new \database\QueryConstructor([]);
$Insert = $QueryConstructor->insert('phosphore_user')
	                       ->value('nickname', 'linarphy')
						   ->value('password_hashed', '$2y$10$8FJioP34k9jfA');

var_dump(\database\Mysql::displayQuery($Insert->get('query')));

$body = new \content\pageelement\PageElement([
	'template' => 'main' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'body.html',
	'elements' => [
		'message' => $GLOBALS['locale']['page']['main']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	],
]);
$PageElement->addElement('body', $body);

?>
