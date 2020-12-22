<?php

namespace item\enchant;

/**
 * Manager of item\enchant\StoredEnchantment
 *
 * @author gugus2000
 **/
class StoredEnchantmentManager extends \core\Manager
{
	/* constant */

		/**
		* table used by item\enchant\StoredEnchantment
		*
		* @var string
		*/
		const TABLE='stored_enchantment';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'type',
			2 => 'id_name',
			3 => 'id_description',
			4 => 'id_dynamic',
		);
} // END class StoredEnchantmentManager extends \core\Manager

?>