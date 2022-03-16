<?php

namespace route;

/**
 * Link between parameters and routes
 */
class LinkRouteParameter extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_link_route_route_parameter';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id_parameter',
		'id_route',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id_parameter',
		'id_route',
	];
}

?>
