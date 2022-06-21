<?php

namespace database\request;

/**
 * table query for mysql
 */
class Table extends \database\parameter\Query
{
	/**
	 * keyword
	 *
	 * @var string
	 */
	const KEYWORD = 'TABLE';
	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [
		'table',
		'orderBy',
		'limit',
	];
	/**
	 * required steps for the query to run correctly
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [
		'table',
	];
	/**
	 * table part
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $table;
	/**
	 * limit part
	 *
	 * @var \database\parameter\Limit
	 */
	protected \database\parameter\Limit $limit;
	/**
	 * order by part
	 *
	 * @var \database\parameter\OrderBy
	 */
	protected \database\parameter\OrderBy $orderBy;
}

?>
