<?php

namespace user;

/**
 * Manager of \user\Configuration
 */
class ConfigurationManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_configuration';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id',
		'id_user',
		'name',
		'value',
	];
}

?>
