<?php

namespace content\pageelement\html;

/**
 * An HTML select
 *
 * @author gugus2000
 **/
class HTMLSelect extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of \content\pageelement\html\HTMLSelect
		*
		* @param array elements Elements of the select
		* 
		* @return void
		*/
		public function __construct($elements)
		{
			if (!isset($elements['name']))
			{
				$elements['name']='';
			}
			$options=array();
			if (isset($elements['options']))
			{
				if (is_array($elements['options']))
				{
					foreach ($elements['options'] as $value => $display)
					{
						$options[]=new \content\PageElement(array(
							'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlselect/option.html',
							'elements' => array(
								'value'   => $value,
								'display' => $display,
							),
						));
					}
				}
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlselect/template.html',
				'elements' => array(
					'name'    => $elements['name'],
					'options' => $options,
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
				case 'options':
					$this->addOptions($value);
					break;
				default:
					parent::addValueElement($index, $value);
					break;
			}
		}
		/**
		* Add an option for the select
		*
		* @param array option Elements of the option
		* 
		* @return void
		*/
		public function addOptions($option)
		{
			$options=$this->getElement('options');
			$Option=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlselect/option.html',
				'elements' => array(
					'value'   => $option['value'],
					'display' => $option['display'],
				),
			));
			$options[]=$Option;
			$this->setElement('options', $options);
		}
} // END class HTMLSelect extends \content\PageElement

?>