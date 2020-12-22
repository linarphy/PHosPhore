<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
switch (strtoupper($config_mod['add']['method']))
{
	case 'GET':
		/* Parameters for the page */
		$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['parameters']=array(
			'role' => array(
				'necessary' => true,
				'regex'     => '\S+',
			),
			'application' => array(
				'necessary' => true,
				'regex'     => '\S+',
			),
			'action' => array(
				'necessary' => true,
				'regex'     => '\S+',
			),
		);
		break;
	default:
		break;
}

?>
