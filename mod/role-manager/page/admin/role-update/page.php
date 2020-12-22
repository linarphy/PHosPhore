<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update']['action']];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']];

$Parameters=$Visitor->getPage()->getParameters();
if (isset($Parameters['id']))
{
	$id=(int)$Parameters['id'];
}
else
{
	new \exception\Error($lang['error']['no_id'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

$Permission=new \user\Permission(array(
	'id' => $id,
));
try
{
	$Permission->retrieve();
}
catch (\exception\Warning $error)
{
	new \exception\Error($lang['error']['retrieve'].$error->getMessage(), 'page', 0, $error);
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}
if (!$Permission->getApplication() || !$Permission->getAction())
{
	new \exception\Error($lang['error']['badformed_permission'], 'page');
	header('location: '.$Router->createLink(array(
		'application' => $config_mod['application'],
		'action'      => $config_mod['role']['action'],
	)));
	exit();
}

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['update']['action'].'/template.html',
	'elements' => array(
		'action'            => $Router->createLink(array(
			'application'                         => $config_mod['application'],
			'action'                              => $config_mod['update-validate']['action'],
			$GLOBALS['config']['route_parameter'] => array(
				'id' => $Permission->getId(),
			),
		)),
		'method'            => 'POST',
		'charset'           => 'UTF-8',
		'legend'            => $lang['legend'],
		'label_role'        => $lang['label_role'],
		'value_role'        => $Permission->getRole_name(),
		'label_application' => $lang['label_application'],
		'value_application' => $Permission->getApplication(),
		'label_action'      => $lang['label_action'],
		'value_action'      => $Permission->getAction(),
		'submit'            => $lang['submit'],
	),
));

$PageElement->addElement('body', $Content);

?>
