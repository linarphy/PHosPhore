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
	const TABLE = 'posphore_link_route_route_parameter';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_parameter',
		'id_route',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATRIBUTES = array(
		'id_parameter',
		'id_route',
	);
}

?>
