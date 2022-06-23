<?php

namespace database\parameter;

/**
 * a database query
 */
abstract class Query
{
	use \core\Base;

	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [];
	/**
	 * required steps for the query to run correctly
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [];
}

?>
