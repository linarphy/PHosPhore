<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');
$Content = new \content\pageelement\PageElement(array(
	'elements' => array(
		'locale'    => $GLOBALS['locale']['core']['locale']['abbr'],
		'title'     => $GLOBALS['locale']['page']['error']['title'],
		'important' => $GLOBALS['locale']['page']['error']['important'],
		'message'   => $GLOBALS['exception']->getMessage(),
	),
	'template' => 'error/content.html',
));
$PageElement->addElement('content', $Content);

?>
