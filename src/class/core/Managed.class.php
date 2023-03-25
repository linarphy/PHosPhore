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
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function add() : array
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
					'add',
					'start',
					'core\\Managed'
				),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'add',
					'start',
				],
				$this,
			);

			try
			{
				$index = $this->manager()->add($this->table())[0];
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $this->lang(
						'add',
						'manager_error',
						'core\\Managed',
					),
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
					message: $this->lang(
						'add',
						'unknown_error',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			foreach ($index as $name => $value)
			{
				$this->set($name, $value);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'add',
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
					'add',
					'success',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			return $index;
		}
		catch (
			\exception\class\core\BaseException |
			\exception\class\core\ManagedException $exception
		)
		{
			throw new \exception\class\coore\ManagedException(
				message:  $this->lang(
					'add',
					'error',
					'core\\Managed',
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
	 * Display a given array into a readable and safe form
	 *
	 * @param array $list Array to display
	 *
	 * @return string
	 *
	 * @throws \exception\class\core\ManagedException
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
							\exception\class\core\ManagedException $exception
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
									message:  $this->lang(
										'arrDisp',
										'object_error',
										'core\\Managed',
									),
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
			\exception\class\core\ManagedException $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message: $this->lang(
					'arrDisp',
					'error',
					'core\\Managed',
				),
				tokens: [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Delete the object in the database
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function delete() : bool
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
					'delete',
					'start',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'delete',
					'start',
				],
				$this,
			);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'delete',
						'not_exist',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$index = $this->getIndex();
			if ($index === False)
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'delete',
						'missing_index',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'delete',
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
					'delete',
					'success',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			try
			{
				return $this->manager()->delete($this->getIndex());
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $this->lang(
						'delete',
						'manager_error',
						'core\\Managed',
					),
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
			\exception\class\core\BaseException $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:  $this->lang(
					'delete',
					'error',
					'core\\Managed',
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
	 * Check if the associated data exist in the database
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function exist() : bool
	{
		try
		{
			$index = $this->getIndex();
			if ($index === False)
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'exist',
						'missing_index',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'exist',
					'end',
				],
				$this,
			);

			try
			{
				return $this->manager()->exist($index);
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $this->lang(
						'exist',
						'manager_error',
						'core\\Managed',
					),
					tokens:   [
						'class' => \get_class($this),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\ManagedException |
			\exception\class\core\BaseException $exception
		)
		{
			throw new \exceptio\class\core\ManagedException(
				message:  $this->lang(
					'exist',
					'error',
					'core\\Managed',
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
	 * Get the index values of this object
	 *
	 * @return null|False
	 *
	 * @throws \exception\class\core\ManagedException
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
						message: $this->lang(
							'getIndex',
							'type_attribute',
							'core\\Managed',
						),
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
						message:  $this->lang(
							'getIndex',
							'get_error',
							'core\\Managed',
						),
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
						message: $this->lang(
							'getIndex',
							'null_attribute',
							'core\\Managed',
						),
						tokens:  [
							'attribute' => $attribute,
						],
					);
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
				message:  $this->lang(
					'getIndex',
					'error',
					'core\\Managed',
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
	 * Check if the two objects have same index value (are the same)
	 *
	 * @param object $object
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\Managed
	 */
	public function isIdentical(object $object) : bool
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
					'isIdentical',
					'start',
					'core\\Managed',
				),
				[
					'class_1' => \get_class($this),
					'class_2' => \get_class($object),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'isIdentical',
					'start',
				],
				[
					$this,
					$object,
				],
			);

			if (\get_class($this) !== \get_class($this))
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$this->lang(
						'isIdentical',
						'dif_class',
						'core\\Managed',
					),
					[
						'class_1' => \get_class($this),
						'class_2' => \get_class($object),
					],
				);

				return False;
			}
			foreach ($this::INDEX as $attribute)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\ManagedException(
						message: $this->lang(
							'isIdentical',
							'type_attribute',
							'core\\Managed',
						),
						tokens:  [
							'class' => \get_class($this),
							'type'  => \gettype($attribute),
						],
					);
				}
				if ($this->$attribute === null || $object->$attribute === null)
				{
					$GLOBALS['Logger']->log(
						[
							'class',
							'core',
							\core\LoggerTypes::DEBUG,
						],
						$this->lang(
							'isIdentical',
							'missing_index',
							'core\\Managed',
						),
						[
							'class_1' => \get_class($this),
							'class_2' => \get_class($object),
							'attribute' => $attribute,
						],
					);

					return False;
				}
				try
				{
					if ($this->get($attribute) !== $object->get($attribute))
					{
						$GLOBALS['Logger']->log(
							[
								'class',
								'core',
								\core\LogerTypes::DEBUG,
							],
							$this->lang(
								'isIdentical',
								'dif_index',
								'core\\Managed',
							),
							[
								'class_1' => \get_class($this),
								'class_2' => \get_class($object),
								'attribute' => $attribute,
							],
						);

						return False;
					}
				}
				catch (
					\exception\class\core\ManagedException |
					\exception\class\core\BaseException $exception
				)
				{
					throw new \exception\class\core\ManagedException(
						message:  $this->lang(
							'isIdentical',
							'get_error',
							'core\\Managed',
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

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'isIdentical',
					'end',
				],
				[
					$this,
					$object,
				],
			);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'isIdentical',
					'same',
					'core\\Managed',
				),
				[
					'class_1' => \get_class($this),
					'class_2' => \get_class($object),
				],
			);

			return True;
		}
		catch (
			\exception\class\core\ManagedException $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:  $this->lang(
					'isIdentical',
					'error',
					'core\\Managed',
				),
				tokens:   [
					'class_1'   => \get_class($this),
					'class_2'   => \get_class($object),
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Create an instance of the associated manager
	 *
	 * @param \PDO $connection
	 *
	 * @return mixed
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function manager(\PDO $connection = null) : mixed
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG
				],
				$this->lang(
					'manager',
					'start',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			$manager = \get_class($this) . 'Manager';

			if (!\class_exists($manager))
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'manager',
						'not_defined',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'manager',
					'end',
				],
				$this,
			);

			$GLOBALS['Logger']->log(
				[
					'core',
					'class',
					\core\LoggerTypes::DEBUG,
				],
				$this->lang(
					'manager',
					'end',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			try
			{
				return new $manager($connection);
			}
			catch (\exception\class\core\ManagerException)
			{
				throw new \exception\class\core\ManagedException(
					message:  $this->lang(
						'manager',
						'manager_error',
						'core\\Managed',
					),
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
				message:  $this->lang(
					'manager',
					'error',
					'core\\Managed',
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
	 * Retrieve data from the database
	 *
	 * @return \core\Managed
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function retrieve() : self
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
					'retrieve',
					'start',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'retrieve',
					'start',
				],
				$this,
			);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'retrieve',
						'not_defined',
						'core\\Managed',
					),
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'retrieve',
					'check',
				],
				$this,
			);

			$index = [];
			foreach ($this::INDEX as $attribute)
			{
				if (!\is_string($attribute))
				{
					throw new \exception\class\core\ManagedException(
						message: $this->lang(
							'retrieve',
							'type_attribute',
							'core\\Managed',
						),
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
						message:  $this->lang(
							'retrieve',
							'get_error',
							'core\\Managed',
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

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'retrieve',
					'end'
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
					'retrieve',
					'end',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			$this->hydrate($this->manager()->get($index));

			return $this;
		}
		catch (
			\exception\class\core\ManagedException $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:  $this->lang(
					'retrieve',
					'error',
					'core\\Managed',
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
	 * Update the database
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\ManagedException
	 */
	public function update() : bool
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
					'update',
					'start',
					'core\\Managed',
				),
				[
					'class' => \get_class($this),
				],
			);

			$GLOBALS['Hook']::load(
				[
					'class',
					'core',
					'Managed',
					'update',
					'start',
				],
				$this,
			);

			if (!$this->exist())
			{
				throw new \exception\class\core\ManagedException(
					message: $this->lang(
						'update',
						'not_exist',
						'core\\Managed',
					),
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
					message:  $this->lang(
						'update',
						'missing_index',
						'core\\Managed',
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
					'Managed',
					'update',
					'end',
				],
				$this,
			);
			try
			{
				$this->manager()->update(
					\array_diff_key(
						$this->table(),
						$this->getIndex()
					),
					$this->getIndex(),
				);
			}
			catch (\exception\class\core\ManagerException $exception)
			{
				throw new \exception\class\core\ManagedException(
					message:  $this->lang(
						'update',
						'manager_error',
						'core\\Managed',
					),
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
			\exception\class\core\BaseException $exception
		)
		{
			throw new \exception\class\core\ManagedException(
				message:  $this->lang(
					'udpate',
					'error',
					'core\\Managed',
				),
				tokens:   [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
}

?>
