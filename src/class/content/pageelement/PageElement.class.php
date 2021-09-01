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
	public function __construct(attributes: $attributes)
	{
		foreach ($attributes as $key => $value)
		{
			$method = 'set' . ucfirst($key);
			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['constructor']['unknown_attribute'], array('key' => $key, 'value' => $value, 'method' => $method));
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
	public function addElement(key: $key, value: $value)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageeelement']['addElement'], array('key' => $key, 'value' => $value));

		if (!isset($this->elements[$key]))
		{
			$this->elements[$key] = $value;
			return True;
		}
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
	public function addValueElement(key: $key, value: $value, new_key: $new_key)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageeelement']['addValueElement'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));

		if (!is_array($this->elements[$key]))
		{
			return False; // The first element is not an array
		}
		if (!isset($this->elements[$key][$new_key]))
		{
			$this->elements[$key][$new_key] = $value;
			return True;
		}
		return False; // An identical key already exist
	}
	/**
	 * Display the object in a readable and safe form
	 *
	 * @return string
	 */
	public function display()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageeelement']['display']['start']);

		if ($this->template() !== null)
		{

			if ($GLOBALS['cache']['class']['content']['pageelement']['pageelement']['templates'][$this->template])
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['use_cache'], array('template' => $this->template));

				$content = $GLOBALS['cache']['class']['content']['pageelement']['pageelement']['templates'][$this->template];
			}
			else
			{
				$content = file_get_contents($this->template, true);

				if ($content === False)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['file_template'], array('template' => $this->template));
					$content = '';
				}
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['no_template']);

			$content = '';
		}

		if ($this->elements !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['elements']);

			if ($content !== '')
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['content']);

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
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['cannot_display_object'], array('object' => get_class($element)));
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
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['no_content']);

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
							$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['cannot_display_object'], array('object' => get_class($element)));
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

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['display']['end']);

		return $content;
	}
	/**
	 * Display an array in a safe and readable form
	 *
	 * @param array $list
	 *
	 * @return string
	 */
	public function displayArray(list: $list)
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
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['displayArray']['cannot_display_object'], array('object' => get_class($element)));
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
	public function getElement(key: $key)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['getelement'], array('key' => $key));

		if (isset($this->elements[$key]))
		{
			return $this->elements[$key];
		}
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
	 * @return bool|mixed
	 */
	public function setElement(key: $key, value: $value, strict: $strict = True)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['pageelement']['setelement'], array('key' => $key, 'value' => $value, 'new_key' => $new_key));

		if (isset($this->element[$key]))
		{
			$old_value = $this->elements[$key];
			$this->elements[$key] = $value;
			return $old_value;
		}
		else // Element does not exist
		{
			if ($strict === False)
			{
				$this->elements[$key] = $value;
			}
			return False;
		}
	}
}

?>
