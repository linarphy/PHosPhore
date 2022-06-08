<?php

namespace database\mysql;

/**
 * select query for mysql
 */
class Select extends \database\parameter\Query
{
	/**
	 * keyword
	 *
	 * @var string
	 */
	const KEYWORD = 'SELECT';
	/**
	 * steps order
	 *
	 * @var array
	 */
	const STEPS = [
		'distinct',
		'select',
		'from',
		'joins',
		'where',
		'groupBy',
		'having',
		'orderBy',
		'limit',
	];
	/**
	 * required steps for the query to run correctly
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [
		'from',
		'select',
	];
	/**
	 * distinct part
	 *
	 * @var bool
	 */
	protected bool $distinct;
	/**
	 * from part
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $from;
	/**
	 * group by part
	 *
	 * @var \database\parameter\GroupBy
	 */
	protected \database\parameter\GroupBy $groupBy;
	/**
	 * having part
	 *
	 * @var \database\parameter\Expression
	 */
	protected \database\parameter\Expression $having;
	/**
	 * joins part
	 *
	 * @var array
	 */
	protected array $joins;
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
	 * select part
	 *
	 * @var array
	 */
	protected array $select;
	/**
	 * where part
	 *
	 * @var \database\parameter\Expression
	 */
	protected \database\parameter\Expression $where;
}

?>
