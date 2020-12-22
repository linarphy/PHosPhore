<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [PARAMETERS] */
/* [ID] */
/* necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['parameters']['id']['necessary']=true;
/* regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['parameters']['id']['regex']='\\d+';

/* [CONFIGURATION] */
/* content-type */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['config']['content-type']='none';
/* notification */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['config']['notification']=false;

?>
