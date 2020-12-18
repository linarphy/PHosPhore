<?php

namespace item;

/**
 * Manager for \item\Consumable
 *
 * @author gugus2000
 **/
class ConsumableManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\Consumable
		*
		* @var string
		*/
		const TABLE='consumable';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			5 => 'value',
			6 => 'quality',
		);
} // END class EquipmentManager extends \core\Manager

?>