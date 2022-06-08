<?php

namespace database\parameter;

/**
 * used to get only part of data
 */
class Limit
{
	use \core\Base;

	/**
	 * offset
	 *
	 * @var ?int
	 */
	protected ?int $offset = null;
	/**
	 * number of data taken
	 *
	 * @var int
	 */
	protected int $count;
}

?>
