<?php

$Element=$Visitor->getPage()->getPageElement();
$lang=$GLOBALS['lang']['doc']['home'];
$Element->getElement('head')->addElement('title', $lang['title']);

$Sections=array();
foreach ($lang['sections'] as $section)
{
	$Sections[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'doc/home/section.html',
		'elements' => array(
			'href'        => $Router->createLink($section['href']),
			'title'       => $section['title'],
			'link'        => $section['link'],
			'description' => $section['description'],
		),
	));
}

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'doc/home/template.html',
	'elements' => array(
		'title'       => $lang['general_title'],
		'description' => $lang['general_description'],
		'sections'    => $Sections,
	),
));

$Element->getElement('body')->addElement('content', $Content);

?>