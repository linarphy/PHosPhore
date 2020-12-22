<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* No id for the permission */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['no_id']='Cannot update a permission without an id';
/* Cannor retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['retrieve']='Cannot retrieve this permission: ';
/* The permission has an empty field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['badformed_permission']='Cannot update a corrupted permission';

/* Title of the webpage */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['title']='Permission update';
/* Legend of the form */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['legend']='Permission update';
/* Label for the role field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_role']='Role:';
/* Label for the application field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_application']='Application:';
/* Label for the action field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_action']='Action:';
/* Submit button */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['submit']='UPDATE';

?>
