<?php

namespace character;

/**
 * Manager for \character\Character
 *
 * @package jdr
 * @author gugus2000
 **/
class CharacterManager extends \core\Manager
{
	/* Constant */

		/**
		 * Name of the table linked to the object
		 *
		 * @var string
		 **/
		const TABLE='character';
		/**
		 * List of all table attributes
		 *
		 * @var array
		 **/
		const ATTRIBUTES=array(
			'id',
			'name',
			'bio',
			'experience',
			'_class',
			'race',
			'state',
			'registration_date',
			'last_login_date',
			'id_author',
			'id_party',
			'id_inventory',
			'id_attributes'n
			'id_effects',
			'id_spells',
		);
}

?>
