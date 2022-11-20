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
	 */
	public function __construct(array $attributes = [])
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['__construct']['start'], ['class' => \get_class($this)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Base', '__construct', 'start'], [$this, $attributes]);

			try
			{
				$this->hydrate($attributes);
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $GLOBALS['lang']['class']['core']['Base']['__construct']['error_hydrate'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Base', '__construct', 'end'], [$this, $attributes]);
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $GLOBALS['lang']['class']['core']['Base']['__construct']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['__construct']['error'],
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
	 */
	public function clone() : self
	{
		try
		{
			$class = \get_class($this);
			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'clone', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['clone']['start'], ['class' => $class]);
			try
			{
				return new $class($this->table());
			}
			catch (\exception\class\core\BaseException $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $GLOBALS['lang']['class']['core']['Base']['clone']['error_table'],
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
				message:      $GLOBALS['lang']['class']['core']['Base']['clone']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['clone']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Convert this object or one of its attribute into a safe and readable form
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
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);

			if ($attribute === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['object'], ['class' => \get_class($this)]);
				try
				{
					return \htmlspecialchars(\phosphore_display($this->table()));
				}
				catch (\exception\class\core\BaseException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $GLOBALS['lang']['class']['core']['Base']['display']['error_table'],
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
						message:  $GLOBALS['lang']['class']['core']['Base']['display']['error_display'],
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
					message:      $GLOBALS['lang']['class']['Base']['display']['undefined'],
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
					message:  $GLOBALS['lang']['class']['core']['Base']['display']['error_getDisp'],
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
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['exist'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
				try
				{
					return $this->$method($attribute);
				}
				catch (\exception\BaseException $exception)
				{
					throw new \exception\class\core\BaseException(
						message:  $GLOBALS['lang']['class']['core']['Base']['display']['custom_method_error'],
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
					if (\method_exists($this->get($attribute), 'display'))
					{
						try
						{
							return $this->get($attribute)->display();
						}
						catch (\exception\class\core\BaseException $exception)
						{
							throw new \exception\class\core\BaseException(
								message:  $GLOBALS['lang']['class']['core']['Base']['display']['error_display'],
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
					message:  $GLOBALS['lang']['class']['core']['Base']['display']['get_attribute'],
					tokens:   [
						'class'     => \get_class($this),
						'attribute' => $attribute,
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['not_exist'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
			try
			{
				return \htmlspecialchars(\phosphore_display($this->get($attribute)));
			}
			catch (\Throwable $exception)
			{
				throw new \exception\class\core\BaseException(
					message:  $GLOBALS['lang']['class']['core']['Base']['display']['error_display_attribute'],
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
				message:      $GLOBALS['lang']['class']['core']['Base']['display']['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['display']['error'],
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
	 */
	public function get(string $attribute) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);
			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'start'], [$this, $attribute]);

			if (!\property_exists($this, $attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $GLOBALS['lang']['class']['core']['Base']['get']['not_defined'],
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
					message:  $GLOBALS['lang']['class']['core']['Base']['get']['error_getGet'],
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
				$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'end'], [$this, $attribute]);
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['getter'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
				try
				{
					return $this->$method();
				}
				catch (\exception\CustomException $exception)
				{
					throw new \exception\class\core\BaseException(
						message: $GLOBALS['lang']['class']['core']['Base']['get']['error_custom_method'],
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

			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'end'], [$this, $attribute]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['default'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
			return $this->$attribute;
		}
		catch (
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\BaseException(
				message:      $GLOBALS['lang']['class']['core']['Base']['get']['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['get']['error'],
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
	 */
	public static function getDisp(string $attribute) : string
	{
		try
		{
			if (empty($attribute))
			{
				throw new \exception\class\core\BaseException(
					message:      $GLOBALS['lang']['class']['core']['Base']['getDisp']['empty'],
					tokens:       [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
					notification: new \user\Notification([
						'content' => $GLOBALS['locale']['class']['core']['Base']['getDisp']['empty'],
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
				message:      $GLOBALS['lang']['class']['core']['Base']['getDisp']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['getDisp']['error'],
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
	 */
	public static function getGet(string $attribute) : string
	{
		if (empty($attribute))
		{
			throw new \exception\class\core\BaseException(
				message:      $GLOBALS['lang']['class']['core']['Base']['getGet']['empty'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['getGet']['empty'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
			);
		}

		switch (\ucfirst($attribute)) // special case where the getter method name is already taken
		{
			case 'Get':
			case 'Set':
			case 'Disp':
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Base']['getGet']['special'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => 'get_' . \ucfirst($attribute)]);
				return 'get_' . \ucfirst($attribute);
		}

		return 'get' . \ucfirst($attribute);
	}
	/**
	 * Get the name of the setter method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getSet(string $attribute) : string
	{
		if (empty($attribute))
		{
			throw new \exception\class\core\BaseException(
				message:      $GLOBALS['lang']['class']['core']['Base']['getSet']['empty'],
				tokens:       [
					'class'     => \get_class($this),
					'attribute' => $attribute,
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['getSet']['empty'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
			);
		}

		return 'set' . \ucfirst($attribute);
	}
	/**
	 * Hydrate object with array
	 *
	 * @param array $attributes Array having $attribute => $value
	 *
	 * @return int Number of attributes set
	 */
	public function hydrate(array $attributes) : int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['hydrate']['start'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'hydrate', 'start'], [$this, $attributes]);

		$count = 0;
		foreach ($attributes as $attribute => $value)
		{
			if (\property_exists($this, $attribute))
			{
				if ($this->set($attribute, $value))
				{
					$count += 1;
				}
			}
		}

		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'hydrate', 'end'], [$this, $attributes]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['hydrate']['end'], ['class' => \get_class($this), 'count' => $count]);
		return $count;
	}
	/**
	 * Set the value of an attribute
	 *
	 * @param string $attribute
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function set(string $attribute, mixed $value) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'start'], [$this, $attribute, $value]);

		try
		{
			if (!\property_exists($this, $attribute))
			{
				throw new \exception\class\core\BaseException(
					message: $GLOBALS['lang']['class']['core']['Base']['set']['undefined'],
					tokens:  [
						'class'     => \get_class($this),
						'attribute' => $attribute,
					],
				);
			}

			$method = $this::getSet($attribute);
			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'check'], $this);

			if (\method_exists($this, $method))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['custom_method'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
				return $this->$method($value);
			}

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['default_method'], ['class' => \get_class($this), 'attribute' => $attribute]);
			$this->$attribute = $value;
			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'end'], $this);
			return True;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			return False;
		}
	}
	/**
	 * Convert an object to an array
	 *
	 * @param int $depth Depth of the recursion if there is an object, -1 for infinite, 0 for no recursion.
	 *                   Default to 0.
	 *
	 * @param bool $strict If True, null value will be displayed, but it can throw fatal error if every properties are not initialized.
	 *                     Default to False;
	 *
	 * @return array
	 */
	public function table(int $depth = 0, bool $strict = False) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['table']['start'], ['class' => \get_class($this), 'depth' => $depth]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'start'], [$this, $depth]);

		$attributes = [];

		try
		{
			if ($depth < -1)
			{
				throw new \exception\class\core\BaseException(
					message:      $GLOBALS['lang']['class']['core']['Base']['table']['undefined_depth'],
					tokens:       [
						'class' => \get_class($this),
						'depth' => $depth,
					],
				);
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'check'], [$this, $depth]);

			foreach (\array_keys(\get_class_vars(\get_class($this))) as $attribute)
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
							$attributes[$attribute] = \phosphore_table($this->$attribute, $depth - 1);
						}
						else // depth === -1
						{
							$attributes[$attribute] = \phosphore_table($this->$attribute, $depth);
						}
					}
					else
					{
						$attributes[$attribute] = $this->$attribute;
					}
				}
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'end'], [$this, $depth]);
			return $attributes;
		}
		catch (\exception\class\core\BaseException $exception)
		{
			throw new \exception\class\core\BaseException(
				message:      $GLOBALS['lang']['class']['core']['Base']['table']['error'],
				tokens:       [
					'exception' => $exception->getMessage(),
					'class'     => \get_class($this),
					'depth'     => $depth,
					'strict'    => $strict,
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Base']['table']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
			);
		}
	}
}

?>
