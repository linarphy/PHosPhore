<?php

namespace content\pageelement;

$LANG = $GLOBALS
        ['lang']
        ['class']
        ['content']
        ['pageelement']
        ['PageElement'];

$LOCALE = $GLOBALS
          ['locale']
          ['class']
          ['content']
          ['pageelement']
          ['PageElement'];

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
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function __construct(array $attributes)
	{
		try
		{
			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'__construct',
					'start',
				],
				$this,
			);

			try
			{
				$this->hydrate($attributes);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $LANG
							  ['__construct']
							  ['error_hydrate'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'__construct',
					'end',
				],
				$this,
			);
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['__construct']
							  ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['__construct']
								 ['error'],
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
	 * @return \content\pageelement\PageElement This PageElement
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function addElement(string|int $key, mixed $value) : \content\pageelement\PageElement
	{
		try
		{
			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['addElement']
				['start'],
				[
					'key' => $key,
					'value' => $value,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addElement',
					'start',
				],
				[
					$this,
					$key,
					$value,
				],
			);

			if (\key_exists($key, $this->get('elements')))
			{
				throw new \exception\class\content\pagelement\PageElementException(
					message: $LANG
							 ['addElement']
							 ['identical_key'],
					tokens:  [
						'key'   => $key,
						'value' => $value,
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addElement',
					'new',
				],
				[
					$this,
					$key,
					$value,
				],
			);

			$this->elements[$key] = $value;

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addElement',
					'end',
				],
				[
					$this,
					$key,
					$value,
				],
			);

			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['addElement']
				['success'],
				[
					'key' => $key,
					'value' => $value,
				],
			);

			return $this;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['addElement']
							  ['error'],
				tokens:       [
					'key'       => $key,
					'value'     => $value,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['addElement']
								 ['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
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
	 * @return \content\pageelement\PageElement This PageElement
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function addValueElement(string|int $key, mixed $value, string|int $new_key) : \content\pageelement\PageElement
	{
		try
		{
			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['addValueElement']
				['start'],
				[
					'key' => $key,
					'value' => $value,
					'new_key' => $new_key,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addValueElement',
					'start',
				],
				[
					$this,
					$key,
					$value,
					$new_key,
				],
			);

			try
			{
				$elements = $this->get('elements');
			}
			catch (\exception\CustomException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $LANG
							  ['addValueElement']
							  ['error_get'],
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
			if (!\key_exists($key, $elements))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $LANG
							 ['addValueElement']
							 ['unknown_key'],
					tokens:  [
						'key'     => $key,
						'new_key' => $new_key,
					],
				);
			}
			if (!\is_array($elements[$key]))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $LANG
							 ['addValueElement']
							 ['not_array'],
					tokens:  [
						'key'     => $key,
						'new_key' => $new_key,
					],
				);
			}
			if (\key_exists($new_key, $this->get('elements')[$key]))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $LANG
							 ['addValueElement']
							 ['already_taken'],
					tokens:  [
						'key'     => $key,
						'new_key' => $new_key,
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addValueElement',
					'new',
				],
				[
					$this,
					$key,
					$value,
					$new_key,
				],
			);

			$this->elements[$key][$new_key] = $value;

			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['addValueElement']
				['success'],
				[
					'key' => $key,
					'new_key' => $new_key,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'addValueElement',
					'end',
				],
				[
					$this,
					$key,
					$value,
					$new_key,
				],
			);

			return $this;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['addValueElement']
							  ['error'],
				tokens:       [
					'key'       => $key,
					'new_key'   => $new_key,
					'value'     => $value,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['addValueElement']
								 ['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Display the object in a readable and safe form
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return ?string
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function display(?string $attribute = null) : ?string
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
						message:  $LANG
						          ['display']
								  ['error_display'],
						tokens:   [
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}
			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['display']
				['start'],
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'display',
					'start',
				],
				$this,
			);

			if (
				!isset(
					$GLOBALS
					['cache']
					['class']
					['content']
					['pageelement']
					['PageElement']
					['templates']
				)
			)
			{
				$GLOBALS
				['cache']
				['class']
				['content']
				['pageelement']
				['PageElement']
				['templates'] = [];
			}

			try
			{
				$template = $this->get('template');
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $LANG
							  ['display']
							  ['error_get'],
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			if ($template !== null)
			{
				$GLOBALS['Hook']::load(
					[
						'class',
						'content',
						'pageelement',
						'PageElement',
						'display',
						'template',
					],
					$this,
				);

				if (
					\key_exists(
						$template,
						$GLOBALS
						['cache']
						['class']
						['content']
						['pageelement']
						['PageElement']
						['templates'],
					)
				)
				{
					$GLOBALS['Logger']->log(
						\core\LoggerTypes::DEBUG,
						$LANG
						['display']
						['use_cache'],
						[
							'template' => $template,
						],
					);

					$GLOBALS['Hook']::load(
						[
							'class',
							'content',
							'pageelement',
							'PageElement',
							'display',
							'cache',
						],
						$this,
					);

					$content = $GLOBALS
					['cache']
					['class']
					['content']
					['pageelement']
					['PageElement']
					['templates']
					[$template];
				}
				else
				{
					$GLOBALS['Hook']::load(
						[
							'class',
							'content',
							'pageelement',
							'PageElement',
							'display',
							'no_cache',
						],
						$this,
					);

					$content = \file_get_contents(
						$GLOBALS
						['config']['core']['path']['template'] .
						$this->template, true
					);

					if ($content === False)
					{
						throw new \exception\class\content\pageelement\PageElementException(
							message:      $LANG
										  ['display']
										  ['no_file_template'],
							tokens:       [
								'template' => $this->template,
							],
							logger_types: [
								\core\LoggerTypes::ERROR,
								'class',
								'core',
							],
						);
					}

					$GLOBALS
					['cache']
					['class']
					['content']
					['pageelement']
					['PageElement']
					['templates']
					[$this->template] = $content;
				}
			}
			else
			{
				$GLOBALS['Hook']::load(
					[
						'class',
						'content',
						'pageelement',
						'PageElement',
						'display',
						'no_template'
					],
					$this,
				);

				$GLOBALS['Logger']->log(
					\core\LoggerTypes::DEBUG,
					$LANG
					['display']
					['no_template'],
				);

				$content = ''; // we want to display every element
							   // of elements
			}

			if ($this->elements !== null)
			{
				$GLOBALS['Logger']->log(
					\core\LoggerTypes::DEBUG, 
					$LANG
					['display']
					['elements'],
				);

				$GLOBALS['Hook']::load(
					[
						'class',
						'content',
						'pageelement',
						'PageElement',
						'display',
						'elements',
					],
					$this,
				);

				if ($content !== '')
				{
					$GLOBALS['Logger']->log(
						\core\LoggerTypes::DEBUG,
						$LANG
						['display']
						['content'],
					);

					$tokens = \preg_split(
						'/({(?:\\}|[^\\}])+})/Um',
						$content,
						-1,
						PREG_SPLIT_DELIM_CAPTURE,
					);

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
										message: $LANG
												 ['display']
												 ['error_element_display'],
										tokens: [
											'element_class' => \get_class($element),
											'exception'    => $exception,
										],
										previous: $exception,
									);
								}
							}
							else
							{
								throw new \exception\class\content\pageelement\PageElementException(
									message: $LANG
									         ['display']
									         ['cannot_display_object'],
									tokens:  [
										'class' => \get_class($elements),
									],
								);
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
									message:  $LANG
											  ['display']
											  ['error_displayArray'],
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
					$GLOBALS['Logger']->log(
						\core\LoggerTypes::DEBUG,
						$LANG
						['display']
						['no_content'],
					);

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
									\exception\CustomException $exception
								)
								{
									throw new exception\class\content\pageelement\PageElementException(
										message: $LANG
												 ['display']
												 ['error_element_display'],
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
								throw new \exception\class\content\pageelement\PageElementException(
									message: $LANG
									         ['display']
									         ['cannot_display_object'],
									tokens:  [
										'object' => \get_class($elements),
									],
								);
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
									message:  $LANG
											  ['display']
											  ['error_displayArray'],
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

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'display',
					'end'
				],
				$this,
			);

			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['display']
				['end'],
				[
					'class' => \get_class($this),
				],
			);

			return $content;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['display']
							  ['error'],
				tokens:       [
					'attribute' => $attribute,
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				logger_types: [
					\core\LoggerTypes::ERROR,
					'class',
					'core',
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['display']
								 ['error'],
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
	 * @return ?string
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function displayArray(array $list) : ?string
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
								message:  $LANG
										  ['displayArray']
										  ['error_display'],
								tokens:   [
									'exception'     => $exception->getMessage(),
									'element_class' => \get_class($this),
								],
								previous: $exception,
							);
						}
					}
					else
					{
						throw new \exception\class\content\pageelement\PageElementException(
							message: $LANG
									 ['displayArray']
									 ['cannot_display_object'],
							tokens:  [
								'class' => \get_class($element),
							],
						);
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
							message:  $LANG
									  ['displayArray']
									  ['error_displayArray'],
							tokens:   [
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
				message:      $LANG
							  ['displayArray']
							  ['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['displayArray']
								 ['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Accessor of an element of elements
	 *
	 * @param string|int $key Key corresponding to the element
	 *
	 * @return mixed
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function getElement(string|int $key) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['getElement']
				['start'],
				[
					'key' => $key,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'getElement',
					'start',
				],
				[
					$this,
					$key,
				],
			);

			try
			{
				$elements = $this->get('elements');
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message:  $LANG
							  ['getElement']
							  ['error_get'],
					tokens:   [
						'key'       => $key,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
			if (!\key_exists($key, $elements))
			{
				throw new \exception\class\content\pageelement\PageElementException(
					message: $LANG
							 ['getElement']
							 ['unknown_key'],
					tokens:  [
						'key' => $key,
					],
				);
			}
			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'getElement',
					'end',
				],
				[
					$this,
					$key,
				],
			);

			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['getElement']
				['success'],
				[
					'key' => $key,
				],
			);

			return $this->elements[$key];
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
		   	\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['getElement']
							  ['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'key'       => $key,
					'class'     => \get_class($this),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['getElement']
								 ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Setter of an element of elements
	 *
	 * @param string|int $key Key corresponding to the element
	 *
	 * @param mixed $value New value of the element
	 *
	 * @param bool $strict If strict is true, the value will not be set
	 *                     if the element did not exist before
	 *
	 * @return mixed Old value or null if the element did not exist
	 *               before
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
	 */
	public function setElement(string|int $key, mixed $value, bool $strict = True) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['setElement']
				['start'],
				[
					'key' => $key,
					'value' => $value,
					'strict' => $strict,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'content',
					'pageelement',
					'PageElement',
					'setElement',
					'start',
				],
				[
					$this,
					$key,
					$value,
					$strict,
				],
			);

			try
			{
				$element = $this->getElement($key);
			}
			catch (\exception\class\content\pageelement\PageElementException $exception)
			{
				if ($strict === False)
				{
					$GLOBALS['Logger']->log(
						\core\LoggerTypes::DEBUG,
						$LANG
						['setElement']
						['add'],
						[
							'key' => $key,
							'value' => $value,
						],
					);

					$this->elements[$key] = $value;

					return null;
				}
				else
				{
					throw new \exception\class\content\pageelement\PageElementException(
						message: $LANG
						         ['setElement']
								 ['error_strict'],
						tokens:  [
							'key'       => $key,
							'value'     => $value,
							'exception' => $exception->getMessage(),
							'class'     => \get_class($this),
						],
					);
				}
			}

			$old_value = $this->elements[$key];
			$this->elements[$key] = $value;

			$GLOBALS['Logger']->log(
				\core\LoggerTypes::DEBUG,
				$LANG
				['setElement']
				['change'],
				[
					'key' => $key,
					'value' => $value,
				],
			);

			return $old_value;
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\PageElementException(
				message:      $LANG
							  ['setElement']
							  ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'key'       => $key,
					'value'     => $value,
					'strict'    => $strict,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['setElement']
								 ['error'],
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
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
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
				message: $LANG
						 ['setElements']
						 ['error'],
				tokens: [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['setElements']
								 ['error'],
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
	 *
	 * @throws \exception\class\content\pageelement\PageElementException
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
				message: $LANG
						 ['setTemplate']
						 ['error'],
				tokens: [
					'class'     => \get_class($this),
					'template'  => $template,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['setTemplate']
								 ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous: $exception,
			);
		}
	}
}

?>
