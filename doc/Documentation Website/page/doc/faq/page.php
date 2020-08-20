<?php

$lang=$GLOBALS['lang']['page']['doc']['faq'];
$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);
$PageElement->getElement('head')->addValueElement('css', $GLOBALS['config']['path_asset'].'css/page/doc/faq/main.css');

$qa=array();
foreach ($lang['qa'] as $element)
{
	$qa[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'page/doc/faq/QA.html',
		'elements' => array(
			'Q' => $element['q'],
			'A' => $element['a'],
		),
	));
}

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/doc/faq/template.html',
	'elements' => array(
		'title'       => $lang['title'],
		'description' => $lang['description'],
		'QA'          => $qa,
	),
));

$PageElement->addElement('content', $content);

?>