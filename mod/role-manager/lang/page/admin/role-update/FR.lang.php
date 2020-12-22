<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* No id for the permission */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['no_id']='Impossible de modifier une permission sans son id';
/* Cannor retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['retrieve']='Impossible de récupérer cette permission: ';
/* The permission has an empty field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['error']['badformed_permission']='Impossible de modifier une permission corrompue';

/* Title of the webpage */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['title']='Modification de la permission';
/* Legend of the form */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['legend']='Modificatin de permission';
/* Label for the role field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_role']='Role:';
/* Label for the application field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_application']='Application:';
/* Label for the action field */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['label_action']='Action:';
/* Submit button */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['update']['action']]['submit']='MODIFIER';

?>
