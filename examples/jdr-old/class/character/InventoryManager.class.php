<?php

namespace character;

/**
 * Manager of Inventory
 *
 * @author gugus2000
 **/
class InventoryManager extends \core\LinkManager
{
	/* constant */

		/**
		* table used by character\Inventory
		*
		* @var string
		*/
		const TABLE='rpg_inventory';
		/**
		* Index used (primary key)
		*
		* @var string
		*/
		const INDEX='id_inventory';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id_inventory',
			1 => 'id_item',
			2 => 'number',
		);
} // END class InventoryManager extends \core\LinkManager

?>