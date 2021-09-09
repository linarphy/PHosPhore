<?php

namespace user;

/**
 * Manager of \user\Parameter
 */
class ParameterManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'page_parameter';
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
		'key',
		'value',
	);
}

?>
