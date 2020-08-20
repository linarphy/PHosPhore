<?php

$config_mod=$GLOBALS['config']['mod']['login'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['register']['action']];
$lang_mod=$GLOBALS['lang']['mod']['login'];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['register']['action']];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title'].$lang_mod['title']);

$Parameters=array();
if($config_mod['register']['strict'])
{
	foreach($config_mod['register']['parameters'] as $name => $parameter)
	{
		if($parameter['necessary'])
		{
			$Parameters[$name]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['register']['action'].'/parameter.html',
				'elements' => array(
					'name'  => $name,
					'label' => $lang[$name],
					'type'  => $parameter['type'],
				),
			));
		}
	}
}
else
{
	foreach($config_mod['register']['parameters'] as $name => $parameter)
	{
		if($parameter['necessary'])
		{
			$necessary='';
		}
		else
		{
			$necessary='*';
		}
		$Parameters[$name]=new \content\PageElement(array(
			'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['register']['action'].'/parameter.html',
			'elements' => array(
				'name'  => $name,
				'label' => $lang[$name].$necessary,
				'type'  => $parameter['type'],
			),
		));
	}
}

$Form=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['register']['action'].'/template.html',
	'elements' => array(
		'action'     => $Router->createLink(array('application' => $config_mod['application'], 'action' => $config_mod['register-validate']['action'])),
		'charset'    => $config['charset'],
		'legend'     => $lang['legend'],
		'parameters' => $Parameters,
		'submit'     => $lang['submit'],
	),
));

$PageElement->addElement('body', $Form);

?>
