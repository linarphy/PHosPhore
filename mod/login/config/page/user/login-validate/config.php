<?php

/* add parameters if necessary */
switch (strtoupper($GLOBALS['config']['mod']['login']['login']['method']))
{
	case 'GET':
		$GLOBALS['config']['page'][$GLOBALS['config']['mod']['login']['application']][$GLOBALS['config']['mod']['login']['login-validate']['action']]['parameters']=array(
			'nickname' => array(
				'necessary' => true,
				'regex'     => '\S+',
			),
			'password' => array(
				'necessary' => true,
				'regex'     => '\S+',
			),
		);
		break;
	default:
		break;
}

/* Configuration of this page */
$GLOBALS['config']['page'][$GLOBALS['config']['mod']['login']['application']][$GLOBALS['config']['mod']['login']['login-validate']['action']]['config']=array(
	'content-type' => 'none',
	'notification' => false,
);

?>
