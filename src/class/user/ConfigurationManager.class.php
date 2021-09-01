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
	const TABLE = 'configuration';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id',
		'id_user',
		'name',
		'value',
	);
}

?>
