<?php

$Element=$Visitor->getPage()->getPageElement();
$lang=$GLOBALS['lang']['doc']['bouml'];

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
			'template' => $GLOBALS['config']['path_template'].'doc/bouml/section.html',
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
	'template' => $GLOBALS['config']['path_template'].'doc/bouml/template.html',
	'elements' => array(
		'title'    => $lang['title'],
		'content'  => $lang['content'],
		'sections' => $Sections,
	),
));

$Element->getElement('body')->addElement('content', $Content);

?>