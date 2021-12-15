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
	protected $id_page;
	/**
	 * Key of the parameter
	 *
	 * @var string
	 */
	protected $key;
	/**
	 * Value of the parameter
	 *
	 * @var string
	 */
	protected $value;
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
