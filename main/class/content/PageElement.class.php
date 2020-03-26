<?php

namespace content;

/**
 * Element which contains variabe content
 *
 * @author gugus2000
 **/
class PageElement
{
	/* Constant */

		/**
		* Separator used for element insertion in the template
		*
		* @var string
		*/
		const SEPARATOR='|';

	/* Attribute */

		/**
		* Path to the template
		* 
		* @var string
		*/
		protected $template;
		/**
		* Array of dynamic elements
		* 
		* @var array
		*/
		protected $elements;

	/* Method */

		/* Getter */

			/**
			* template accessor
			* 
			* @return string
			*/
			public function getTemplate()
			{
				return $this->template;
			}
			/**
			* elements accessor
			* 
			* @return array
			*/
			public function getElements()
			{
				return $this->elements;
			}

		/* Setter */

			/**
			* template setter
			*
			* @param string $template Path to the template
			* 
			* @return void
			*/
			protected function setTemplate($template)
			{
				$this->template=$template;
			}
			/**
			* elements setter
			*
			* @param array elements Array of dynamic elements
			* 
			* @return void
			*/
			protected function setElements($elements)
			{
				$this->elements=$elements;
			}

		/* Display */

			/**
			* template display
			* 
			* @return string
			*/
			public function displayTemplate()
			{
				return htmlspecialchars($this->template);
			}
			/**
			* elements display
			* 
			* @return string
			*/
			public function displayElements()
			{
				return print_r($this->elements);
			}

		/**
		* Display of an array
		*
		* @param array $list List of elements
		* 
		* @return string
		*/
		public function displayArray($list)
		{
			$display='';
			foreach ($list as $element)
			{
				if (is_object($element))
				{
					$display.=$element->display();
				}
				else if (is_array($element))
				{
					$display.=$this->displayArray($element);
				}
				else
				{
					$display.=$element;
				}
			}
			return $display;
		}
		/**
		* Display the "deployed" element
		* 
		* @return string
		*/
		public function display()
		{
			if ($this->getTemplate()!==null)
			{
				if (!isset($GLOBALS['cache_pageElement']))
				{
					$GLOBALS['cache_pageElement']=array();
				}
				if (!isset($GLOBALS['cache_pageElement'][$this->getTemplate()]))
				{
					$GLOBALS['cache_pageElement'][$this->getTemplate()]=file_get_contents($this->getTemplate());
				}
				$contentElement=$GLOBALS['cache_pageElement'][$this->getTemplate()];
			}
			else
			{
				$contentElement='';
			}
			if ($this->getElements()!==null)
			{
				foreach ($this->getElements() as $name => $element)
				{
					if (is_object($element))
					{
						$value=$element->display();
					}
					else if (is_array($element))
					{
						$value=$this->displayArray($element);
					}
					else
					{
						$value=$element;
					}
					if ($this->getTemplate()!==null)
					{
						$contentElement=str_replace($this::SEPARATOR.$name.$this::SEPARATOR, $value, $contentElement);
					}
					else
					{
						$contentElement.=$value;
					}
				}
			}
			return $contentElement;
		}
		/**
		* Accessor of an element of elements
		*
		* @param mixed $index Index of the element to be recovered
		* 
		* @return mixed
		*/
		public function getElement($index)
		{
			if (isset($this->elements[$index]))
			{
				return $this->elements[$index];
			}
			return False;
		}
		/**
		* Definer of an element of elements
		*
		* @param mixed $index Index of the element to be defined
		*
		* @param mixed $value Value of the element to be defined
		* 
		* @return void
		*/
		protected function setElement($index, $value)
		{
			if (isset($this->elements[$index]))
			{
				$this->elements[$index]=$value;
			}
		}
		/**
		* Add an element
		*
		* @param string $name Name of the element to be added
		*
		* @param mixed $element Element to add
		* 
		* @return void
		*/
		public function addElement($name, $element)
		{
			$this->elements[$name]=$element;
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
			if (is_array($this->getElement($index)))
			{
				if (!in_array($value, $this->elements[$index]))
				{
					$this->elements[$index][]=$value;
				}
			}
			else if (is_string($this->getElement($index)))
			{
				$this->elements[$index].=(string)$value;
			}
			else
			{
				throw new \Exception($GLOBALS['lang']['class_content_pageelement_cannot_add_value']);
			}
		}
		/**
		* Create a \content\PageElement instance
		*
		* @param array $attributes Attributes of the PageElement
		*
		* @return void
		*/
		public function __construct($attributes)
		{
			foreach ($attributes as $key => $value)
			{
				$method='set'.ucfirst($key);
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}
} // END class PageElement

?>