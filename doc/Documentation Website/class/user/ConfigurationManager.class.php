<?php

namespace user;

/**
 * Manager for \user\Configuration
 *
 * @author gugus2000
 **/
class ConfigurationManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by user\Configuration
		*
		* @var string
		*/
		const TABLE='configuration';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'id_user',
			2 => 'name',
			3 => 'value',
		);
} // END class ConfigurationManager extends \core\Manager

?>