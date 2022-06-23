<?php

namespace database\request;

/**
 * table query for mysql
 */
class Delete extends \database\parameter\Query
{
	/**
	 * keyword
	 *
	 * @var string
	 */
	const KEYWORD = 'DELETE FROM';
	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [
		'delete',
		'where',
		'orderBy',
		'limit',
	];
	/**
	 * required steps for the query to run correctly
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [
		'delete',
	];
	/**
	 * table part
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $delete;
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
	/**
	 * where part
	 *
	 * @var \database\parameter\Expression
	 */
	protected \database\parameter\Expression $where;
}

?>
