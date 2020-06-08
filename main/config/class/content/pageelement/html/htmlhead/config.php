<?php

/* List of path to css which will be in each html page */
$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_css']=array();
/* List of path to javascripts which will be in each html page */
$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_js']=array();
/* List of "meta array" array to meta which will be in each html page */
$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_metas']=array(
	array(
		'http-equiv' => 'X-UA-Compatible',
		'content'    => 'IE=edge',
	),
	array(
		'name'    => 'viewport',
		'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
	),
);

?>