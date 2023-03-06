<?php

namespace core;

/**
 * core basic methods
 */
trait Base
{
	/**
	 * Constructor
	 *
	 * @param array $attributes Defined values of the object attributes.
	 *                          Default to empty array.
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function __construct(array $attributes = [])
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang('__construct', 'start', 'core\\Base'),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'__construct',
					'start',
				],
				[
					$this,
					$attributes,
				],
			);

			try
			{
				$this->hydrate($attributes);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $this->lang(
						'__construct',
						'error_hydrate',
						'core\\Base',
					),
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
					'core',
					'Base',
					'__construct',
					'end',
				],
				[
					$this,
					$attributes,
				],
			);
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:      $this->lang(
					'__construct',
					'error',
					'core\\Base',
				),
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				previous:     $exception,
			);
		}
	}
	/**
	 * Clone the object (return a new one with the same attributes)
	 *
	 * @return self
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function clone() : self
	{
		try
		{
			$class = \get_class($this);
			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'clone',
					'end',
				],
				$this,
			);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'clone',
					'start',
					'core\\Base',
				),
				[
					'class' => $class,
				],
			);

			return new $class($this->table());
		}
		catch (\exception\class\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:      $this->lang(
					'clone',
					'error',
					'core\\Base',
				),
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				previous:     $exception,
			);
		}
	}
	/**
	* Get the config value
 	*
	* @param string method Method where the method is called
	*
	* @param string name Name associated to the value
	*
	* @param ?string class Class name.
	*                      If null, use \get_class().
	*                      Default to null.
	*
	* @return mixed
	*
	* @throws \exception\class\core\BaseException
	*/
	public function config(string $method, string $name, ?string $class = null)
	{
		try
		{
			if ($class === null)
			{
				$class = \get_class($this);
			}

			$result = \phosphore_config($class);

			if (!\array_key_exists($method, $result))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'config',
						'method',
						'core\\Base',
					),
					tokens: [
						'method' => $method,
					],
				);
			}

			$result = $result[$method];

			if (!\array_key_exists($name, $result))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'config',
						'name',
						'core\\Base',
					),
					tokens: [
						'name' => $name,
					],
				);
			}

			return $result[$name];
		}
		catch (
			\exception\class\core\BaseException |
			\ValueError $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang('config', 'error', 'core\\Base'),
				tokens:   [
					'exception' => $exception,
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Convert this object or one of its attribute into a safe and
	 * readable form
	 *
	 * @param ?string $attribute Attribute to display (entire object
	 *                           if null).
	 *                           Default to null.
	 *
	 * @return string
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function display(?string $attribute = null) : string
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'display',
					'start',
					'core\\Base',
				),
				[
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
			);

			if ($attribute === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$this->lang(
						'display',
						'object',
						'core\\Base',
					),
					[
						'class' => \get_class($this),
					],
				);

				try
				{
					return \htmlspecialchars(
						\phosphore_display($this)
					);
				}
				catch (\exception\class\core\BaseException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $this->lang(
							'display',
							'error_display',
							'core\\Base',
						),
						tokens:   [
							'class'     => \get_class($this),
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			if (!\property_exists($this, $attribute))
			{
				throw new \exception\class\core\BaseException(
					message:      $this->lang(
						'display',
						'undefined',
						'core\\Base',
					),
					tokens:       [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			try
			{
				$method = $this::getDisp($attribute);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $this->lang(
						'display',
						'error_getDisp',
						'core\\Base',
					),
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
						'attribute' => $attribute,
					],
					previous: $exception,
				);
			}

			if (\method_exists($this, $method))
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$this->lang(
						'display',
						'exist',
						'core\\Base',
					),
					[
						'class' => \get_class($this),
						'attribute' => $attribute,
						'method' => $method,
					],
				);

				try
				{
					return $this->$method($attribute);
				}
				catch (\exception\BaseException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $this->lang(
							'display',
							'custom_method_error',
							'core\\Base',
						),
						tokens:   [
							'method'    => $method,
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			try
			{
				if (\is_object($this->get($attribute)))
				{
					if (\method_exists(
						$this->get($attribute),
						'display',
					))
					{
						try
						{
							return $this->get($attribute)->display();
						}
						catch (
							\exception\class\core\BaseException $exception
						)
						{
							throw new \exception\class\core\BaseException(
								message:  $this->lang(
									'display',
									'error_display',
									'core\\Base',
								),
								tokens:   [
									'class'     => \get_class($this),
									'exception' => $exception->getMessage(),
								],
								previous: $exception
							);
						}
					}
				}
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $this->lang(
						'display',
						'get_attribute',
						'core\\Base',
					),
					tokens:   [
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'display',
					'not_exist',
					'core\\Base',
				),
				[
					'class' => \get_class($this),
					'attribute' => $attribute,
					'method' => $method,
				],
			);

			return \htmlspecialchars(
				\phosphore_display($this->get($attribute))
			);
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:      $this->lang(
					'display',
					'error',
					'core\\Base',
				),
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				previous:     $exception,
			);
		}
	}
	/**
	 * Get the value of the given attribute
	 *
	 * @param string $attribute
	 *
	 * @return mixed
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function get(string $attribute) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'get',
					'start',
					'core\\Base',
				),
				[
					'class' => \get_class($this),
					'attribute' => $attribute,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'get',
					'start',
				],
				[
					$this,
					$attribute,
				],
			);

			if (!\property_exists($this, $attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'get',
						'not_defined',
						'core\\Base',
					),
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			try
			{
				$method = $this::getGet($attribute);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $this->lang(
						'get',
						'error_getGet',
						'core\\Base',
					),
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
						'attribute' => $attribute,
					],
					previous: $exception,
				);
			}

			if (\method_exists($this, $method))
			{
				$GLOBALS['Hook']::load(
					[
						'class',
						'core',
						'Base',
						'get',
						'end',
					],
					[
						$this,
						$attribute,
					],
				);

				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$this->lang(
						'get',
						'getter',
						'core\\Base',
					),
					[
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'method'    => $method,
					],
				);

				try
				{
					return $this->$method();
				}
				catch (\exception\CustomException $exception)
				{
					throw new \exception\class\core\BaseException(
						message: $this->lang(
							'get',
							'error_custom_method',
							'core\\Base',
						),
						tokens: [
							'method'    => $method,
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			if (!isset($this->$attribute))
			{
				return null;
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'get',
					'end',
				],
				[
					$this,
					$attribute,
				],
			);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'get',
					'default',
					'core\\Base',
				),
				[
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'method'    => $method,
				],
			);

			return $this->$attribute;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'get',
					'error',
					'core\\Base',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Get the name of the displayer method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public static function getDisp(string $attribute) : string
	{
		try
		{
			if (empty($attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'getDisp',
						'empty',
						'core\\Base',
					),
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			return 'display' . \ucfirst($attribute);
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'getDisp',
					'error',
					'core\\Base',
				),
				tokens:   [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Get the name of the getter method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public static function getGet(string $attribute) : string
	{
		try
		{
			if (empty($attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'getGet',
						'empty',
						'core\\Base',
					),
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			switch (\ucfirst($attribute)) // special case where the
										  // getter method name is
										  // already taken
			{
				case 'Get':
				case 'Set':
				case 'Disp':
					$GLOBALS['Logger']->log(
						[
							'class',
							'core',
							\core\Logger::TYPES['info'],
						],
						$this->lang(
							'getGet',
							'special',
							'core\\Base',
						),
						[
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'method'    => 'get_' . \ucfirst($attribute),
						],
					);

					return 'get_' . \ucfirst($attribute);
			}

			return 'get' . \ucfirst($attribute);
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'getGet',
					'error',
					'core\\Base',
				),
				tokens:   [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Get the name of the setter method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public static function getSet(string $attribute) : string
	{
		try
		{
			if (empty($attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'getSet',
						'empty',
						'core\\Base',
					),
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			return 'set' . \ucfirst($attribute);
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'getSet',
					'error',
					'core\\Base',
				),
				tokens:   [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Hydrate object with array
	 *
	 * @param array $attributes Array having $attribute => $value
	 *
	 * @return int Number of attributes set
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function hydrate(array $attributes) : int
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'hydrate',
					'start',
					'core\\Base',
				),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'hydrate',
					'start',
				],
				[
					$this,
					$attributes,
				],
			);

			$count = 0;
			foreach ($attributes as $attribute => $value)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\BaseException(
						message: $this->lang(
							'hydrate',
							'type_attribute',
							'core\\Base',
						),
						tokens:  [
							'class' => \get_class($this),
							'type'  => \gettype($attribute),
						],
					);
				}
				if (\property_exists($this, $attribute))
				{
					try
					{
						if ($this->set($attribute, $value))
						{
							$count += 1;
						}
					}
					catch (\exception\class\core\BaseException $exception)
					{
						throw new \exception\class\core\BaseException(
							message:  $this->lang(
								'hydrate',
								'error_set',
								'core\\Base',
							),
							tokens:   [
								'class'     => \get_class($this),
								'attribute' => $attribute,
								'exception' => $exception->getMessage(),
							],
							previous: $exception,
						);
					}
				}
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'hydrate',
					'end',
				],
				[
					$this,
					$attributes,
				],
			);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'hydrate',
					'end',
					'core\\Base',
				),
				[
					'class' => \get_class($this),
					'count' => $count,
				],
			);

			return $count;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'hydrate',
					'error',
					'core\\Base',
				),
				tokens:   [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	* Get the lang value
 	*
	* @param string method Method where the method is called
	*
	* @param string name Name associated to the value
	*
	* @param ?string class Class name.
	*                      If null, use \get_class().
	*                      Default to null.
	*
	* @return mixed
	*
	* @throws \exception\class\core\BaseException
	*/
	public function lang(string $method, string $name, ?string $class = null)
	{
		try
		{
			if ($class === null)
			{
				$class = \get_class($this);
			}

			$result = \phosphore_lang($class);

			if (!\array_key_exists($method, $result))
			{
				throw new \exception\class\core\BaseException(
					message: 'The language table has no key for ' .
					         'the method {method}',
					tokens: [
						'method' => $method,
					],
				);
			}

			$result = $result[$method];

			if (!\array_key_exists($name, $result))
			{
				throw new \exception\class\core\BaseException(
					message: 'The language table has no key for ' .
					         'the name {name}',
					tokens: [
						'name' => $name,
					],
				);
			}

			return $result[$name];
		}
		catch (
			\exception\class\core\BaseException |
			\ValueError $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:  'An error occured when accessing the language ' .
				          'value: {exception}',
				tokens:   [
					'exception' => $exception,
				],
				previous: $exception,
			);
		}
	}
	/**
	* Get the locale value
 	*
	* @param string method Method where the method is called
	*
	* @param string name Name associated to the value
	*
	* @param ?string class Class name.
	*                      If null, use \get_class().
	*                      Default to null.
	*
	* @return mixed
	*
	* @throws \exception\class\core\BaseException
	*/
	public function locale(string $method, string $name, ?string $class = null)
	{
		try
		{
			if ($class === null)
			{
				$class = \get_class($this);
			}

			$result = \phosphore_locale($class);

			if (!\array_key_exists($method, $result))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'locale',
						'method',
						'core\\Base',
					),
					tokens: [
						'method' => $method,
					],
				);
			}

			$result = $result[$method];

			if (!\array_key_exists($name, $result))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'locale',
						'name',
						'core\\Base',
					),
					tokens: [
						'name' => $name,
					],
				);
			}

			return $result[$name];
		}
		catch (
			\exception\class\core\BaseException |
			\ValueError $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'locale',
					'error',
					'core\\Base',
				),
				tokens:   [
					'exception' => $exception,
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Set the value of an attribute
	 *
	 * @param string $attribute
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function set(string $attribute, mixed $value) : bool
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'set',
					'start',
					'core\\Base',
				),
				[
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'set',
					'start',
				],
				[
					$this,
					$attribute,
					$value,
				],
			);

			if (!\property_exists($this, $attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'set',
						'undefined',
						'core\\Base',
					),
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			try
			{
				$method = $this::getSet($attribute);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'set',
						'error_getSet',
						'core\\Base',
					),
					tokens: [
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'set',
					'check',
				],
				$this,
			);

			if (\method_exists($this, $method))
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$this->lang(
						'set',
						'custom_method',
						'core\\Base',
					),
					[
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'method'    => $method,
					],
				);

				try
				{
					return $this->$method($value);
				}
				catch (\exception\CustomException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $this->lang(
							'set',
							'error_custom_method',
							'core\\Base',
						),
						tokens:   [
							'class'     => \get_class($this),
							'method'    => $method,
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'set',
					'default_method',
					'core\\Base',
				),
				[
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
			);

			$this->$attribute = $value;

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'set',
					'end',
				],
				$this,
			);

			return True;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'set',
					'error',
					'core\\Base',
				),
				tokens:   [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Convert an object to an array
	 *
	 * @param int $depth Depth of the recursion if there is an object,
	 *                    -1 for infinite, 0 for no recursion.
	 *                   Default to 0.
	 *
	 * @param bool $strict If True, null value will be displayed, but
	 *                     it can throw fatal error if every properties
	 *                     are not initialized.
	 *                     Default to False;
	 *
	 * @return array
	 *
	 * @throws \exception\class\core\BaseException
	 */
	public function table(int $depth = 0, bool $strict = False) : array
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'table',
					'start',
					'core\\Base',
				),
				[
					'class' => \get_class($this),
					'depth' => $depth,
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'table',
					'start',
				],
				[
					$this,
					$depth,
				],
			);

			$attributes = [];

			if ($depth < -1)
			{
				throw new \exception\class\core\BaseException(
					message: $this->lang(
						'table',
						'undefined_depth',
						'core\\Base',
					),
					tokens:  [
						'class' => \get_class($this),
						'depth' => $depth,
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'table',
					'check',
				],
				[
					$this,
					$depth,
				],
			);

			foreach (\array_keys(
				\get_class_vars(\get_class($this))
			) as $attribute)
			{
				if ($strict || isset($this->$attribute))
				{
					if (\is_object($this->$attribute))
					{
						if ($depth === 0)
						{
							$attributes[$attribute] = $this->$attribute;
						}
						else if ($depth > 0)
						{
							$attributes[$attribute] = \phosphore_table(
								$this->$attribute, $depth - 1
							);
						}
						else // depth === -1
						{
							$attributes[$attribute] = \phosphore_table(
								$this->$attribute, $depth
							);
						}
					}
					else
					{
						$attributes[$attribute] = $this->$attribute;
					}
				}
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Base',
					'table',
					'end',
				],
				[
					$this,
					$depth,
				],
			);

			return $attributes;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:  $this->lang(
					'table',
					'error',
					'core\\Base',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'depth'     => $depth,
					'strict'    => $strict,
				],
				previous: $exception,
			);
		}
	}
}

?>
