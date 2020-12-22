<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* It will delete all the permissions */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete-all']['action']]['delete-all']='All permission will be deleted';
/* Nothing to delete */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete-all']['action']]['no_delete']='Nothing to delete';
/* Success message before the number of deleted permissions */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete-all']['action']]['success_begin']='';
/* Success message after the number of deleted permission */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['delete-all']['action']]['success_end']=' permissions successfully deleted';


?>
