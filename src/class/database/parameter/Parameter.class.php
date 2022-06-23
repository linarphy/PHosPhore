<?php

namespace database\parameter;

/**
 * custom parameter
 */
class Parameter
{
	use \core\Base;

	/**
	 * placeholder name
	 *
	 * @var ?string
	 */
	protected ?string $placeholder = null;
	/**
	 * position in the parameter list
	 *
	 * @var int
	 */
	protected int $position;
	/**
	 * value associated
	 *
	 * @var mixed
	 */
	protected mixed $value;
}

?>
