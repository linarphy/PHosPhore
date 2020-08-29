<?php

$Element=$Visitor->getPage()->getPageElement();
$lang=$GLOBALS['lang']['page']['doc']['home'];
$Element->getElement('head')->addElement('title', $lang['title']);

$Sections=array();
foreach ($lang['sections'] as $key => $section)
{
	$Sections[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'page/doc/home/section.html',
		'elements' => array(
			'href'        => $Router->createLink($GLOBALS['config']['page']['doc']['links'][$key]),
			'title'       => $section['title'],
			'link'        => $section['link'],
			'description' => $section['description'],
		),
	));
}

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/doc/home/template.html',
	'elements' => array(
		'title'       => $lang['general_title'],
		'description' => $lang['general_description'],
		'sections'    => $Sections,
	),
));

$Element->getElement('body')->addElement('content', $Content);

?>
