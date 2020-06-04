<?php

namespace item;

/**
 * Manager of item\StoredItem
 *
 * @author gugus2000
 **/
class StoredItemManager extends \core\Manager
{
	/* constant */

		/**
		* table used by item\StoredItem
		*
		* @var string
		*/
		const TABLE='stored_item';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'type',
			2 => 'id_name',
			3 => 'id_dynamic',
			4 => 'value',
			5 => 'quality',
			6 => 'id_enchantment',
		);
} // END class StoredItemManager extends \core\Manager

?>