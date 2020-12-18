<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [PARAMETERS] */
/* [ID] */
/* necessary */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['delete']['action']]['parameters']['id']['necessary']=true;
/* regex */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['delete']['action']]['parameters']['id']['regex']='\\d+';


/* [CONFIGURATION] */
/* content-type */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['delete']['action']]['config']['content-type']='none';
/* notification */
$GLOBALS['config']['page'][$config_mod['application']][$config_mod['delete']['action']]['config']['notification']=false;

?>
