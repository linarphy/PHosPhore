<?php

namespace item;

/**
 * Manager for \item\Weapon
 *
 * @author gugus2000
 **/
class WeaponManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\Weapon
		*
		* @var string
		*/
		const TABLE='weapon';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'attack_type',
			3 => 'slot',
			4 => 'damage',
			5 => 'value',
			6 => 'quality',
		);
} // END class EquipmentManager extends \core\Manager

?>