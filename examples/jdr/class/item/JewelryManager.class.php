<?php

namespace item;

/**
 * Manager for \item\Jewelry
 *
 * @author gugus2000
 **/
class JewelryManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\Jewelry
		*
		* @var string
		*/
		const TABLE='jewelry';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'slot',
			3 => 'value',
			4 => 'quality',
		);
} // END class EquipmentManager extends \core\Manager

?>