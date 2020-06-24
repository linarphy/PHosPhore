<?php

namespace content\pageelement\documentation;

/**
 * An HTML Documentation page
 *
 * @author gugus2000
 * 
 **/
class Documentation extends \content\PageElement
{
	/* Method */

		/**
		* Create a \content\pageelement\documentation\Documentation instance
		* 
		* @return void
		*/
		public function __construct()
		{
			$header=new \content\pageelement\documentation\Header();
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/template.html',
				'elements' => array(
					'head'    => new \content\pageelement\html\HTMLHead(),
					'body'    => new \content\PageElement(array(
						'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/template.html',
						'elements' => array(
							'header'  => $header,
						),
					)),
				),
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
			if (!$this->getElement('content'))
			{
				$this->addElement('content', '');
			}
			return parent::display();
		}
} // END class Documentation extends \content\PageElement

?>