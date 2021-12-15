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
	protected $id;
	/**
	 * user id
	 *
	 * @var int
	 */
	protected $id_user;
	/**
	 * name of the configuration
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * value of the configuration
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
	public function display()
	{
		return $this->displayer('id') . ': ' . $this->displayer('name') . ' => ' . $this->displayer('value');
	}
}

?>
