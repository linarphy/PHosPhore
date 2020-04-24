<?php

$GLOBALS['config']['doc']=array(
	'default_action' => 'home',		// Default action for doc application.
	'config'         => array(		// Doc application config
		'content_type' => 'doc',
		'notification' => true,
	),
	/* link */
		'link_home'            => array('application' => 'doc', 'action' => 'home'),
		'link_getting_started' => array('application' => 'doc', 'action' => 'getting_started'),
		'link_api'             => array('application' => 'doc', 'action' => 'api'),
		'link_bouml'           => array('application' => 'doc', 'action' => 'bouml'),
		'link_search'          => array('application' => 'doc', 'action' => 'search'),
		'link_faq'             => array('application' => 'doc', 'action' => 'faq'),
);

?>