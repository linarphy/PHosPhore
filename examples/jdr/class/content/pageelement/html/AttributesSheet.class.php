<?php

namespace content\pageelement\html;

/**
 * A sheet for attributes
 *
 * @author gugus2000
 **/
class AttributesSheet extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of \content\pageelement\html\AttributesSheet
		*
		* @param character\Attributes Attributes Attributes of the sheet
		*
		* @param character\Attributes MaxAttributes Maximum of the Attributes of the sheet
		* 
		* @return void
		*/
		public function __construct($Attributes, $MaxAttributes)
		{
			$attributes=array();
			foreach ($Attributes::AV_ATTR as $name)
			{
				$method='get'.ucfirst($name);
				$attributes[$name.'_nbr']=$Attributes->$method();
				$attributes[$name.'_nbr_max']=$MaxAttributes->$method();
				$attributes[$name]=$GLOBALS['lang']['class_content_pageelement_html_attributessheet_'.$name];
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/charactersheet/attributes.html',
				'elements' => $attributes,
			));
		}
} // END class AttributesSheet extends \content\PageElement

?>