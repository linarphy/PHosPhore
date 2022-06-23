<?php

namespace user;

/**
 * User configuration
 */
class Configuration extends \core\Managed
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
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
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * display the configuration in a friendly way
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string = $attribute) : string
	{
		if ($attribute === null)
		{
			return $this->display_('id') . ': ' . $this->display_('name') . ' => ' . $this->display_('value');
		}
		return $this->display_($attribute);
	}
}

?>
