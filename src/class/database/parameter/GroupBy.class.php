<?php

namespace database\parameter;

/**
 * Group by part
 */
class GroupBy
{
	use \core\Base;

	/**
	 * attributes to group by
	 *
	 * @var array
	 */
	protected ?array $attributes = null;
	/**
	 * sub group by
	 *
	 * @var array
	 */
	protected ?array $group_by = null;
}

?>
