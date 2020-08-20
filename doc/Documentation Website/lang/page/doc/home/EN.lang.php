<?php

/* Title of the page */
$GLOBALS['lang']['page']['doc']['home']['title']='Center';
/* Title displayed in the content of the page */
$GLOBALS['lang']['page']['doc']['home']['general_title'] ='Documentation';
/* Description of this page displayed in the content of the page */
$GLOBALS['lang']['page']['doc']['home']['general_description']='Welcome to the documentation page';
/* List of the documentation page */
$GLOBALS['lang']['page']['doc']['home']['sections']=array(
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_getting_started'],
		'title'       => 'Getting started with PHosPhore',
		'link'        => 'Getting Started',
		'description' => 'How to start using this framework.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_api'],
		'title'       => 'The general API of PHosPhore',
		'link'        => 'API',
		'description' => 'Complete documentation of the PHosPhore API.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_bouml'],
		'title'       => 'How to use BOUML',
		'link'        => 'BOUML',
		'description' => 'How to use BOUML generated PHosPhore documentation.',
	),
	array(
		'href'        => $GLOBALS['config']['page']['doc']['links']['link_search'],
		'title'       => 'Search in the documentation',
		'link'        => 'Search',
		'description' => 'Search function, class in the PHosPhore documentation.',
	),
);

?>