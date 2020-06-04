<?php

namespace character;

/**
 * Manager of \character\Race
 *
 * @author gugus2000
 **/
class RaceManager extends \core\Manager
{
	/* constant */

		/**
		* table used by character\Race
		*
		* @var string
		*/
		const TABLE='rpg_race';
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
} // END class RaceManager extends \core\Manager

?>