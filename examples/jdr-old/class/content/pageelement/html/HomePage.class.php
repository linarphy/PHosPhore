<?php

namespace content\pageelement\html;

/**
 * A page for home application
 *
 * @author gugus2000
 **/
class HomePage extends \content\PageElement
{
	/* method */

		/**
		* Create a \content\pageelement\HTML instance
		* 
		* @return void
		*/
		public function __construct()
		{
			header('Content-Type: text/html;charset=utf-8');
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/homepage/template.html',
				'elements' => array(
					'navbar' => new \content\pageelement\html\NavBar(),
					'head'   => new \content\pageelement\html\HTMLHead(),
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
} // END class HomePage extends \content\PageElement

?>