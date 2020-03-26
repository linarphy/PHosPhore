<?php

namespace content\pageelement\html;

/**
 * An HTML Notification
 *
 * @author gugus2000
 * 
 **/
class HTMLNotification extends \content\PageElement
{
	/* Method */

		/**
		* Create a \content\pageelement\html\HTMLNotification instance
		* 
		* @return void
		*/
		public function __construct()
		{
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlnotification/template.html',
				'elements' => array(),
			));
		}
} // END class HTMLNotification extends \content\PageElement

?>