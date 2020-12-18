<?php

$lang=$GLOBALS['lang']['home']['creation_character'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);
$PageElement->getElement('head')->addValueElement('javascripts', $GLOBALS['config']['path_asset'].'js/home/creation_character/attributes.js');
$PageElement->getElement('head')->addValueElement('javascripts', $GLOBALS['config']['path_asset'].'js/home/creation_character/preview.js');

$RaceManager=new \character\RaceManager(\core\DBFactory::MysqlConnection());
$Races=$RaceManager->retrieveBy();
$options_race=array();
foreach ($Races as $Race)
{
	$options_race[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/creation_character/option.html',
		'elements' => array(
			'value'   => $Race->displayId(),
			'display' => $Race->displayName(),
		),
	));
}
$ClassManager=new \character\RpgClassManager(\core\DBFactory::MysqlConnection());
$Classs=$ClassManager->retrieveBy();
$options_class=array();
foreach ($Classs as $Class)
{
	$options_class[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/creation_character/option.html',
		'elements' => array(
			'value'   => $Class->displayId(),
			'display' => $Class->displayName(),
		),
	));
}
$attributes=array();
foreach (\character\Attributes::AV_ATTR as $attribute)
{
	$attributes[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'home/creation_character/attribute.html',
		'elements' => array(
			'attribute' => 'attr_'.$attribute,
			'display'   => $lang['attr_'.$attribute],
		),
	));
}


$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/creation_character/template.html',
	'elements' => array(
		'action'            => $Router->createLink(array('application' => 'home', 'action' => 'validate_creation_character')),
		'legend'            => $lang['legend_basic'],
		'name'              => $lang['name'],
		'race'              => $lang['race'],
		'options_race'      => $options_race,
		'class'             => $lang['class'],
		'options_class'     => $options_class,
		'legend_attributes' => $lang['legend_attributes'],
		'attributes'        => $attributes,
		'preview'           => $lang['preview'],
		'submit'            => $lang['submit'],
	),
));

$PageElement->addElement('body', $content);

?>