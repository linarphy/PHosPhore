<?php

namespace route;

/**
 * Manager of Route
 */
class Route extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var array
	 */
	const TABLE = 'route';
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
		'name',
		'type',
	);
}

?>
