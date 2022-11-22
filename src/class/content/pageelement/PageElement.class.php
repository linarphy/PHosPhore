<?php

namespace content\pageelement;

/**
 * A element of a page
 */
class PageElement
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
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
	 * Constructor
	 *
	 * @param array $attributes Attributes of this object
	 */
	public function __construct(array $attributes)
	{
		try
		{
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', '__construct', 'start'], $this);

			try
			{
				$this->hydrate($attributes);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['error_hydrate'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', '__construct', 'end'], $this);
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception,
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['__construct']['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
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
	public function addElement(string|int $key, mixed $value) : bool
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['start'], ['key' => $key, 'value' => $value]);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'start'], [$this, $key, $value]);

			if (\key_exists($key, $this->get('elements')))
			{
				throw new \exception\class\content\pagelement\PageElementException(
					message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['identical_key'],
					tokens:  [
						'key'   => $key,
						'value' => $value,
					],
				);
			}

			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'new'], [$this, $key, $value]);
			$this->elements[$key] = $value;
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addElement', 'end'], [$this, $key, $value]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['success'], ['key' => $key, 'value' => $value]);
			return True;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			try
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['error'],
					tokens:       [
						'key'       => $key,
						'value'     => $value,
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					notification: new \user\Notification([
						'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['addElement']['error'],
						'type'    => \user\NotificationTypes::WARNING,
					]),
					previous:     $exception,
				);
			}
			catch (\exception\class\content\pageelement\PageElementException $exception)
			{
				return False;
			}
		}
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
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['start'], ['key' => $key, 'value' => $value, 'new_key' => $new_key]);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'start'], [$this, $key, $vlaue, $new_key]);

			try
			{
				if (!\key_exists($key, $this->get('element')))
				{
					throw new \exception\class\content\pageelement\PageElementException(
						message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['unknown_key'],
						tokens:  [
							'key'     => $key,
							'new_key' => $new_key,
						],
					);
				}
			}
			catch (\exception\class\core\Base $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['error_get'],
					tokens: [
						'key'       => $key,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
			if (!\is_array($this->elements[$key]))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['not_array'],
					tokens:  [
						'key'     => $key,
						'new_key' => $new_key,
					],
				);
			}
			if (\key_exists($new_key, $this->get('elements')[$key]))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['already_taken'],
					tokens:  [
						'key'     => $key,
						'new_key' => $new_key,
					],
				);
			}
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'new'], [$this, $key, $value, $new_key]);
			$this->elements[$key][$new_key] = $value;
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['success'], ['key' => $key, 'new_key' => $new_key]);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'end'], [$this, $key, $varlue, $new_key]);
			return True;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			try
			{
				$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'addValueElement', 'end'], [$this, $key, $varlue, $new_key]);
				throw new \exception\class\content\pageelement\PageElementException(
					message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['error'],
					tokens:       [
						'key'       => $key,
						'new_key'   => $new_key,
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					notification: new \user\Notification([
						'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['addValueElement']['error'],
						'type'    => \user\NotificationTypes::WARNING,
					]),
					previous:     $exception,
				);
			}
			catch (\exception\class\content\pageelement\PageElementException $exception)
			{
				return False;
			}
		}
	}
	/**
	 * Display the object in a readable and safe form
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		try
		{
			if ($attribute !== null)
			{
				try
				{
					$this->display_($attribute);
				}
				catch (\exception\class\core\Base $exception)
				{
					throw new \exception\class\content\pageelement\PageElementException(
						message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['error_display'],
						tokens:   [
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['start']);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'start'], $this);

			if (!isset($GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
			{
				$GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'] = [];
			}

			try
			{
				if ($this->get('template') !== null)
				{
					$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'template'], $this);
					if (\key_exists($this->get('template'), $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates']))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['use_cache'], ['template' => $this->template]);
						$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'cache'], $this);

						$content = $GLOBALS['cache']['class']['content']['pageelement']['PageElement']['templates'][$this->template];
					}
					else
					{
						$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'no_cache'], $this);
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
					$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'no_template'], $this);
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_template']);

					$content = '';
				}
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_get'],
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			if ($this->elements !== null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['elements']);
				$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'elements'], $this);

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
								try
								{
									$value = $element->display();
								}
								catch (
									\exception\class\content\pageelement\PageElementException |
									\exception\class\contetn\pageelement\BaseException $exception
								)
								{
									throw new exception\class\content\pageelement\PageElementException(
										message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_element_display'],
										tokens: [
											'element_clas' => \get_class($element),
											'exception'    => $exception,
										],
										previous: $exception,
									);
								}
							}
							else
							{
								$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], ['object' => get_class($element)]);
							}
						}
						else if (\is_array($element))
						{
							try
							{
								$value = $this->displayArray($element);
							}
							catch (\exception\class\content\pageelement\PageElementException $exception)
							{
								throw new \exception\class\content\pageelement\PageElementException(
									message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_displayArray'],
									tokens:   [
										'exception'     => $exception->getMessage(),
									],
									previous: $exception,
								);
							}
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
								try
								{
									$value = $element->display();
								}
								catch (
									\exception\class\content\pageelement\PageElementException |
									\exception\class\contetn\pageelement\BaseException $exception
								)
								{
									throw new exception\class\content\pageelement\PageElementException(
										message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_element_display'],
										tokens: [
											'element_clas' => \get_class($element),
											'exception'    => $exception,
										],
										previous: $exception,
									);
								}
							}
							else
							{
								$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'], ['object' => get_class($element)]);
								$value = '';
							}
						}
						else if (\is_array($element))
						{
							try
							{
								$value = $this->displayArray($element);
							}
							catch (\exception\class\content\pageelement\PageElementException $exception)
							{
								throw new \exception\class\content\pageelement\PageElementException(
									message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_displayArray'],
									tokens:   [
										'exception'     => $exception->getMessage(),
									],
									previous: $exception,
								);
							}
						}
						else
						{
							$value = (string) $element;
						}

						$content .= $value;
					}
				}
			}

			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'display', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['end']);

			return $content;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error'],
				tokens:       [
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				logger_types: [
					\core\LoggerTypes::ERROR,
					'class',
					'core',
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['display']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
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
		try
		{
			$display = '';
			foreach ($list as $element)
			{
				if (\is_object($element))
				{
					if (\method_exists($element, 'display'))
					{
						try
						{
							$display .= $element->display();
						}
						catch (\exception\CustomException $exception)
						{
							throw new \exception\class\content\pageelement\PageElementException(
								message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['error_display'],
								tokens:   [
									'exception' => $exception->getMessage(),
								],
								previous: $exception,
							);
						}
					}
					else
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['cannot_display_object'], ['object' => get_class($element)]);
					}
				}
				else if (\is_array($element))
				{
					try
					{
						$display .= $this->displayArray($element);
					}
					catch (\exception\class\content\pageelement\PageElementException $exception)
					{
						throw new \exception\class\content\pageelement\PageElementException(
							message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['error_displayArray'],
							tokens: [
								'exception' => $exception->getMessage(),
							],
							previous: $exception,
						);
					}
				}
				else
				{
					$display .= (string) $element;
				}
			}
			return $display;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['displayArray']['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
		}
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
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['start'], ['key' => $key]);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'start'], [$this, $key]);

			try
			{
				if ($this->get('elements') === null)
				{
					$this->elements = [];

					throw new \exception\class\content\pageelement\PageElementException(
						message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['elements_null'],
						tokens:  [
							'key' => $key,
						],
					);
				}
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['error_get'],
					tokens:   [
						'key'       => $key,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
			if (!\key_exists($key, $this->get('elements')))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['unknown_key'],
					tokens:  [
						'key' => $key,
					],
				);
			}
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'end'], [$this, $key]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['success'], ['key' => $key]);
			return $this->elements[$key];
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
		   	\Throwable $exception
		)
		{
			try
			{
				$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'getElement', 'null'], [$this, $key]);
				throw new \exception\class\content\pageelement\PageElementException(
					message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['error'],
					tokens:       [
						'exception' => $exception->getMessage(),
						'key'       => $key,
						'class'     => \get_class($this),
					],
					notification: new \user\Notification([
						'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['getElement']['error'],
						'type'    => \user\NotificationTypes::ERROR,
					]),
					previous:     $exception,
				);
			}
			catch (\exception\class\content\pageelement\PageElementException $exception)
			{
				return null;
			}
		}
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
	 * @return null|mixed old value
	 */
	public function setElement(string|int $key, mixed $value, bool $strict = True) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['start'], ['key' => $key, 'value' => $value, 'strict' => $strict]);
			$GLOBALS['Hook']::load(['class', 'content', 'pageelement', 'PageElement', 'setElement', 'start'], [$this, $key, $value, $strict]);

			try
			{
				$element = $this->getElement($key);
			}
			catch (\exception\class\content\pageelement\PageElementException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['error_getElement'],
					tokens:   [
						'key'       => $key,
						'value'     => $value,
						'strict'    => $strict,
						'exception' => $exception->getMessage(),
						'class'     => \get_class($this),
					],
					previous: $exception,
				);
			}
			if ($element !== null)
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
					return null;
				}
				else
				{
					throw new \exception\class\content\pageelement\PageElementException(
						message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['error_strict'],
						tokens: [
							'key'       => $key,
							'value'     => $value,
							'exception' => $exception->getMessage(),
							'class'     => \get_class($this),
						],
					);
				}
			}
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'key'       => $key,
					'value'     => $value,
					'strict'    => $strict,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['setElement']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
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
		try
		{
			if ($this->elements !== null)
			{
				return False;
			}

			$this->elements = $elements;
			return True;
		}
		catch (
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElements']['error'],
				tokens: [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['setElements']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous: $exception,
			);
		}
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
		try
		{
			if ($this->template !== null)
			{
				return False;
			}

			$this->template = $template;
			return True;
		}
		catch (
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message: $GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setTemplate']['error'],
				tokens: [
					'class'     => \get_class($this),
					'template'  => $template,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['content']['pageelement']['PageElement']['setTemplate']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous: $exception,
			);
		}
	}
}

?>
