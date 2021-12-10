<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');
$Content = new \content\pageelement\PageElement(array(
	'elements' => array(
		'title'   => 'This is an error page',
		'message' => $GLOBALS['exception']->getMessage(),
	),
	'template' => 'error/content.html',
));
$PageElement->addElement('content', $Content);

?>
