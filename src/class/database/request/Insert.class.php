<?php

namespace database\request;

/**
 * select query for mysql
 */
class Insert extends \database\parameter\Query
{
	/**
	 * keyword
	 *
	 * @var string
	 */
	const KEYWORD = 'INSERT INTO';
	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [
		'table',
		'parameters',
		'values',
	];
	/**
	 * required steps for the query to run correctly
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [
		'table',
		'parameters',
		'values',
	];
	/**
	 * parameters part
	 *
	 * @var array
	 */
	protected array $parameters;
	/**
	 * table part
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $table;
	/**
	 * values part
	 *
	 * @var array
	 */
	protected array $values;
}

?>
