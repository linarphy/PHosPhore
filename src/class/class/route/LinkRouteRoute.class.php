<?php

namespace route;

/**
 * Manager of links between two routes
 */
class LinkRouteRoute extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'linkroutes';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_route_parent',
		'id_route_child',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_route_parent',
		'id_route_child',
	);
}

?>
