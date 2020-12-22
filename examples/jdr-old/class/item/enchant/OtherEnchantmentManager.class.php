<?php

namespace item\enchant;

/**
 * Manager of \item\enchant\OtherEnchantment
 *
 * @author gugus2000
 **/
class OtherEnchantmentManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\enchant\OtherEnchantment
		*
		* @var string
		*/
		const TABLE='enchant_other';
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
} // END class OtherEnchantmentManager extends \core\Manager

?>