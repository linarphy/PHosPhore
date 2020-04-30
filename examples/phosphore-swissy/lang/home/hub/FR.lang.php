<?php

global $Router;

$GLOBALS['lang']['home']['hub']=array(
	'title'             => 'Accueil',
	'title_content'     => 'SWISSY',
	'title_description' => 'Bienvenue sur la page d\'accueil de Swissy',
	'options'           => array(
		array(
			'href'  => $GLOBALS['config']['home']['link_giveaway'],
			'title' => 'Lien pour créer un tirage au sort',
			'link'  => 'Tirage au sort',
		),
	),
);

?>