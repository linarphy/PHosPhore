<?php

/* Default action for doc application */
$GLOBALS['config']['page']['doc']['default_action']='home';
/* Default configuration for documentation page */
$GLOBALS['config']['page']['doc']['config']=array(
	'content_type' => 'documentation',
	'notification' => true,
);
/* List of links of page in doc application */
$GLOBALS['config']['page']['doc']['links']=array(
	'link_home'            => array('application' => 'doc', 'action' => 'home'),
	'link_getting_started' => array('application' => 'doc', 'action' => 'getting_started'),
	'link_api'             => array('application' => 'doc', 'action' => 'api'),
	'link_bouml'           => array('application' => 'doc', 'action' => 'bouml'),
	'link_search'          => array('application' => 'doc', 'action' => 'search'),
	'link_faq'             => array('application' => 'doc', 'action' => 'faq'),
);

?>