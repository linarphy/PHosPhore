<?php

namespace user;

/**
 * Parameter of a page
 */
class Parameter extends \core\Managed
{
	/**
	 * Id of the parameter
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * Key of the parameter
	 *
	 * @var string
	 */
	protected ?string $key = null;
	/**
	 * Value of the parameter
	 *
	 * @var string
	 */
	protected ?string $value = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id' => 'int',
		'key'     => 'string',
		'value'   => 'string',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
}

?>
