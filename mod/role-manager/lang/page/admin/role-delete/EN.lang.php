<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* No id passed */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['no_id']='Cannot delete a permission without its id';
/* Cannot retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['retrieve']='Cannot retrieve this permission: ';
/* No permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['unknown_permission']='No permission with this id';

/* Permission successfuly deleted */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['success']='Permission correctly deleted';

?>
