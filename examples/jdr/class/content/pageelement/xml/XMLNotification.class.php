<?php

namespace content\pageelement\xml;

/**
 * An XML notification
 *
 * @author gugus2000
 **/
class XMLNotification extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of \content\pageelement\wml\XMLNotification
		* 
		* @return void
		*/
		public function __construct()
		{
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/xml/xmlnotification/template.html',
				'elements' => array(),
			));
		}
} // END class XMLNotification extends \content\PageElement

?>