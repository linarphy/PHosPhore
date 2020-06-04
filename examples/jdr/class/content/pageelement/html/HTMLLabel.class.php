<?php

namespace content\pageelement\html;

/**
 * An HTML label
 *
 * @author gugus2000
 **/
class HTMLLabel extends \content\PageElement
{
	/* method */

		/**
		* Creatio of an instance of \content\pageelement\html\HTMLLabel
		*
		* @param array elements Elements of the label
		* 
		* @return void
		*/
		public function __construct($elements)
		{
			if (!isset($elements['for']))
			{
				$elements['for']='';
			}
			if (!isset($elements['display']))
			{
				$elements['display']='';
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmllabel/template.html',
				'elements' => array(
					'for'     => $elements['for'],
					'display' => $elements['display'],
				),
			));
		}
} // END class HTMLLabel extends \content\PageElement

?>