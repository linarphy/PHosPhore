<?php

namespace item\enchant;

/**
 * Manager of \item\enchant\WeaponEnchantment
 *
 * @author gugus2000
 **/
class WeaponEnchantmentManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\enchant\WeaponEnchantment
		*
		* @var string
		*/
		const TABLE='enchant_weapon';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'id_description',
			3 => 'base_value',
		);
} // END class WeaponEnchantmentManager extends \core\Manager

?>