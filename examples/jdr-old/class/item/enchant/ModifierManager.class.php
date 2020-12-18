<?php

namespace item\enchant;

/**
 * Manager of \item\enchant\Modifier
 *
 * @author gugus2000
 **/
class ModifierManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\Modifier
		*
		* @var string
		*/
		const TABLE='enchant_modifier';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id_enchant',
			1 => 'replacer',
			2 => 'base',
			3 => 'max',
			4 => 'value',
			5 => 'luck',
			6 => 'type',
		);
} // END class ModifierManager extends \core\Manager

?>