<?php

namespace core;

$LANG = $GLOBALS
        ['lang']
        ['class']
        ['core']
        ['Base'];

$LOCALE = $GLOBALS
          ['locale']
          ['class']
          ['core']
          ['Base';

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
				$LANG
				['__construct']
				['start'],
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
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
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
					'type'    => \user\NotificationTypes::ERROR,
				]),
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
				$LANG
				['clone']
				['start'],
				[
					'class' => $class,
				],
			);

			try
			{
				return new $class($this->table());
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $LANG
							  ['clone']
					          ['error_table'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\BaseException |
			\Thowable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
				              ['clone']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
					             ['clone']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
				$LANG
				['display']
				['start'],
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
					$LANG
					['display']
					['object'],
					[
						'class' => \get_class($this),
					],
				);

				try
				{
					return \htmlspecialchars(
						\phosphore_display($this->table())
					);
				}
				catch (\exception\class\core\BaseException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $LANG
								  ['display']
						          ['error_table'],
						tokens:   [
							'class'     => \get_class($this),
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
				catch (\Throwable $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $LANG
								  ['display']
						          ['error_display'],
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
					message:      $LANG
								  ['display']
					              ['undefined'],
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
					message:  $LANG
							  ['display']
					          ['error_getDisp'],
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
					$LANG
					['display']
					['exist'],
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
						message:  $LANG
								  ['display']
						          ['custom_method_error'],
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
								message:  $LANG
										  ['display']
								          ['error_display'],
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
					message:  $LANG
							  ['display']
					          ['get_attribute'],
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
				$LANG
				['display']
				['not_exist'],
				[
					'class' => \get_class($this),
					'attribute' => $attribute,
					'method' => $method,
				],
			);

			try
			{
				return \htmlspecialchars(
					\phosphore_display($this->get($attribute))
				);
			}
			catch (\Throwable $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $LANG
							  ['display']
					          ['error_display_attribute'],
					tokens:   [
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['display']
				              ['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
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
				$LANG
				['get']
				['start'],
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
					message: $LANG
							 ['get']
					         ['not_defined'],
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
					message:  $LANG
							  ['get']
					          ['error_getGet'],
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
					$LANG
					['get']
					['getter'],
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
						message: $LANG
								 ['get']
						         ['error_custom_method'],
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
				$LANG
				['get']
				['default'],
				[
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'method'    => $method,
				],
			);

			return $this->$attribute;
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['get']
				              ['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['get']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
					message:      $LANG
								  ['getDisp']
					              ['empty'],
					tokens:       [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
					notification: new \user\Notification([
						'content' => $LOCALE
									 ['getDisp']
						             ['empty'],
						'type'    => \user\NotificationTypes::ERROR,
					]),
				);
			}

			return 'display' . \ucfirst($attribute);
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['getDisp']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['getDisp']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
					message:      $LANG
								  ['getGet']
					              ['empty'],
					tokens:       [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
					notification: new \user\Notification([
						'content' => $LOCALE
									 ['getGet']
						             ['empty'],
						'type'    => \user\NotificationTypes::ERROR,
					]),
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
						$LANG
						['getGet']
						['special'],
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
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['getGet']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['getGet']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
					message:      $LANG
								  ['getSet']
					              ['empty'],
					tokens:       [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
					notification: new \user\Notification([
						'content' => $LOCALE
									 ['getSet']
						             ['empty'],
						'type'    => \user\NotificationTypes::ERROR,
					]),
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
				message:      $LANG
							  ['getSet']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['getSet']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
				$LANG
				['hydrate']
				['start'],
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
						message: $LANG
								 ['hydrate']
						         ['type_attribute'],
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
							message:  $LANG
									  ['hydrate']
							          ['error_set'],
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
				$LANG
				['hydrate']
				['end'],
				[
					'class' => \get_class($this),
					'count' => $count,
				],
			);

			return $count;
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['hydrate']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['hydrate']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
				$LANG
				['set']
				['start'],
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
					message: $LANG
							 ['set']
					         ['undefined'],
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
					message: $LANG
							 ['set']
					         ['error_getSet'],
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
					$LANG
					['set']
					['custom_method'],
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
						message:  $LANG
								  ['set']
						          ['error_custom_method'],
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
				$LANG
				['set']
				['default_method'],
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
				message:      $LANG
							  ['set']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['set']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
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
				$LANG
				['table']
				['start'],
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
					message:      $LANG
								  ['table']
					              ['undefined_depth'],
					tokens:       [
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
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $LANG
							  ['table']
				              ['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'depth'     => $depth,
					'strict'    => $strict,
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['table']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
}

?>
