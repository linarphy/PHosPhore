<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* No id passed */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['no_id']='Impossible de supprimer une permission sans son id';/* Cannot retrieve the permission with this id */
/* Cannot retrieve the permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['retrieve']='Impossible de récupérer la permission: ';
/* No permission with this id */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['error']['unknown_permission']='Pas de permission avec cet id';

/* Permission successfuly deleted */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete']['action']]['success']='Permission correctement supprimée';

?>
