<?php

namespace content\pageelement\html;

/**
 * An HTML fieldset
 *
 * @author gugus2000
 **/
class HTMLFieldset extends \content\PageElement
{
	/* method */

		/**
		* Creation of a \content\pageelement\html\HTMLFieldset instance
		*
		* @param array elements Elements of the fieldset
		* 
		* @return void
		*/
		public function __construct($elements)
		{
			if (!isset($elements['legend']))
			{
				$elements['legend']='';
			}
			if (!isset($elements['content']))
			{
				$elements['content']='';
			}
			if (!isset($elements['subfieldsets']))
			{
				$elements['subfieldsets']=array();
			}
			else
			{
				if (is_array($elements['subfieldsets']))
				{
					$subfieldsets=array();
					foreach ($elements['subfieldsets'] as $fieldset)
					{
						$subfieldsets[]=new \content\pageelement\html\HTMLFieldset($fieldset);
					}
				}
				else
				{
					$subfieldsets=array();
				}
				$elements['subfieldsets']=$subfieldsets;
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlfieldset/template.html',
				'elements' => array(
					'legend'       => $elements['legend'],
					'content'      => $elements['content'],
					'subfieldsets' => $elements['subfieldsets'],
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
				case 'subfieldsets':
					$this->addSubieldsets($value);
					break;
				default:
						parent::addValueElement($index, $value);
					break;
			}
		}
		/**
		* Add a subfieldset to the form
		*
		* @param array fieldset Element of the fieldset to add
		* 
		* @return mixed
		*/
		public function addSubfieldsets($fieldset)
		{
			$fieldsets=$this->getElement('fieldsets');
			$Fieldset=new \content\pageelement\html\HTMLFieldset($fieldset);
			$fieldsets[]=$Fieldset;
			$this->setElement('fieldsets', $fieldsets);
		}
} // END class HTMLFieldset extends \content\PageElement

?>