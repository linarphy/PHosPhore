<?php

namespace content\pageelement;

/**
 * An XML webpage
 *
 * @author gugus2000
 **/
class XML extends \content\PageElement
{
	/* method */

		/**
		* Creation of an instance of \content\pageelement\XML
		* 
		* @return void
		*/
		public function __construct()
		{
			header("Content-Type: text/xml;charset=utf-8");
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/xml/template.html',
			));
		}
		/**
		* Display \content\pageelement\HTML
		* 
		* @return string
		*/
		public function display()
		{
			if (!$this->getElement('notifications'))
			{
				$this->addElement('notifications', '');
			}
			return parent::display();
		}
} // END class XML extends \content\PageElement

?>