<?php

namespace character;

/**
 * Manager of character\Attributes
 *
 * @author gugus2000
 **/
class AttributesManager extends \core\Manager
{
	/* constant */

		/**
		* table used by character\Class
		*
		* @var string
		*/
		const TABLE='rpg_attributes';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'str',
			2 => 'dex',
			3 => 'con',
			4 => 'int_',
			5 => 'cha',
			6 => 'agi',
			7 => 'mag',
			8 => 'acu',
		);
} // END class AttributesManager extends \core\Manager

?>