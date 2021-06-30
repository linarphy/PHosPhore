<?php

namespace route;

/**
 * A route parameter
 */
class Parameter extends \core\Manager
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
		if (count($this->regex) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['route']['parameter']['bad_regex'], array('regex' => $this->regex));

			return '##'; // always false
		}
		if (ctype_alnum($this->regex[0]) || $this->regex[0] === '\\' || ctype_space($this->regex[0])) // first character is not a delimiter
		{
			return '#' . $this->regex[0] . '#';
		}
		for ($i = count($this->regex); $i > 0; $i--)
		{
			if (!ctype_alnum($this->regex[$i]))
			{
				break;
			}
		}
		if ($this->regex[$i] === '\\' || ctype_space($this->regex[$i])) // last character which is not a modifier (alphanumeric character) is not a delimiter
		{
			return '#' . $this->regex[0] . '#';
		}
		if ($this->regex[0] === $this->regex[$i])
		{
			if ($i != 0)
			{
				return $this->regex;
			}
			return '#' . $this->regex . '#';
		}
	}
}

?>
