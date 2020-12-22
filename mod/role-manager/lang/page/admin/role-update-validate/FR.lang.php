<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* No id given */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['no_id']='Impossible de modifier une permission sans son id';
/* Missing parameters */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['missing_parameters']='Impossible de modifier cette permission car un de ses paramètres n\'a pas été définie';
/* Cannor retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['retrieve']='Impossible de récupérer cette permission: ';
/* Parameters are empty */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['empty_parameters']='Certains paramètres sont vides';
/* The permission is not correctly defined */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['error']['badformed_permission']='Impossible de modifier une permission corrompue';

/* Success message */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update-validate']['action']]['success']='La permission a été mise à jour';

?>
