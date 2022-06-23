<?php

namespace database\parameter;

/**
 * a column of a table (can be dynamic)
 */
class Column
{
	use \core\Base;

	/**
	 * alias of the column (if any)
	 *
	 * @var ?string
	 */
	protected ?string $alias = null;
	/**
	 * attribute of the column (if any)
	 *
	 * @var ?\database\parameter\Attribute
	 */
	protected ?\database\parameter\Attribute $attribute = null;
	/**
	 * function applied to the attribute (if any)
	 *
	 * @var ?string
	 */
	protected ?string $function = null;
}

?>
