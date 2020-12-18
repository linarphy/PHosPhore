<?php

$config_mod=$GLOBALS['config']['mod']['role-manager'];
/* [ERROR] */
/* At least one parameter is not set */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['error']['no_parameters']='Il manque des paramètres nécessaire à la création f\'un role ou d\'une permission';
/* The method used is unknown */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['error']['unknown_method']='La méthode précisée dans la configuration de la page "add" du mod "mod-manager" est inconnue, les valeurs possibles sont "post" et "get"';

/* Role or permission successfuly added */
$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['add-validate']['action']]['success']='Le rôle ou la permission a bien été ajouté';

?>
