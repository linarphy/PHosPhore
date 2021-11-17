<?php

namespace route;

/**
 * Manager of \route\Parameter
 */
class ParameterManager extends \core\Manager
{
	/** table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_route_parameter';
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
		'regex',
		'necessary',
	);
}

?>
