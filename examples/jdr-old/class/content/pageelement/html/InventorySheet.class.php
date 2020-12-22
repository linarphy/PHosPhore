<?php

namespace content\pageelement\html;

/**
 * An inventory sheet
 *
 * @author gugus2000
 **/
class InventorySheet extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of \content\pageelement\html\InventorySheet
		*
		* @param \character\Inventory Inventory Inventory of the sheet
		* 
		* @return void
		*/
		public function __construct($Inventory)
		{
			$items=array();
			foreach ($Inventory->getItems() as $item)
			{
				$items[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'pageelement/html/charactersheet/item.html',
					'elements' => array(
						'number' => $item['number'],
						'name'   => $item['item']->display(),
					),
				));
			}
			if (count($Inventory->getItems())===0)
			{
				$items[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'pageelement/html/charactersheet/item.html',
					'elements' => array(
						'number'  => '',
						'name'    => $GLOBALS['lang']['class_pageelement_html_inventorysheet_no_item'],
					),
				));
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/charactersheet/inventory.html',
				'elements' => array(
					'items' => $items,
				),
			));
		}
} // END class InventorySSheet extends \content\PageElement

?>