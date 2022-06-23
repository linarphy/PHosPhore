<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');

$PageElement->addElement('head', '<title>' . $GLOBALS['locale']['page']['main']['home']['title'] . '</title>');

$QueryConstructor = new \database\QueryConstructor([]);
$Update = $QueryConstructor->update('phosphore_user')
	                       ->put('nickname', 'linarphy', 'nickname')
						   ->where(
							   $QueryConstructor->exp()
						                        ->add('C', 'nickname', 'phosphore_user')
											    ->add('P', 'guest')
											    ->op('=')
											    ->get('expression'),

						   );

var_dump(\database\Mysql::displayQuery($Update->get('query')));
var_dump($Update->retrieveParameters());

$body = new \content\pageelement\PageElement([
	'template' => 'main' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'body.html',
	'elements' => [
		'message' => $GLOBALS['locale']['page']['main']['home']['message'],
		'version' => implode('.', $GLOBALS['config']['core']['version']),
	],
]);
$PageElement->addElement('body', $body);

?>
