<?php

namespace content\pageelement\html;

/**
 * A navbar for home application
 *
 * @author gugus2000
 **/
class NavBar extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of a \content\pageelement\html\NavBar
		* 
		* @return void
		*/
		public function __construct()
		{
			global $Router;
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/navbar/template.html',
				'elements' => array(
					'link_brand'   => $Router->createLink(array('application' => 'home')),
					'brand'        => $GLOBALS['config']['general_name'],
					'link_home'    => $Router->createLink(array('application' => 'home')),
					'title_home'   => $GLOBALS['lang']['class_content_pageelement_html_navbar_home_title'],
					'home'         => $GLOBALS['lang']['class_content_pageelement_html_navbar_home'],
					'link_logout'  => $Router->createLink(array('application' => 'user', 'action' => 'logout')),
					'title_logout' => $GLOBALS['lang']['class_content_pageelement_html_navbar_logout_title'],
					'logout'       => $GLOBALS['lang']['class_content_pageelement_html_navbar_logout'],
				),
			));
		}
} // END class NavBar extends \content\PageElement

?>