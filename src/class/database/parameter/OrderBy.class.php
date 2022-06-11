<?php

namespace database\parameter;

/**
 * order by part
 */
class OrderBy
{
	use \core\Base;

	/**
	 * column to order by
	 *
	 * @var ?\database\parameter\Column
	 */
	protected ?\database\parameter\Column $column;
	/**
	 * sub order by structure
	 *
	 * @var ?array
	 */
	protected ?array $order_by;
	/**
	 * type of the order by
	 *
	 * @var ?\database\parameter\OrderByTypes
	 */
	protected ?\database\parameter\OrderByTypes $type = null;
}

?>
