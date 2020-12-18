<?php

namespace content\pageelement\html;

/**
 * An HTML form
 *
 * @author gugus2000
 **/
class HTMLForm extends \content\PageElement
{
	/* method */

		/**
		* Creation of a \content\pageelement\html\HTMLForm instance
		*
		* @param array elements Elements of the form
		* 
		* @return void
		*/
		public function __construct($elements)
		{
			global $Router;
			if (!isset($elements['action']))
			{
				$elements['action']=$Router->createLink($Router->decodeRoute($_SERVER['REQUEST_URI']));
			}
			$elements['action']=str_replace('&', '&amp;', $elements['action']);
			if (!isset($elements['method']))
			{
				$elements['method']='GET';
			}
			if (!isset($elements['enctype']))
			{
				$elements['enctype']='';
			}
			if (!isset($elements['fieldsets']))
			{
				$elements['fieldsets']=array();
			}
			else
			{
				if (is_array($elements['fieldsets']))
				{
					$fieldsets=array();
					foreach ($elements['fieldsets'] as $fieldset)
					{
						$fieldsets[]=new \content\pageelement\html\HTMLFieldset($fieldset);
					}
				}
				else
				{
					$fieldsets=array();
				}
				$elements['fieldsets']=$fieldsets;
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlform/template.html',
				'elements' => array(
					'action'    => $elements['action'],
					'method'    => $elements['method'],
					'enctype'   => $elements['enctype'],
					'fieldsets' => $elements['fieldsets'],
				),
			));
		}
		/**
		* Adds an element in an array element in elements
		*
		* @param mixed $index Index of the element to which to add the value
		*
		* @param mixed $value Value of the element of the element to be added
		* 
		* @return void
		*/
		public function addValueElement($index, $value)
		{
			switch ($index)
			{
				case 'fieldsets':
					$this->addFieldsets($value);
					break;
				default:
						parent::addValueElement($index, $value);
					break;
			}
		}
		/**
		* Add a fieldset to the form
		*
		* @param array fieldset Element of the fieldset to add
		* 
		* @return mixed
		*/
		public function addFieldsets($fieldset)
		{
			$fieldsets=$this->getElement('fieldsets');
			$Fieldset=new \content\pageelement\html\HTMLFieldset($fieldset);
			$fieldsets[]=$Fieldset;
			$this->setElement('fieldsets', $fieldsets);
		}
} // END class HTMLForm extends \content\PageElement

?>