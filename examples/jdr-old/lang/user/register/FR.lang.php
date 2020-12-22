<?php

global $Router;

$GLOBALS['lang']['user']['register']=array(
	'title'           => 'S\'inscrire',
	'legend'          => 'Inscription',
	'nickname'        => 'Pseudo',
	'small_nickname'  => 'nécessaire',
	'password'        => 'Mot de passe',
	'small_password'  => 'nécessaire',
	'password2'       => 'Vérification du mot de passe',
	'small_password2' => 'nécessaire',
	'email'           => 'Adresse mél',
	'small_email'     => 'NON NÉCESSAIRE',
	'submit'          => 'S\'INSCRIRE',
	'login'           => 'Déjà inscrit? <a href="'.$Router->createLink(array('application' => 'user', 'action' => 'login')).'" title="connexion">Cliques ici pour te connecter</a>',
);

?>