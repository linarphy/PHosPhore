<?php

namespace user;

/**
 * User configuration
 */
class Configuration extends \core\Managed
{
	/**
	 * configuration id in the database
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * user id
	 *
	 * @var int
	 */
	protected ?int $id_user = null;
	/**
	 * name of the configuration
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * value of the configuration
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
		'id'      => 'int',
		'id_user' => 'int',
		'name'    => 'string',
		'value'   => 'string',
	);
	/**
	 * display the configuration in a friendly way
	 *
	 * @return string
	 */
	public function display() : string
	{
		return $this->displayer('id') . ': ' . $this->displayer('name') . ' => ' . $this->displayer('value');
	}
}

?>
