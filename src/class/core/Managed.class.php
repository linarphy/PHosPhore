<?php

namespace core;

/**
 * Object managed in the database
 */
abstract class Managed
{
	use \core\Base;

	/**
	 * Unique index
	 *
	 * @var array
	 */
	const INDEX = [];
	/**
	 * Insert the object in the database
	 *
	 * @return array
	 */
	public function add() : array
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['start'], ['class' => \get_class($this)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'add', 'start'], $this);

			try
			{
				$index = $this->manager()->add($this->table())[0];
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['add']['manager_error'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			if ($index === False || \phosphore_count($index) === 0)
			{
				throw new \exception\class\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['add']['unknown_error'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			foreach ($index as $name => $value)
			{
				$this->set($name, $value);
			}
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'add', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['success'], ['class' => \get_class($this)]);
			return $index;
		}
		catch (
			\exception\class\core\BaseException |
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\coore\ManagedException(
				message:     $GLOBALS['lang']['class']['core']['Managed']['add']['error'],
				tokens:      [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['add']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:    $exception,
			);
		}
	}
	/**
	 * Display a given array into a readable and safe form
	 *
	 * @param array $list Array to display
	 *
	 * @return string
	 */
	public static function arrDisp(array $list) : string
	{
		try
		{
			$display = '';
			if (\count($list) === 0)
			{
				return $display;
			}
			foreach ($list as $element)
			{
				if (\is_string($element))
				{
					$display .= \htmlspecialchars($element);
				}
				else if (\is_bool($element))
				{
					$display .= ($element ? 'True' : 'False');
				}
				else if (\is_int($element) || \is_float($element))
				{
					$display .= (string) $element;
				}
				else if (\is_null($element))
				{
					$display .= '';
				}
				else if (\is_resource($element))
				{
					$display .= \get_resource_type($element);
				}
				else if (is_array($element))
				{
					$display .= '(' . self::arrDisp($element) . ')';
				}
				else if (\is_object($element))
				{
					if (\method_exists($element, 'display'))
					{
						try
						{
							$display .= $element->display();
						}
						catch (
							\exception\class\core\BaseException |
							\exception\class\core\ManagedException
						)
						{
							$display .= \get_class($element);
						}
					}
					if (\method_exists($element, 'table'))
					{
						try
						{
							$display .= self::arrDisp($element->table());
						}
						catch (
							\exception\class\core\BaseException |
							\exception\class\core\ManagedException $exception
						)
						{
							$display .= \get_class($element);
						}
					}
					else
					{
						try
						{
							$display .= \phosphore_display($element);
						}
						catch (\Throwable $exception)
						{
							try
							{
								throw new \exception\class\core\ManagedException(
									message:  $GLOBALS['lang']['class']['core']['Managed']['arrDisp']['object_error'],
									tokens:   [
										'element'   => \get_class($element),
										'exception' => $exception->getMessage(),
									],
									previous: $exception,
								);
							}
							catch (\exception\class\core\ManagedException $exception)
							{
								$display .= \get_class($element);
							}
						}
					}
				}
				else if (\is_callable($element))
				{
					if ($element instanceOf \Closure)
					{
						$display .= 'closure';
					}
					$display .= 'unknown';
				}
				else if (\is_iterable($element))
				{
					$display .= 'iterable';
				}
				else
				{
					$display .= 'unknown type';
				}
				$display .= ',';
			}
			return $display;
		}
		catch (
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message: $GLOBALS['lang']['class']['core']['Managed']['arrDisp']['error'],
				tokens: [
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['arrDisp']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous: $exception,
			);
		}
	}
	/**
	 * Delete the object in the database
	 *
	 * @return bool
	 */
	public function delete() : bool
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['start'], ['class' => \get_class($this)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'delete', 'start'], $this);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['delete']['not_exist'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$index = $this->getIndex();
			if ($index === False)
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['delete']['missing_index'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'delete', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['success'], ['class' => \get_class($this)]);

			try
			{
				return $this->manager()->delete($this->getIndex());
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['delete']['manager_error'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\ManagedException |
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:      $GLOBALS['lang']['class']['core']['Managed']['delete']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['delete']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Check if the associated data exist in the database
	 *
	 * @return bool
	 */
	public function exist() : bool
	{
		try
		{
			$index = $this->getIndex();
			if ($index === False)
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['exist']['missing_index'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'exist', 'end'], $this);
			try
			{
				return $this->manager()->exist($index);
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['exist']['manager_error'],
					tokens:   [
						'class' => \get_class($this),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\ManagedException |
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exceptio\class\core\ManagedException(
				message:      $GLOBALS['lang']['class']['core']['Managed']['exist']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['exist']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Get the index values of this object
	 *
	 * @return null|False
	 */
	public function getIndex() : ?array
	{
		try
		{
			$index = [];
			foreach ($this::INDEX as $attribute)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\ManagedException(
						message: $GLOBALS['lang']['class']['core']['Managed']['getIndex']['type_attribute'],
						tokens:  [
							'class' => \get_class($this),
							'type'  => \gettype($attribute),
						],
					);
				}
				try
				{
					$value = $this->get($attribute);
				}
				catch (
					\exception\class\core\ManagedException |
					\exception\class\core\BaseException $exception
				)
				{
					throw new \exception\class\core\ManagedException(
						message:  $GLOBALS['lang']['class']['core']['Managed']['getIndex']['get_error'],
						tokens:   [
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
				if ($value === null)
				{
					throw new \exception\class\core\ManagedException(
						message: $GLOBALS['lang']['class']['core']['Managed']['getIndex']['null_attribute'],
						tokens:  [
							'attribute' => $attribute,
						],
					);
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Managed']['getIndex'], ['attribute' => $attribute]);
				}
				$index[$attribute] = $value;
			}
			return $index;
		}
		catch (
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:      $GLOBALS['lang']['class']['core']['Managed']['getIndex']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['getIndex']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous: $exception,
			);
		}
	}
	/**
	 * Check if the two objects have same index value (are the same)
	 *
	 * @param object $object
	 *
	 * @return bool
	 */
	public function isIdentical(object $object) : bool
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['start'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'isIdentical', 'start'], [$this, $object]);

			if (\get_class($this) !== \get_class($this))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_class'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
				return False;
			}
			foreach ($this::INDEX as $attribute)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\ManagedException(
						message: $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['type_attribute'],
						tokens:  [
							'class' => \get_class($this),
							'type'  => \gettype($attribute),
						],
					);
				}
				if ($this->$attribute === null || $object->$attribute === null)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['missing_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($object), 'attribute' => $attribute]);
					return False;
				}
				try
				{
					if ($this->get($attribute) !== $object->get($attribute))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($object), 'attribute' => $attribute]);
						return False;
					}
				}
				catch (
					\exception\class\core\ManagedException |
					\exception\class\core\BaseException $exception
				)
				{
					throw new \exception\class\core\ManagedException(
						message:  $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['get_error'],
						tokens:   [
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'isIdentical', 'end'], [$this, $object]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['same'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
			return True;
		}
		catch (
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:      $GLOBALs['lang']['class']['core']['Managed']['isIdentical']['error'],
				tokens:       [
					'class_1'   => \get_class($this),
					'class_2'   => \get_class($object),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['isIdentical']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Create an instance of the associated manager
	 *
	 * @param \PDO $connection
	 *
	 * @return mixed
	 */
	public function manager(\PDO $connection = null) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['manager']['start'], ['class' => \get_class($this)]);

			$manager = \get_class($this) . 'Manager';
			if (!\class_exists($manager))
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['manager']['not_defined'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'manager', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['manager']['end'], ['class' => \get_class($this)]);
			try
			{
				return new $manager($connection);
			}
			catch (\exception\class\core\ManagerException)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['manager']['manager_error'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message: $GLOBALS['lang']['class']['core']['Managed']['manager']['error'],
				tokens: [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['manager']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Retrieve data from the database
	 *
	 * @return \core\Managed
	 */
	public function retrieve() : self
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['start'], ['class' => \get_class($this)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'retrieve', 'start'], $this);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['retrieve']['not_defined'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'retrieve', 'check'], $this);

			$index = [];
			foreach ($this::INDEX as $attribute)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\ManagedException(
						message: $GLOBALS['lang']['class']['core']['Managed']['retrieve']['type_attribute'],
						tokens:  [
							'class' => \get_class($this),
							'type'  => \gettype($attribute),
						],
					);
				}
				try
				{
					$index[$attribute] = $this->get($attribute);
				}
				catch (
					\exception\class\core\ManagedException |
					\exception\class\core\BaseException $exception
				)
				{
					throw new \exception\class\core\ManagedException(
						message:  $GLOBALS['lang']['class']['core']['Managed']['retrieve']['get_error'],
						tokens:   [
							'class'     => \get_class($this),
							'attribute' => $attribute,
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'retrieve', 'end'], $this);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['end'], ['class' => \get_class($this)]);

			$this->hydrate($this->manager()->get($index));

			return $this;
		}
		catch (
			\exception\class\core\ManagedException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:      $GLOBALS['lang']['class']['core']['Managed']['retrieve']['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['retrieve']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
	/**
	 * Update the database
	 *
	 * @return bool
	 */
	public function update() : bool
	{
		try
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['update']['start'], ['class' => \get_class($this)]);
			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'update', 'start'], $this);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $GLOBALS['lang']['class']['core']['Managed']['update']['not_exist'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			try
			{
				$index = $this->getIndex();
			}
			catch (\exception\class\core\ManagedException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['update']['missing_index'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			$GLOBALS['Hook']::load(['class', 'core', 'Managed', 'update', 'end'], $this);
			try
			{
				$this->manager()->update(\array_diff_key($this->table(), $this->getIndex()), $this->getIndex());
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $GLOBALS['lang']['class']['core']['Managed']['update']['manager_error'],
					tokens:   [
						'class'     => \get_class($this),
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}

			return True;
		}
		catch (
			\exception\class\core\ManagedException |
			\exception\class\core\BaseException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message: $GLOBALS['lang']['class']['core']['Managed']['update']['error'],
				tokens:  [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $GLOBALS['locale']['class']['core']['Managed']['update']['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
}

?>
