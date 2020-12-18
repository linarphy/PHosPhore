<?php

namespace content\pageelement\html;

/**
 * An HTML input
 *
 * @author gugus2000
 **/
class HTMLInput extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of \content\pageelement\html\HTMLInput
		*
		* @param array elements Elements of the input
		* 
		* @return void
		*/
		public function __construct($elements)
		{
			if (!isset($elements['type']))
			{
				$type='text';
			}
			else
			{
				$type=$elements['type'];
				unset($elements['type']);
			}
			$attrs=array();
			if (!empty($elements))
			{
				foreach ($elements as $name => $value)
				{
					$attrs[]=new \content\PageElement(array(
						'template' => $GLOBALS['config']['path_template'].'pageelement/html/attr.html',
						'elements' => array(
							'name'  => $name,
							'value' => $value,
						),
					));
				}
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlinput/template.html',
				'elements' => array(
					'type'  => $type,
					'attrs' => $attrs,
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
				case 'attrs':
					$this->addAttrs($value);
					break;
				default:
					parent::addValueElement($index, $value);
					break;
			}
		}
		/**
		* Adds an attribute on the list of attributes
		*
		* @param array attr Attribute to add
		* 
		* @return void
		*/
		public function addAttrs($attr)
		{
			$attrs=$this->getElement('attrs');
			$Attr=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/attr.html',
				'elements' => array(
					'name'  => $attr['name'],
					'value' => $attr['value'],
				),
			));
			$attrs[]=$Attr;
			$this->setElement('attrs', $attrs);
		}
} // END class HTMLInput extends \content\PageElement

?>