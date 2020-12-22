<?php

namespace item\enchant;

/**
 * Manager of item\StoredModifier
 *
 * @author gugus2000
 **/
class StoredModifierManager extends \core\Manager
{
	/* constant */

		/**
		* table used by item\enchant\StoredModifier
		*
		* @var string
		*/
		const TABLE='stored_modifier';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id_enchant',
			1 => 'replacer',
			2 => 'upgrade',
		);
} // END class StoredModifierManager extends \core\Manager

?>