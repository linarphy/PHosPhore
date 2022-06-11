<?php

namespace database\parameter;

/**
 * operator used in conditional statement with subquery
 */
class SubOperator
{
	use \core\Base
	{
		\core\Base::display as display_;
	}

	/**
	 * symbol of the operator
	 *
	 * @var string
	 */
	protected string $symbol;
	/**
	 * if the operator has been checked
	 *
	 * @var bool
	 */
	protected bool $isChecked = False;
	/**
	 * checks the validity of the operator
	 *
	 * @param array $whitelist
	 *
	 * @return bool
	 */
	public function check(array $whitelist)
	{
		if (\in_array($this->get('operator'), $whitelist))
		{
			$this->set('isChecked', True);
		}

		return $this->get('isChecked');
	}
	/**
	 * display the operator
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null)
	{
		if ($attribute === null)
		{
			if (!$isChecked)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['parameter']['Operator']['display']['not_checked']);
				throw new \Exception($GLOBALS['locale']['class']['database']['parameter']['Operator']['display']['not_checked']);
			}
			return $this->display($symbol);
		}
		return $this->display_($attribute);
	}
}

?>
