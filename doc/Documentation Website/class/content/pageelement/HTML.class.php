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
			header('Content-Type: text/html;charset=utf-8');
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/template.html',
				'elements' => array(
					'head' => new \content\pageelement\html\HTMLHead(),
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
			global $Visitor;
			if (!$this->getElement('lang'))
			{
				$this->addElement('lang', $Visitor->getConfiguration('lang'));
			}
			if (!$this->getElement('notifications'))
			{
				$this->addElement('notifications', '');
			}
			if (!$this->getElement('body'))
			{
				$this->addElement('body', '');
			}
			return parent::display();
		}
} // END class HTML extends \content\PageElement

?>
