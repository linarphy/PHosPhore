<?php

namespace content\pageelement;

/**
 * A element of a page
 */
class PageElement
{
	/**
	 * Path to the template file
	 *
	 * @var string
	 */
	public ?string $template = null;
	/**
	 * Elements to insert in the template
	 *
	 * @var array
	 */
	public ?array $elements = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'template' => 'string',
	];
	/**
	 * Constructor
	 *
	 * @param array $attributes Attributes of this object
	 */
	public function __construct(array $attributes)
	{
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', '__construct', 'start'], $this);

		foreach ($attributes as $key => $value)
		{
			$method = 'set' . \ucfirst($key);
			if (\property_exists($this, $key))
			{
				if (\method_exists($this, $method))
				{
					$this->$method($value);
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['unknown_attribute'], ['key' => $key, 'value' => $value, 'method' => $method]);
				}
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['unknown_attribute'], ['key' => $key, 'value' => $value, 'method' => $method]);
			}
		}
$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', '__construct', 'end'], $this);
		return $this;
	}
	/**
	 * Add an element to the elements
	 *
	 * @param string|int $key Key of the element to add
	 *
	 * @param mixed $value Value of the elements to add
	 *
	 * @return bool
	 */
	public function addElement(string|int $key, mixed $value) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['start'], ['key' => $key, 'value' => $value]);
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'start'], [$this, $key, $value]);

		if (!isset($this->elements[$key]))
		{
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'new'], [$this, $key, $value]);
			$this->elements[$key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['success'], ['key' => $key, 'value' => $value]);
			return True;
		}
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'end'], [$this, $key, $value]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['failure'], ['key' => $key, 'value' => $value]);
		return False; // An identical key already exists
	}
	/**
	 * Add an element of an array of elements
	 *
	 * @param string|int $key Key of the element which will contain the element to add
	 *
	 * @param mixed $value Value of the element to add
	 *
	 * @param string|int $new_key Key of the element to add
	 *
	 * @return bool
	 */
	public function addValueElement(string|int $key, mixed $value, string|int $new_key) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['start'], ['key' => $key, 'value' => $value, 'new_key' => $new_key]);
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'start'], [$this, $key, $vlaue, $new_key]);

		if (!\is_array($this->elements[$key]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['not_array'], ['key' => $key, 'value' => $value, 'new_key' => $new_key]);
			return False; // The first element is not an array
		}
		if (!isset($this->elements[$key][$new_key]))
		{
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'new'], [$this, $key, $value, $new_key]);
			$this->elements[$key][$new_key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['success'], ['key' => $key, 'value' => $value, 'new_key' => $new_key]);
			return True;
		}
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'end'], [$this, $key, $value, $new_key]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['already_taken'], ['key' => $key, 'value' => $value, 'new_key' => $new_key]);
		return False; // An identical key already exist
	}
	/**
	 * Display the object in a readable and safe form
	 *
	 * @return string
	 */
	public function display() : string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['start']);
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'start'], $this);

		if (!isset($GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
		{
			$GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'] = [];
		}

		if ($this->template !== null)
		{
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'template'], $this);
			if (\key_exists($this->template, $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['use_cache'], ['template' => $this->template]);
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'cache'], $this);

				$content = $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'][$this->template];
			}
			else
			{
				$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'no_cache'], $this);
				$content = \file_get_contents($GLOBALS['config']['core']['path']['template'] . $this->template, true);

				if ($content === False)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_file_template'], ['template' => $this->template]);
					$content = '';
				}

				$GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'][$this->template] = $content;
			}
		}
		else
		{
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'no_template'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_template']);

			$content = '';
		}

		if ($this->elements !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['elements']);
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'elements'], $this);

			if ($content !== '')
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['content']);

				$tokens = \preg_split('/({(?:\\}|[^\\}])+})/Um', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

				foreach ($this->elements as $name => $element)
				{
					if (\is_object($element))
					{
						if (\method_exists($element, 'display'))
						{
							$value = $element->display();
						}
						else
						{
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], ['object' => get_class($element)]);
						}
					}
					else if (\is_array($element))
					{
						$value = $this->displayArray($element);
					}
					else
					{
						$value = (string) $element;
					}

					if (\in_array('{' . $name . '}', $tokens))
					{
						foreach (\array_keys($tokens, '{' . $name . '}') as $key_token)
						{
							$tokens[$key_token] = $value;
						}
					}
				}

				$content = \implode($tokens);
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_content']);

				foreach ($this->elements as $name => $element)
				{
					if (\is_object($element))
					{
						if (\method_exists($element, 'display'))
						{
							$value = $element->display();
						}
						else
						{
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], ['object' => get_class($element)]);
							$value = '';
						}
					}
					else if (\is_array($element))
					{
						$value = $this->displayArray($element);
					}
					else
					{
						$value = (string) $element;
					}

					$content .= $value;
				}
			}
		}

		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'display', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['end']);

		return $content;
	}
	/**
	 * Display an array in a safe and readable form
	 *
	 * @param array $list
	 *
	 * @return string
	 */
	public function displayArray(array $list) : string
	{
		$display = '';
		foreach ($list as $element)
		{
			if (\is_object($element))
			{
				if (\method_exists($element, 'display'))
				{
					$display .= $element->display();
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['cannot_display_object'], ['object' => get_class($element)]);
				}
			}
			else if (\is_array($element))
			{
				$display .= $this->displayArray($element);
			}
			else
			{
				$display .= (string) $element;
			}
		}
		return $display;
	}
	/**
	 * Accessor of an element of elements, return false if the element do not exist
	 *
	 * @param string|int $key Key corresponding to the element
	 *
	 * @return null|mixed
	 */
	public function getElement(string|int $key) : mixed
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['start'], ['key' => $key]);
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'start'], [$this, $key]);

		if ($this->elements === null)
		{
			$this->elements = array();

			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'null'], [$this, $key]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['elements_null']);
			return null;
		}
		if (\key_exists($key, $this->elements))
		{
			$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'end'], [$this, $key]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['success'], ['key' => $key]);
			return $this->elements[$key];
		}
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'null'], [$this, $key]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['failure'], ['key' => $key]);
		return null; // The element does not exist
	}
	/**
	 * Setter of an element of elements, return false if the elements does not exist
	 *
	 * @param string|int $key Key corresponding to the element
	 *
	 * @param mixed $value New value of the element
	 *
	 * @param bool $strict If strict is true, the value will not be set if the element did not exist before
	 *
	 * @return null|mixed
	 */
	public function setElement(string|int $key, mixed $value, bool $strict = True) : mixed
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['start'], ['key' => $key, 'value' => $value, 'strict' => $strict]);
		$GLOBALS['Hook']->load(['class', 'content', 'pageelement', 'PageElement', 'setElement', 'start'], [$this, $key, $value, $strict]);

		if ($this->getElement($key) !== null)
		{
			$old_value = $this->elements[$key];
			$this->elements[$key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['change'], ['key' => $key, 'value' => $value]);
			return $old_value;
		}
		else // Element does not exist
		{
			if ($strict === False)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['add'], ['key' => $key, 'value' => $value]);
				$this->elements[$key] = $value;
			}
			return null;
		}
	}
	/**
	 * Set the elements attribute if not defined
	 *
	 * @param array $elements
	 *
	 * @return bool
	 */
	protected function setElements(array $elements) : bool
	{
		if ($this->elements !== null)
		{
			return False;
		}

		$this->elements = $elements;
		return True;
	}
	/**
	 * Set the template attribute if not defined
	 *
	 * @param string $template
	 *
	 * @return bool
	 */
	protected function setTemplate(?string $template) : bool
	{
		if ($this->template !== null)
		{
			return False;
		}

		$this->template = $template;
		return True;
	}
}

?>
