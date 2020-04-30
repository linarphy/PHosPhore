<?php

$lang=$GLOBALS['lang']['home']['hub'];

$Visitor->getPage()->getPageElement()->getElement('head')->addValueElement('css', 'asset/css/home/hub/style.css');
$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', $lang['title']);
$options=array();
foreach ($lang['options'] as $option)
{
	$options[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/hub/option.html',
		'elements' => array(
			'href'  => $Router->createLink($option['href']),
			'title' => $option['title'],
			'link'  => $option['link'],
		),
	));
}
$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/hub/template.html',
	'elements' => array(
		'title'       => $lang['title_content'],
		'description' => $lang['title_description'],
		'options'     => $options,
	),
));

$Visitor->getPage()->getPageElement()->addElement('body', $Content);

?>