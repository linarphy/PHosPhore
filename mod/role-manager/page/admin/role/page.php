<?php

$lang=$GLOBALS['lang']['page'][$GLOBALS['config']['mod']['role-manager']['application']][$GLOBALS['config']['mod']['role-manager']['role']['action']];
$config_mod=$GLOBALS['config']['mod']['role-manager'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$RoleManager=new \user\RoleManager(\core\DBFactory::MysqlConnection());
$roles=array();
foreach ($RoleManager->getBy(array(), array(), array(
	'group by' => 'role_name',
)) as $results)
{
	$Role=new \user\Role(array(
		'role_name' => $results['role_name'],
	));
	$Role->retrieve();
	$applications=array();
	foreach ($Role->getPermissions() as $Permission)
	{
		if (!isset($applications[$Permission->displayApplication()]))
		{
			$applications[$Permission->displayApplication()]=array();
		}
		$applications[$Permission->displayApplication()][$Permission->displayAction()]=$Permission;
	}
	$Applications=array();
	foreach ($applications as $application => $actions)
	{
		$Actions=array();
		foreach ($actions as $action => $Permission)
		{
			$Actions[]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/action.html',
				'elements' => array(
					'action'         => $action,
					'href_delete'    => $Router->createLink(array(
						'application'                         => $config_mod['application'],
						'action'                              => $config_mod['delete']['action'],
						$GLOBALS['config']['route_parameter'] => array(
							'id' => $Permission->getId(),
						),
					)),
					'title_delete'   => $lang['title_delete_permission'],
					'display_delete' => $lang['display_delete_permission'],
					'href_update'    => $Router->createLink(array(
						'application'                         => $config_mod['application'],
						'action'                              => $config_mod['update']['action'],
						$GLOBALS['config']['route_parameter'] => array(
							'id' => $Permission->getId(),
						),
					)),
					'title_update'   => $lang['title_update_permission'],
					'display_update' => $lang['display_update_permission'],
				),
			));
		}
		$Applications[]=new \content\PageElement(array(
			'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/application.html',
			'elements' => array(
				'application'    => $application,
				'href_add'       => $Router->createLink(array(
					'application'                         => $config_mod['application'],
					'action'                              => $config_mod['add']['action'],
					$GLOBALS['config']['route_parameter'] => array(
						'role'        => $Role->displayRole_name(),
						'application' => $application,
					),
				)),
				'title_add'      => $lang['title_add_permission'],
				'display_add'    => $lang['display_add_permission'],
				'href_delete'    => $Router->createLink(array(
					'application'                         => $config_mod['application'],
					'action'                              => $config_mod['delete-all']['action'],
					$GLOBALS['config']['route_parameter'] => array(
						'role'        => $Role->displayRole_name(),
						'application' => $application,
					),
				)),
				'title_delete'   => $lang['title_delete_application'],
				'display_delete' => $lang['display_delete_application'],
				'actions'        => $Actions,
			),
		));
	}
	$roles[]=new \content\PageElement(array(
		'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/role.html',
		'elements' => array(
			'role_name'    => $Role->displayRole_name(),
			'applications' => $Applications,
			'href_add'     => $Router->createLink(array(
				'application'                         => $config_mod['application'],
				'action'                              => $config_mod['add']['action'],
				$GLOBALS['config']['route_parameter'] => array(
					'role' => $Role->displayRole_name(),
				),
			)),
			'title_add'    => $lang['title_add_permission'],
			'display_add'  => $lang['display_add_permission'],
		),
	));
}
$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'page/'.$config_mod['application'].'/'.$config_mod['role']['action'].'/template.html',
	'elements' => array(
		'roles'       => $roles,
		'href_add'    => $Router->createLink(array(
			'application' => $config_mod['application'],
			'action'      => $config_mod['add']['action'],
		)),
		'title_add'   => $lang['title_add_permission'],
		'display_add' => $lang['display_add_permission'],
	),
));

$PageElement->addElement('body', $content);

?>
