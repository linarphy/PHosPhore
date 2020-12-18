<?php

$config_mod=$GLOBALS['config']['role-manager'];
/* [ERROR] */
/* No id given */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['no_id']='Cannot update a permission withour id';
/* Missing parameters */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['missing_parameters']='Cannot update a permission because at least one parameter is not defined';
/* Cannor retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['retrieve']='Cannot retrieve this permission: ';
/* Parameters are empty */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['empty_parameters']='At least one parameter is empty';
/* The permission is not correctly defined */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['badformed_permission']='Impossible de modifier une permission corrompue';

/* Success message */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['success']='Permission updated';

?>
