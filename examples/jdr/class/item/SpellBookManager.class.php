<?php

namespace item;

/**
 * Manager of \item\SpellBook
 *
 * @author gugus2000
 **/
class SpellBookManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by item\SpellBook
		*
		* @var string
		*/
		const TABLE='spellbook';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'id_element',
			3 => 'damage',
			4 => 'cost',
			5 => 'base_range',
			6 => 'area',
			7 => 'value',
			8 => 'quality',
		);
} // END class SpellBookManager extends \core\Manager

?>