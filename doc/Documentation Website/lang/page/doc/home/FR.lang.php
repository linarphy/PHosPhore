<?php

/* Title of the page */
$GLOBALS['lang']['page']['doc']['home']['title']='Accueil';
/* Title displayed in the content of the page */
$GLOBALS['lang']['page']['doc']['home']['general_title'] ='Documentation';
/* Description of this page displayed in the content of the page */
$GLOBALS['lang']['page']['doc']['home']['general_description']='Bienvenue dans la documentation';
/* List of the documentation page */
$GLOBALS['lang']['page']['doc']['home']['sections']=array(
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_getting_started'],
		'title'       => 'Commencer avec PHosPhore',
		'link'        => 'Pour Commencer',
		'description' => 'Comment commencer à utiliser ce framework.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_api'],
		'title'       => 'L\'API général de PHosPhore',
		'link'        => 'API',
		'description' => 'Documentation complète de l\'API de PHosPhore.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_bouml'],
		'title'       => 'Comment utiliser BOUML',
		'link'        => 'BOUML',
		'description' => 'Comment utiliser la documentation de PHosPhore généré par BOUML.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_search'],
		'title'       => 'Recherche dans la documentation',
		'link'        => 'Recherche',
		'description' => 'Recherche les fonctions et les classes dans la documentation de PHosPhore.',
	),
);

?>