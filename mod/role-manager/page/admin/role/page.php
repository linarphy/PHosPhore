<?php

$lang=$GLOBALS['lang']['page'][$GLOBALS['config']['mod']['role-manager']['application']][$GLOBALS['config']['mod']['role-manager']['role']['action']];
$config_mod=$GLOBALS['config']['mod']['role-manager'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$UserManager=new \user\UserManager(\core\DBFactory::MysqlConnection());
$roles=array();
foreach ($UserManager->getBy(array(), array(), array(
	'group by' => 'role_name',
)) as $results)
{
	$Role=new \user\Role(array(
		'role_name' => $results['role_name'],
	));
	$Role->retrieve();
	$permissions=array();
	foreach ($Role->getPermissions() as $Permission)
	{
		$permissions[]=new \content\PageElement(array(
			'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/permission.html',
			'elements' => array(
				'application' => $Permission->displayApplication(),
				'action'      => $Permission->displayAction(),
			),
		));
	}
	$roles[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/role.html',
		'elements' => array(
			'role_name'   => $Role->displayRole_name(),
			'permissions' => $permissions,
		)
	));
}
$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/template.html',
	'elements' => array(
		'roles' => $roles,
	),
));

$PageElement->addElement('body', $content);

?>
