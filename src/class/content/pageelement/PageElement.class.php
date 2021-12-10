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
	protected $template;
	/**
	 * Elements to insert in the template
	 *
	 * @var array
	 */
	protected $elements;
	/**
	 * Constructor
	 *
	 * @param array $attributes Attributes of this object
	 */
	public function __construct($attributes)
	{
		foreach ($attributes as $key => $value)
		{
			$method = 'set' . ucfirst($key);
			if (property_exists($this, $key))
			{
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['unknown_attribute'], array('key' => $key, 'value' => $value, 'method' => $method));
				}
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['unknown_attribute'], array('key' => $key, 'value' => $value, 'method' => $method));
			}
		}
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
	public function addElement($key, $value)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['start'], array('key' => $key, 'value' => $value));

		if (!isset($this->elements[$key]))
		{
			$this->elements[$key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['success'], array('key' => $key, 'value' => $value));
			return True;
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['failure'], array('key' => $key, 'value' => $value));
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
	public function addValueElement($key, $value, $new_key)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['start'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));

		if (!is_array($this->elements[$key]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['not_array'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));
			return False; // The first element is not an array
		}
		if (!isset($this->elements[$key][$new_key]))
		{
			$this->elements[$key][$new_key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['success'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));
			return True;
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['already_taken'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));
		return False; // An identical key already exist
	}
	/**
	 * Display the object in a readable and safe form
	 *
	 * @return string
	 */
	public function display()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['start']);

		if (!isset($GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
		{
			$GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'] = array();
		}

		if ($this->template !== null)
		{
			if (key_exists($this->template, $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['use_cache'], array('template' => $this->get('template')));

				$content = $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'][$this->template];
			}
			else
			{
				$content = file_get_contents($GLOBALS['config']['core']['path']['template'] . $this->template, true);

				if ($content === False)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_file_template'], array('template' => $this->template));
					$content = '';
				}

				$GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'][$this->template] = $content;
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_template']);

			$content = '';
		}

		if ($this->elements !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['elements']);

			if ($content !== '')
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['content']);

				$tokens = preg_split('/({(?:\\}|[^\\}])+})/Um', $content, -1, PREG_SPLIT_DELIM_CAPTURE);

				foreach ($this->elements as $name => $element)
				{
					if (is_object($element))
					{
						if (method_exists($element, 'display'))
						{
							$value = $element->display();
						}
						else
						{
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], array('object' => get_class($element)));
						}
					}
					else if (is_array($element))
					{
						$value = $this->displayArray($element);
					}
					else
					{
						$value = (string) $element;
					}

					if (in_array('{' . $name . '}', $tokens))
					{
						foreach (array_keys($tokens, '{' . $name . '}') as $key_token)
						{
							$tokens[$key_token] = $value;
						}
					}
				}

				$content = implode($tokens);
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_content']);

				foreach ($this->elements as $name => $element)
				{
					if (is_object($element))
					{
						if (method_exists($element, 'display'))
						{
							$value = $element->display();
						}
						else
						{
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], array('object' => get_class($element)));
							$value = '';
						}
					}
					else if (is_array($element))
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
	public function displayArray($list)
	{
		$display = '';
		foreach ($list as $element)
		{
			if (is_object($element))
			{
				if (method_exists($element, 'display'))
				{
					$display .= $element->display();
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['cannot_display_object'], array('object' => get_class($element)));
				}
			}
			else if (is_array($element))
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
	 * @return bool|mixed
	 */
	public function getElement($key)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['start'], array('key' => $key));

		if ($this->elements === null)
		{
			$this->elements = array();

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['elements_null']);
			return False;
		}
		if (key_exists($key, $this->elements))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['success'], array('key' => $key));
			return $this->elements[$key];
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['failure'], array('key' => $key));
		return False; // The element does not exist
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
	public function setElement($key, $value, $strict = True)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['start'], array('key' => $key, 'value' => $value, 'strict' => $strict));

		if ($this->getElement($key) !== False)
		{
			$old_value = $this->elements[$key];
			$this->elements[$key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['change'], array('key' => $key, 'value' => $value));
			return $old_value;
		}
		else // Element does not exist
		{
			if ($strict === False)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['add'], array('key' => $key, 'value' => $value));
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
	protected function setElements(array $elements)
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
	protected function setTemplate(string $template)
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
