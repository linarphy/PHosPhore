<?php

namespace database\parameter;

/**
 * used to join multiple table
 */
class Join
{
	use \core\Base;

	/**
	 * join type which does not need an ON condition for mysql
	 *
	 * @var array
	 */
	const TYPES_WITHOUT_ON = [
		\database\parameter::CROSS,
	];
	/**
	 * expression to join (if needed)
	 *
	 * @var ?\database\parameter\Expression
	 */
	protected ?\database\parameter\Expression $expression;
	/**
	 * subquery if not a table to join
	 *
	 * @var ?\database\parameter\Query
	 */
	protected ?\database\parameter\Query $subquery;
	/**
	 * subquery alias if any
	 *
	 * @var ?string
	 */
	protected ?string $subquery_alias = null;
	/**
	 * table to join
	 *
	 * @var ?\database\parameter\Table
	 */
	protected ?\database\parameter\Table $table;
	/**
	 * type of the join
	 *
	 * @var \database\parameter\JoinTypes
	 */
	protected \database\parameter\JoinTypes $type;
}

?>
