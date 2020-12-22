<?php

$lang=$GLOBALS['lang']['page'][$GLOBALS['config']['mod']['role-manager']['application']][$GLOBALS['config']['mod']['role-manager']['add']['action']];
$config_mod=$GLOBALS['config']['mod']['role-manager'];

$PageElement=$Visitor->getPage()->getPageElement();
$Parameters=$Visitor->getPage()->getParameters();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$role_name='';
$application='';
$action='';
if (isset($Parameters['role']))
{
	$role_name=$Parameters['role'];
}
if (isset($Parameters['perm-application']))
{
	$application=$Parameters['perm-application'];
}
if (isset($Parameters['perm-action']))
{
	$action=$Parameters['perm-action'];
}

$Form=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['add']['action'].'/template.html',
	'elements' => array(
		'action'            => $Router->createLink(array('application' => $config_mod['application'], 'action' => $config_mod['add-validate']['action'])),
		'method'            => strtoupper($config_mod['add']['method']),
		'legend'            => $lang['legend'],
		'label_role'        => $lang['label_role'],
		'value_role'        => $role_name,
		'label_application' => $lang['label_application'],
		'value_application' => $application,
		'label_action'      => $lang['label_action'],
		'value_action'      => $action,
		'submit'            => $lang['submit'],
	),
));

$PageElement->addElement('body', $Form)

?>
