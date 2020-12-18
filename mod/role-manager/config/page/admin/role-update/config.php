<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [PARAMETERS] */
/* [ID] */
/* necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update']['action']]['parameters']['id']['necessary']=true;
/* regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['update']['action']]['parameters']['id']['regex']='\\d+';

?>
