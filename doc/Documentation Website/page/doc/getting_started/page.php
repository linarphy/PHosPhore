<?php

$lang=$GLOBALS['lang']['page']['doc']['getting_started'];

$Element=$Visitor->getPage()->getPageElement();
$Element->getElement('head')->addElement('title', $lang['title']);

function displaySection($sections, $lvl)
{
	$Sections=array();
	foreach ($sections as $section)
	{
		if (isset($section['subsections']))
		{
			if (is_array($section['subsections']))
			{
				$subsections=displaySection($section['subsections'], $lvl+1);
			}
		}
		else
		{
			$subsections='';
		}
		$Sections[]=new \content\PageElement(array(
			'template' => $GLOBALS['config']['path_template'].'page/doc/getting_started/section.html',
			'elements' => array(
				'lvl'         => (string)$lvl,
				'title'       => $section['title'],
				'content'     => $section['content'],
				'subsections' => $subsections,
			),
		));
	}
	return $Sections;
}

$Sections=displaySection($lang['sections'], 2);

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/doc/getting_started/template.html',
	'elements' => array(
		'title'    => $lang['title'],
		'content'  => $lang['content'],
		'sections' => $Sections,
	),
));

$Element->getElement('body')->addElement('content', $Content);

?>