<?php

namespace database\parameter;

/**
 * an attribute of a table
 */
class Attribute
{
	use \core\Base;

	/**
	 * name of the attribute
	 *
	 * @var string
	 */
	protected string $name;
	/**
	 * table associated to the attribute
	 *
	 * @var \database\parameter\Table
	 */
	protected \database\parameter\Table $table;
}

?>
