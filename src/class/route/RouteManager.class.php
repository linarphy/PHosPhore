<?php

namespace route;

/**
 * Manager of Route
 */
class RouteManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var array
	 */
	const TABLE = 'phosphore_route';
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
		'name',
		'type',
	];
}

?>
