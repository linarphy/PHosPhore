<?php

namespace item;

/**
 * Manager for \item\Equipment
 *
 * @author gugus2000
 **/
class EquipmentManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\Equipment
		*
		* @var string
		*/
		const TABLE='equipment';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'slot',
			3 => 'weight',
			4 => 'armor',
			5 => 'value',
			6 => 'quality',
		);
} // END class EquipmentManager extends \core\Manager

?>