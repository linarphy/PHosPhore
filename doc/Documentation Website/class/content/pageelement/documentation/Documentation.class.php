<?php

namespace content\pageelement\documentation;

/**
 * An HTML Documentation page
 *
 * @author gugus2000
 *
 **/
class Documentation extends \content\pageelement\HTML
{
	/* Method */

		/**
		* Create a \content\pageelement\html\Documentation instance
		*
		* @return void
		*/
		public function __construct()
		{
			$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_css'][]=$GLOBALS['config']['path_asset'].'css/doc/header.css';
			parent::__construct();
			$this->addElement('body', new\content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/documentation/template.html',
				'elements' => array(
					'header' => new \content\pageelement\html\Header(),
				)
			)));
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
} // END class Documentation extends \content\pageelement\HTML

?>
