<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [PARAMETERS] */
/* [ROLE] */
/* If it necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['role']['necessary']=false;
/* The regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['role']['regex']='\S+';
/* [PERM-APPLICATION] */
/* If it necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['perm-application']['necessary']=false;
/* The regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['perm-application']['regex']='\S+';
/* [PERM-ACTION] */
/* If it necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['perm-action']['necessary']=false;
/* The regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['add']['action']]['parameters']['perm-action']['regex']='\S+';

?>
