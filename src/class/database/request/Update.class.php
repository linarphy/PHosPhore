<?php

namespace database\request;

/**
 * update query
 */
class Update extends \database\parameter\Query
{
	/**
	 * keyword
	 *
	 * @var string
	 */
	const KEYWORD = 'UPDATE';
	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [
		'table',
		'sets',
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
		'table',
		'sets',
	];
	/**
	 * group by part
	 *
	 * @var \database\parameter\GroupBy
	 */
	protected \database\parameter\GroupBy $groupBy;
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
	 * sets part
	 *
	 * @var array
	 */
	protected array $sets;
	/**
	 * table part
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $table;
	/**
	 * where part
	 *
	 * @var \database\parameter\Expression
	 */
	protected \database\parameter\Expression $where;
}

?>
