<?php

namespace content\pageelement;

/**
 * An HTML webpage
 *
 * @author gugus2000
 **/
class HTML extends \content\PageElement
{
	/* Method */

		/**
		* Create a \content\pageelement\HTML instance
		* 
		* @return void
		*/
		public function __construct()
		{
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/template.html',
				'elements' => array(
					'head' => new \content\pageelement\html\HTMLHead(),
				),
			));
		}
} // END class HTML extends \content\PageElement

?>