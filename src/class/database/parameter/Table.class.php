<?php

namespace database\parameter;

/**
 * a table of a database
 */
class Table
{
	use \core\Base;

	/**
	 * alias of the table
	 *
	 * @var ?string
	 */
	protected ?string $alias = null;
	/**
	 * name of the table
	 *
	 * @var ?string
	 */
	protected ?string $name = null;
	/**
	 * subquery if it is a subquery
	 *
	 * @var ?\database\parameter\Query
	 */
	protected ?\database\parameter\Query $subquery = null;
}

?>
