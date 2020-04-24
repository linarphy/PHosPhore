<?php

namespace content\pageelement\html;

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
		* Create a \content\pageelement\html\Documentation instance
		* 
		* @return void
		*/
		public function __construct()
		{
			if (isset($GLOBALS['config']['default_head_css']))
			{
				$GLOBALS['config']['default_head_css'][]='/asset/css/doc/header.css';
			}
			else
			{
				$GLOBALS['config']['default_head_css']=array('asset/css/doc/header.css');
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/template.html',
				'elements' => array(
					'head'    => new \content\pageelement\html\HTMLHead(),
					'body'    => new \content\PageElement(array(
						'template' => $GLOBALS['config']['path_template'].'pageelement/html/documentation/template.html',
						'elements' => array(
							'header'  => new \content\pageelement\html\Header(),
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