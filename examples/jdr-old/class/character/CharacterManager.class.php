<?php

namespace character;

/**
 * A Manager of \character\Character
 *
 * @author gugus2000
 **/
class CharacterManager extends \core\Manager
{
	/* constant */

		/**
		* table used by character\Character
		*
		* @var string
		*/
		const TABLE='rpg_character';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0  => 'id',
			1  => 'name',
			2  => 'id_race',
			3  => 'id_class',
			4  => 'hp',
			5  => 'max_hp',
			6  => 'mana',
			7  => 'max_mana',
			8  => 'ap',
			9  => 'max_ap',
			10 => 'level',
			11 => 'xp',
			12 => 'id_inventory',
			13 => 'id_attributes',
			14 => 'id_maxattributes',
			15 => 'id_author',
		);
} // END class CharacterManager extends \core\Manager

?>