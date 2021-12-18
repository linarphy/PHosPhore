<?php

namespace user;

/**
 * Parameter of a page
 */
class Parameter extends \core\Managed
{
	/**
	 * Id of the page
	 *
	 * @var int
	 */
	protected ?int $id_page = null;
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
	const ATTRIBUTES = array(
		'id_page' => 'int',
		'key'     => 'string',
		'value'   => 'string',
	);
}

?>
