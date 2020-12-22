<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* At least one parameter is not set */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['error']['no_parameters']='At least one parameter is missing to create a role or permission';
/* The method used is unknown */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['error']['unknown_method']='The defined method in the "add" page of "role-manager" mod configuration is unknown, the possible values are "post" and "get"';

/* Role or permission successfuly added */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['success']='The role or permission was correcty added';

?>
