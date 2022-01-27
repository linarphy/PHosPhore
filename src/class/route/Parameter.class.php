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
	protected ?int $id = null;
	/**
	 * Name of the parameter
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * Regex which rule the value
	 *
	 * @var string
	 */
	protected ?string $regex = null;
	/**
	 * If the parameter is necessary
	 *
	 * @var bool
	 */
	protected ?bool $necessary = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id'        => 'int',
		'name'      => 'string',
		'regex'     => 'string',
		'necessary' => 'bool',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * Return the "true" regex (the regex with delimiter, even if no set in $regex)
	 *
	 * @return string
	 */
	public function getFullRegex() : string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['start'], ['regex' => $this->regex()]);
		if (\phosphore_count($this->regex) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['bad_regex'], ['regex' => $this->regex]);

			return '##'; // always false
		}
		if (\phosphore_count($this->regex) === 1)
		{
			$regex = '#\\' . $this->regex . '#';

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['one_escaped'], ['regex' => $regex]);

			return $regex;
		}
		if ($this->regex[0] === $this->regex[phosphore_count($this->regex)])
		{
			if (\in_array($this->regex[0], ['#', '/']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['already_done'], ['regex' => $this->regex]);

				return $this->regex;
			}
		}

		$regex = '#' . $this->regex . '#';

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Parameter']['getFullRegex']['no_delimiter'], ['regex' => $regex]);

		return $regex;
	}
}

?>
