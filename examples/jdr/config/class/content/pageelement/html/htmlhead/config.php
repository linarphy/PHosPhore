<?php

/* List of path to css which will be in each html page */
/*$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_css'][]=;*/
/* List of path to javascripts which will be in each html page */
/*$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_js'][]=;*/
/* List of "meta array" array to meta which will be in each html page */
$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_metas'][]=array(
	'http-equiv' => 'X-UA-Compatible',
	'content'    => 'IE=edge',
);
$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_metas'][]=array(
	'name'    => 'viewport',
	'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
);

?>