<?php

global $Router;

$GLOBALS['lang']['user']['login']=array(
	'title'    => 'Connexion',
	'legend'   => 'Connexion',
	'nickname' => 'Pseudo',
	'password' => 'Mot de passe',
	'submit'   => 'SE CONNECTER',
	'register' => 'Pas encore inscrit? <a href="'.$Router->createLink(array('application' => 'user', 'action' => 'register')).'" title="inscription">Cliques ici pour t\'inscrire</a>',
);

?>