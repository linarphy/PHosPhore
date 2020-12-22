<?php

namespace character;

/**
 * Manager of \character\RpgClass
 *
 * @author gugus2000
 **/
class RpgClassManager extends \core\Manager
{
	/* constant */

		/**
		* table used by character\RpgClass
		*
		* @var string
		*/
		const TABLE='rpg_class';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_name',
			2 => 'id_attributes',
		);
} // END class RpgClassManager extends \core\Manager

?>