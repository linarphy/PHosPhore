<?php

global $Router;

$GLOBALS['lang']['home']['hub']=array(
	'title'             => 'Homepage',
	'title_content'     => 'SWISSY',
	'title_description' => 'Welcome to the Swissy\'s Homepage',
	'options'           => array(
		array(
			'href'  => $GLOBALS['config']['home']['link_giveaway'],
			'title' => 'Link to create GiveAway',
			'link'  => 'GiveAway',
		),
	),
);

?>