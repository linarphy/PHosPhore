<?php

namespace route;

/**
 * A route parameter
 */
class Parameter extends \core\Managed
{
	/**
	 * Index in the database
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * Name of the parameter
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * Regex which rule the value
	 *
	 * @var string
	 */
	protected $regex;
	/**
	 * If the parameter is necessary
	 *
	 * @var bool
	 */
	protected $necessary;
	/**
	 * Return the "true" regex (the regex with delimiter, even if no set in $regex)
	 *
	 * @return string
	 */
	public function getFullRegex()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['start'], array('regex' => $this->regex()));
		if (phosphore_count($this->regex) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['bad_regex'], array('regex' => $this->regex));

			return '##'; // always false
		}
		if (phosphore_count($this->regex) === 1))
		{
			$regex = '#\\' . $this->regex . '#';

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['one_escaped'], array('regex' => $regex));

			return $regex;
		}
		if ($this->regex[0] === $this->regex[phosphore_count($this->regex)])
		{
			if (in_array($this->regex[0], []))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['already_done'], array('regex' => $this->regex));

				return $this->regex;
			}
		}

		$regex = '#' . $this->regex . '#';

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['no_delimiter'], array('regex' => $regex));

		return $regex;
	}
}

?>
