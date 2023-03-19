<?php

namespace core;

/**
 * Manager the connection between a PHP object and its data stored in a database
 */
abstract class Manager
{
	/**
	 * PDO database connection
	 *
	 * @var \PDO
	 */
	protected ?\PDO $db = null;
	/**
	 * Name of the table linked to the object
	 *
	 * @var string
	 */
	const TABLE = '';
	/**
	 * Attributes list of the table linked to the object
	 *
	 * @var array
	 */
	const ATTRIBUTES = [];
	/**
	 * Index (primary keys)
	 *
	 * @var array
	 */
	const INDEX = [];
	/**
	 * Reserved Keyword for database column
	 *
	 * @var array
	 */
	const RESERVED_KEYWORD = [
		'KEY',
	];
	/**
	 * Constructor
	 *
	 * @param \PDO|null $db PDO database connection.
	 *                        If null, \core\DBConnection::connection() will be used.
	 *                        Default to null
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function __construct(\PDO $db = null)
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
					'__construct',
					'start',
					'core\\Manager',
				),
				[
					'class' => \get_class($this),
				],
			);

			if ($db === null)
			{
				$db = \core\DBFactory::connection();
			}

			$this->setDB($db);

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					'core\\Manager',
				],
				$this->lang(
					'__construct',
					'end',
					'core\\Manager',
				),
				[
					'class' => \get_class($this),
				],
			);
		}
		catch (\exception\class\core\ManagerException $exception)
		{
			throw new \exception\class\core\ManagerException(
				message: $this->lang(
					'__construct',
					'error',
					'core\\Manager',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Add a database entry and return its index
	 *
	 * @param array $values attribute name => value
	 *
	 * @return array
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function add(array $values) : array
	{
		try
		{
			$values = $this->cleanAttributes($values);

			if (\count($values) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'add',
						'no_values',
						'core\\Manager',
					),
				);
			}

			$table = new \database\parameter\Table([
				'name' => $this::TABLE,
			]);

			$attributes = [];
			$parameters = [];
			$query_values = [];
			$position = 0;
			foreach ($values as $name => $value)
			{
				$attributes[] = new \database\parameter\Attribute([
					'name'  => $name,
					'table' => $table,
				]);
				$parameters[] = new \database\parameter\Parameter([
					'value'    => $value,
					'position' => $position,
				]);
				$query_values[] = $value;
				$position += 1;
			}

			$Query = new \database\request\Insert([
				'parameters' => $attributes,
				'table'      => $table,
				'values'     => $parameters,
			]);

			$connection = \core\DBFactory::connection();

			$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);

			return $this->getIdBy($values);
		}
		catch (
			\exception\class\core\ManagerException ||
			\exception\class\core\BaseException ||
			\exception\class\database\DriverException ||
			\PDOException ||
			\exception\class\core\DBFactoryException $exception
		)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'add',
					'error',
					'core\\Manager',
				),
				tokens:    [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Remove from an array all the element where the key is not in
	 * the array $this::ATTRIBUTES
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	public function cleanAttributes(array $attributes) : array
	{
		$values = \array_intersect_key(
			$attributes,
			\array_flip($this::ATTRIBUTES),
		);
		foreach ($values as $key => $value)
		{
			if (\is_bool($value))
			{
				$values[$key] = (int)$value;
			}
			if (\in_array(\strtoupper($key), $this::RESERVED_KEYWORD))
			{
				unset($values[$key]);
				$values['`' . $key . '`'] = $value;
			}
		}
		return $values;
	}
	/**
	 * count all entries of the table
	 *
	 * @return int
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function count() : int
	{
		try
		{
			$table = new \database\parameter\Table([
				'name' => $this::TABLE,
			]);

			$attribute = new \database\parameter\Attribute([
				'table' => $table,
				'name'  => $this::INDEX[0],
			]);

			$column = new \database\parameter\Column([
				'attribute' => $attribute,
				'function'  => 'COUNT',
				'alias'     => 'nbr',
			]);

			$Query = new \database\request\Select([
				'from'   => $table,
				'select' => [$column],
			]);

			$connection = \core\DBFactory::connection();

			$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute();

			return $request->fetchAll(\PDO::FETCH_ASSOC)[0]['nbr'];
		}
		catch (
			\exception\class\core\ManagerException ||
			\exception\class\core\BaseException ||
			\exception\class\core\DBFactoryException ||
			\exception\class\database\DriverException ||
			\PDOException $exception
		)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'count',
					'error',
					'core\\Manager',
				),
				tokens:    [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * count entries respecting a condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations is a string, it
	 *                                 will be considered as an
	 *                                 array with the same operation
	 *                                 for each entry.
	 *                                 Default to "=".
	 *
	 * @return int
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function countBy(array $values, array|string $operations = '=') : int
	{
		try
		{
			$values = $this->cleanAttributes($values);

			if (\count($values) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'countBy',
						'no_values',
						'core\\Manager',
					),
				);
			}
			if (\phosphore_count($operations) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'countBy',
						'no_operations',
						'core\\Manager',
					),
				);
			}

			$table = new \database\parameter\Table([
				'name'  => $this::TABLE,
			]);

			$operation     = $operations;
			$expressions   = [];
			$query_values  = [];
			$position      = 0;
			foreach ($this::ATTRIBUTES as $name)
			{
				if (\key_exists($name, $values))
				{
					if (\is_array($operations))
					{
						if (!\key_exists($name, $operations))
						{
							throw new \exception\class\core\ManagerException(
								message: $this->lang(
									'countBy',
									'bad_key',
									'core\\Manager',
								),
								tokens:  [
									'key' => $name,
								],
							);
						}

						$operation = $operations[$name];
					}

					$attribute = new \database\parameter\Attribute([
						'name'  => $name,
						'table' => $table,
					]);

					$expressions[] = new \database\parameter\Expression([
						'type'   => \database\parameter\ExpressionTypes::COMP,
						'values' => [
							new \database\parameter\Column([
								'attribute' => $attribute,
							]),
							new \database\parameter\Parameter([
								'value'    => $values[$name],
								'position' => $position,
							]),
						],
						'operator' => new \database\parameter\Operator([
							'symbol' => $operation,
						]),
					]);
					$position += 1;
					$query_values[] = $values[$name];
				}
			}

			$column = new \database\parameter\Column([
				'attribute' => $attribute,
				'function'  => 'COUNT',
				'alias'     => 'nbr',
			]);

			$where = new \database\parameter\Expression([
				'expressions' => $expressions,
				'type'        => \database\parameter\ExpressionTypes::AND,
			]);

			$Query = new \database\request\Select([
				'from'   => $table,
				'select' => [$column],
				'where'  => $where,
			]);

			$connection = \core\DBFactory::connection();

			$driver_class = '\\database\\' . \ucwords(
				\strtolower(
					$connection->getAttribute(\PDO::ATTR_DRIVER_NAME),
				),
			);

			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);

			return $request->fetchAll(\PDO::FETCH_ASSOC)[0]['nbr'];
		}
		catch (
			\exception\class\core\ManagerException ||
			\exception\class\core\BaseException ||
			\exception\class\core\DBFactory ||
			\exception\class\database\DriverException ||
			\PDOException $exception
		)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'countBy',
					'error',
					'core\\Manager',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Delete an entry
	 *
	 * @param array $index attribute name => value
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function delete(array $index) : bool
	{
		try
		{
			$index = $this->cleanAttributes($index);

			if (\count($index) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'delete',
						'no_index',
						'core\\Manager',
					),
				);
			}
			foreach ($this::INDEX as $name)
			{
				if (!\key_exists($name, $index))
				{
					throw new \exception\class\core\ManagerException(
						message: $this->lang(
							'delete',
							'bad_index',
							'core\\Manager',
						),
						tokens:  [
							'key' => $name,
						],
					);
				}
			}

			$table = new \database\parameter\Table([
				'name' => $this::TABLE,
			]);

			$expressions  = [];
			$values       = [];
			$position     = 0;
			foreach ($this::ATTRIBUTES as $name)
			{
				if (\key_exists($name, $index))
				{
					$expressions[] = new \database\parameter\Expression([
						'type'     => \database\parameter\ExpressionTypes::COMP,
						'values'   => [
							new \database\parameter\Column([
								'attribute' => new \database\parameter\Attribute([
									'name'  => $name,
									'table' => $table,
								]),
							]),
							new \database\parameter\Parameter([
								'value'    => $index[$name],
								'position' => $position,
							]),
						],
						'operator' => new \database\parameter\Operator([
							'symbol' => '=',
						]),
					]);
					$position += 1;
					$values[] = $index[$name];
				}
			}

			$where = new \database\parameter\Expression([
				'expressions' => $expressions,
				'type'        => \database\parameter\ExpressionTypes::AND,
			]);

			$Query = new \database\request\Delete([
				'delete' => $table,
				'where'  => $where,
			]);

			$connection = \core\DBFactory::connection();

			$driver_class = '\\database\\' . \ucwords(
				\strtolower(
					$connection->getAttribute(\PDO::ATTR_DRIVER_NAME),
				),
			);

			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($values);

			return True;
		}
		catch (
			\exception\class\core\ManagerException ||
			\exception\class\core\DBFactoryManager ||
			\exception\class\core\BaseException ||
			\exception\class\database\DriverException ||
			\PDOException $exception
		)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'delete',
					'error',
					'core\\Manager',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Delete entries which comply with a condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations is a string, it
	 *                                 will be considered as an array
	 *                                 with the same operation for each
	 *                                 entry.
	 *                                 Default to "=".
	 *
	 * @return int Number of deleted entries
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function deleteBy(array $values, array|string $operations = '=') : int
	{
		try
		{
			$values = $this->cleanAttributes($values);

			if (\count($values) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'deleteBy',
						'no_values',
						'core\\Manager',
					),
				);
			}
			if (\phosphore_count($operations) === 0)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'deleteBy',
						'no_operations',
						'core\\Manager',
					),
				);
			}

			$count = $this->countBy($values, $operations);

			if ($count === 0)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::WARNING,
					],
					$this->lang(
						'deleteBy',
						'nothing_delete',
						'core\\Manager',
					),
				);

				return 0;
			}

			$table = new \database\parameter\Table([
				'name' => $this::TABLE,
			]);

			$operation    = $operations;
			$expressions  = [];
			$query_values = [];
			$position     = 0;
			foreach ($this::ATTRIBUTES as $name)
			{
				if (\key_exists($name, $values))
				{
					if (\is_array($operations))
					{
						if (!\key_exists($name, $operations))
						{
							throw new \exception\class\core\ManagerException(
								message: $this->lang(
									'deleteBy',
									'bad_key',
									'core\\Manager',
								),
								tokens:  [
									'key' => $name,
								],
							);
						}

						$operation = $operations[$name];
					}

					$expressions[] = new \database\parameter\Expression([
						'type'     => \database\parameter\ExpressionTypes::COMP,
						'values'   => [
							new \database\parameter\Column([
								'attribute' => new \database\parameter\Attribute([
									'name'  => $name,
									'table' => $table,
								]),
							]),
							new \database\parameter\Parameter([
								'value'    => $values[$name],
								'position' => $position,
							]),
						],
						'operator' => new \database\parameter\Operator([
							'symbol' => $operation,
						]),
					]);

					$position += 1;
					$query_values[] = $values[$name];
				}
			}

			$where = new \database\parameter\Expression([
				'expressions' => $expressions,
				'type'        => \database\parameter\ExpressionTypes::AND,
			]);

			$Query = new \database\request\Delete([
				'delete' => $table,
				'where'  => $where,
			]);

			$connection = \core\DBFactory::connection();

			$driver_class = '\\database\\' . \ucwords(
				\strtolower(
					$connection->getAttribute(\PDO::ATTR_DRIVER_NAME),
				),
			);

			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);

			return $count;
		}
		catch (
			\exception\class\core\ManagerException ||
			\exception\class\core\DBFactory ||
			\exception\class\core\BaseException ||
			\exception\class\database\DriverException ||
			\PDOException $exception
		)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'deleteBy',
					'error',
					'core\\Manager',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Check the existence of an entry with a given index
	 *
	 * @param array $index
	 *
	 * @return bool
	 *
	 * @throws \exception\class\core\ManagerException
	 */
	public function exist(array $index) : bool
	{
		try
		{

			foreach ($this::INDEX as $name)
			{
				if (!\array_key_exists($name, $index))
				{
					throw new \exception\class\core\ManagerException(
						message: $this->lang(
							'exist',
							'no_index',
							'core\\Manager',
						),
						tokens:  [
							'key' => $name,
						]
					);
				}
			}
			$number = $this->countBy($index);
			if ($number > 1)
			{
				throw new \exception\class\core\ManagerException(
					message: $this->lang(
						'exist',
						'too_many',
						'core\\Manager',
					),
					tokens:   [
						'number' => $number,
						'class'  => \get_class($this),
					],
				);
			}

			return $number != 0;
		}
		catch (\exception\class\core\ManagerException $exception)
		{
			throw new \exception\class\core\ManagerException(
				message:  $this->lang(
					'exist',
					'error',
					'core\\Manager',
				),
				tokens:   [
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
	/**
	 * Check the existence of an entry which comply to a condition
	 *
	 * @param array $values Name => value of attributes
	 *
	 * @param array|string $operations Name => operation / operation
	 *
	 * @return bool
	 */
	public function existBy(array $values, array|string $operations = '=') : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['existBy'], ['class' => \get_class($this)]);
		return $this->countBy($values, $operations) != 0;
	}
	/**
	 * Get an entry from an index
	 *
	 * @param array $index attribute name => value
	 *
	 * @return array
	 */
	public function get(array $index) : array
	{
		$index = $this->cleanAttributes($index);

		if (\count($index) === 0)
		{
			throw new \Exception();
		}
		foreach ($this::INDEX as $name)
		{
			if (!\key_exists($name, $index))
			{
				throw new \Exception();
			}
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$expressions = [];
		$select = [];
		$position = 0;
		$values = [];
		foreach ($this::ATTRIBUTES as $name)
		{
			$attribute = new \database\parameter\Attribute([
				'name'  => $name,
				'table' => $table,
			]);
			if (\key_exists($name, $index))
			{
				$expressions[] = new \database\parameter\Expression([
					'type'     => \database\parameter\ExpressionTypes::COMP,
					'values'   => [
						new \database\parameter\Column([
							'attribute' => $attribute,
						]),
						new \database\parameter\Parameter([
							'value'    => $index[$name],
							'position' => $position,
						]),
					],
					'operator' => new \database\parameter\Operator([
						'symbol' => '=',
					]),
				]);
				$position += 1;
				$values[] = $index[$name];
			}

			$select[] = new \database\parameter\Column([
				'attribute' => $attribute,
			]);
		}

		$where = new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Select([
			'from'   => $table,
			'select' => $select,
			'where'  => $where,
		]);

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC)[0];
	}
	/**
	 * Get simple table results
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations is a string, it will be considered as an
	 *                                 array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @param null|array|string $order_by attribute name => direction (ASC|DESC).
	 *                               If $order_by is a string, it will be considered as
	 *                               [ $order_by => "DESC" ].
	 *                               Default to null.
	 *
	 * @param null|array|int $limit [ $number, $offset ]. $offset is optionnal.
	 *                          If $limit is an int, it will be considered as [ $limit ].
	 *                          Default to null.
	 *
	 * @return array
	 */
	public function getBy(array $values, array|string $operations = '=', null|array|string $order_by = null, null|array|int $limit = null) : array
	{
		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			throw new \Exception();
		}
		if (\phosphore_count($operations) === 0)
		{
			throw new \Exception();
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$operation    = $operations;
		$selects      = [];
		$expressions  = [];
		$position     = 0;
		$query_values = [];
		foreach ($this::ATTRIBUTES as $name)
		{
			$attribute = new \database\parameter\Attribute([
				'name'  => $name,
				'table' => $table,
			]);
			$selects[] = new \database\parameter\Column([
				'attribute' => $attribute,
			]);

			if (\key_exists($name, $values))
			{
				if (\is_array($operations))
				{
					if (!\key_exists($name, $operations))
					{
						throw new \Exception();
					}

					$operation = $operations[$name];
				}

				$expressions[] = new \database\parameter\Expression([
					'operator' => new \database\parameter\Operator([
						'symbol' => $operation,
					]),
					'values' => [
						new \database\parameter\Column([
							'attribute' => $attribute,
						]),
						new \database\parameter\Parameter([
							'value'    => $values[$name],
							'position' => $position,
						]),
					],
					'type'   => \database\parameter\ExpressionTypes::COMP,
				]);
				$query_values[] = $values[$name];
				$position += 1;
			}
		}

		$where = new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Select([
			'select' => $selects,
			'from'   => $table,
			'where'  => $where,
		]);

		if ($order_by !== null)
		{
			if (\is_string($order_by))
			{
				$order_by = [$order_by => 'DESC'];
			}

			if (empty($order_by))
			{
				throw new \Exception();
			}

			$OrderBys = [];
			foreach ($order_by as $name => $direction)
			{
				if (\is_string($direction))
				{
					$direction = \database\parameter\OrderByTypes::tryFrom($direction);
					if ($direction == null)
					{
						throw new \Exception();
					}
				}
				$OrderBy = new \database\parameter\OrderBy([
					'column' => new \database\parameter\Column([
						'attribute' => new \database\parameter\Attribute([
							'name'  => $name,
							'table' => $Table,
						]),
					]),
					'type'   => $direction,
				]);
				$OrderBys[] = $OrderBy;
			}
			$Query->set('orderBy', $OrderBy);
		}

		if ($limit !== null)
		{
			if (empty($limit))
			{
				throw new \Exception();
			}

			if (\is_int($limit))
			{
				$Limit = new \database\parameter\Limit([
					'count' => $limit,
				]);
			}
			else if (\count($limit) == 2)
			{
				$Limit = new \database\parameter\Limit([
					'count'  => $limit[0],
					'offset' => $limit[1],
				]);
			}
			else
			{
				throw new \Exception();
			}

			$Query->set('limit', $Limit);
		}

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query   = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC);
	}
	/**
	 * db getter
	 *
	 * @return \PDO
	 */
	public function getDb() : \PDO
	{
		return $this->db;
	}
	/**
	 * Get index of entries which comply to condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param string|array $operations attribute name => operation.
	 *                                 If $operations is a string, it will be considered as
	 *                                 an array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @return array
	 */
	public function getIdBy(array $values, array|string $operations = '=') : array
	{
		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			throw new \Exception();
		}
		if (\phosphore_count($operations) === 0)
		{
			throw new \Exception();
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$operation    = $operations;
		$selects      = [];
		$expressions  = [];
		$position     = 0;
		$query_values = [];
		# select index only
		foreach ($this::INDEX as $name)
		{
			$selects[] = new \database\parameter\Column([
				'attribute' => new \database\parameter\Attribute([
					'name'  => $name,
					'table' => $table,
				]),
			]);
		}
		# expression to check
		foreach ($this::ATTRIBUTES as $name)
		{
			if (\key_exists($name, $values))
			{
				if (\is_array($operations))
				{
					if (!\key_exists($name, $operations))
					{
						throw new \Exception();
					}

					$operation = $operation[$name];
				}
				$expressions[] = new \database\parameter\Expression([
					'operator' => new \database\parameter\Operator([
						'symbol' => $operation,
					]),
					'type'     => \database\parameter\ExpressionTypes::COMP,
					'values'   => [
						new \database\parameter\Column([
							'attribute' => new \database\parameter\Attribute([
								'name'  => $name,
								'table' => $table,
							]),
						]),
						new \database\parameter\Parameter([
							'value'    => $values[$name],
							'position' => $position,
						]),
					],
				]);
				$query_values[] = $values[$name];
				$position += 1;
			}
		}

		$where = new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Select([
			'select' => $selects,
			'from'   => $table,
			'where'  => $where,
		]);

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query   = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC);
	}
	/**
	 * Get an index of the nth entry for an attribute
	 *
	 * @param string $attribute Name of the attribute for the order by
	 *
	 * @param int $position Position of the entry (0 = first).
	 *                      Default to 0.
	 *
	 * @param string $direction Direction of the order by (ASC|DESC).
	 *                          Default to 'DESC'.
	 *
	 * @return array
	 */
	public function getIdByPos(string $attribute, int $position = 0, string $direction = 'DESC') : array
	{
		if (!\in_array($attribute, $this::ATTRIBUTES))
		{
			throw new \Exception();
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$selects = [];
		foreach ($this::INDEX as $name)
		{
			$selects[] = new \database\parameter\Column([
				'attribute' => new \database\parameter\Attribute([
					'name'  => $name,
					'table' => $table,
				]),
			]);
		}

		$type = \database\parameter\OrderByTypes::tryFrom($direction);
		if ($type === null)
		{
			throw new \Exception();
		}

		$order_by = new \database\parameter\OrderBy([
			'column' => new \database\parameter\Column([
				'attribute' => new \database\parameter\Attribute([
					'name'  => $attribute,
					'table' => $table,
				]),
			]),
			'type'   => $type,
		]);

		$limit = new \database\parameter\Limit([
			'count'  => 1,
			'offset' => $position,
		]);

		$Query = new \database\request\Select([
			'select'  => $selects,
			'from'    => $table,
			'orderBy' => $order_by,
			'limit'   => $limit,
		]);

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query   = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute();
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC);
	}
	/**
	 * Get the next value for the index:
	 *                                  last value in the dictionnary order for string.
	 *                                  next value for int.
	 *
	 * @return array
	 */
	public function getNextId() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getNextId'], ['class' => \get_class($this)]);

		$results = [];
		foreach ($this::INDEX as $name)
		{
			$results[$name] = $this->getIdByPos($name, 0, 'ASC')[$name];
			if (\is_numeric($results[$name]))
			{
				$results[$name] = (int) $results[$name] + 1;
			}
		}
		return $results;
	}
	/**
	 * Create an instance of the \core\Managed class associated to this one
	 *
	 * @param array $table Array for hydratation
	 *
	 * @return mixed
	 */
	public function managed(array $table) : mixed
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['managed']['start'], ['class' => \get_class($this)]);

		$managed = \substr(\get_class($this), 0, -7);
		if (!\class_exists($managed))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['managed']['not_defined'], ['class' => \get_class($this), 'managed' => $managed]);

			return False;
		}

		return new $managed($table);
	}
	/**
	 * Retrieves directly objects which comply to a condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations if a string, it will be considered as an
	 *                                 array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @param null|array|string $order_by attribute name => direction (ASC|DESC).
	 *                                    If $order_by is a string, it will be considered as
	 *                                    [ $order_by => "DESC" ].
	 *                                    Default to null.
	 *
	 * @param null|array|int $limit [ $number, $offset ]. $offset is optionnal.
	 *                                 If $limit is an int, it will be considered as [ $limit ].
	 *                                 Default to null.
	 *
	 * @param string $class_name Class name if different (LinkManager for example).
	 *                           Default to "".
	 *
	 * @param array $attributes_conversion Convert attribute name if custom class.
	 *                                     For example: ['id_route' => 'id'] convert id_route
	 *                                     attribute to id to retrieve \route\Route object
	 *                                     Default to [].
	 *
	 * @return array
	 */
	public function retrieveBy(array $values, array|string $operations = '=', null|string|array $order_by = null, null|array|int $limit = null, string $class_name = '', array $attributes_conversion = []) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['start'], ['class' => \get_class($this)]);

		$results = $this->getBy($values, $operations, $order_by, $limit);
		$Objects = [];

		if ($class_name === '')
		{
			foreach ($results as $result)
			{
				$Objects[] = $this->managed($result);
			}
		}
		else
		{
			if (!\class_exists($class_name))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_not_defined'], ['class' => \get_class($this), 'managed' => $class_name]);

				return False;
			}

			$class_manager_name = $class_name . 'Manager';
			if (!\class_exists($class_manager_name))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_manager_not_defined'], ['class' => \get_class($this), 'manager' => $class_manager_name]);

				return False;
			}

			$manager = new $class_manager_name();

			if (\phosphore_count($results) !== 0)
			{
				if (empty($attributes_conversion))
				{
					foreach ($results as $result)
					{
						$Objects[] = new $class_name($result);
					}
				}
				else
				{
					foreach ($results as $id => $result)
					{
						foreach ($result as $key => $value)
						{
							if (isset($attributes_conversion[$key]))
							{
								$result[$attributes_conversion[$key]] = $value;
								unset($result[$key]);
							}
						}
						$Objects[] = $manager->retrieveBy($result)[0];
					}
				}
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['end'], ['class' => \get_class($this)]);

		return $Objects;
	}
	/**
	 * db setter
	 *
	 * @param \PDO $db PDO connection to the database
	*/
	protected function setDb($db) : void
	{
		if ($db instanceOf \PDO)
		{
			$this->db = $db;
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['setDb'], ['class' => \get_class($this)]);
		}
	}
	/**
	 * Update an entry
	 *
	 * @param array $values attribute name => new value
	 *
	 * @param array $index index name => old value
	 *
	 * @return bool
	  */
	 public function update(array $values, array $index) : bool
	 {
		$values = $this->cleanAttributes($values);
		$index = $this->cleanAttributes($index);

		if (\count($values) === 0)
		{
			throw new \Exception();
		}
		if (\count($index) === 0)
		{
			throw new \Exception();
		}
		foreach ($this::INDEX as $name)
		{
			if (!\key_exists($name, $index))
			{
				throw new \Exception();
			}
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$attributes   = [];
		$new_values   = [];
		$expressions  = [];
		$query_values = [];
		$position     = 0;
		foreach ($this::ATTRIBUTES as $name)
		{
			if (\key_exists($name, $values))
			{
				$attributes[] = new \database\parameter\Attribute([
					'name'  => $name,
					'table' => $table,
				]);
				$new_values[] = new \database\parameter\Parameter([
					'value'    => $values[$name],
					'position' => $position,
				]);
				$query_values[] = $values[$name];
				$position += 1;
			}
		}
		foreach ($this::ATTRIBUTES as $name)
		{
			if (\key_exists($name, $index))
			{
				$expressions[] = new \database\parameter\Expression([
					'operator' => new \database\parameter\Operator([
						'symbol' => '=',
					]),
					'values'   => [
						new \database\parameter\Column([
							'attribute' => new \database\parameter\Attribute([
								'name'  => $name,
								'table' => $table,
							]),
						]),
						new \database\parameter\Parameter([
							'value'    => $index[$name],
							'position' => $position,
						]),
					],
					'type'     => \database\parameter\ExpressionTypes::COMP,
				]);
				$query_values[] = $index[$name];
				$position += 1;
			}
		}

		$where = new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Update([
			'table' => $table,
			'sets'  => [
				'values'     => $new_values,
				'attributes' => $attributes,
			],
			'where' => $where,
		]);

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query   = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return True;
	 }
	/**
	 * Update entries which comply to a condition
	 *
	 * @param array $values attribute name => new value
	 *
	 * @param array $retrieve attribute name => old value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If operations is a string, it will be considered as an
	 *                                 array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @return int Number of updated values
	 */
	public function updateBy(array $values, array $retrieve, array|string $operations = '=') : int
	{
		$values = $this->cleanAttributes($values);
		$retrieve = $this->cleanAttributes($retrieve);

		if (\count($values) === 0)
		{
			throw new \Exception();
		}
		if (\count($retrieve) === 0)
		{
			throw new \Exception();
		}
		if (\phosphore_count($operations) === 0)
		{
			throw new \Exception();
		}

		$count = $this->countBy($retrieve, $operations);

		if ($count === 0)
		{
			return 0;
		}

		$table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$operation    = $operations;
		$attributes   = [];
		$new_values   = [];
		$expressions  = [];
		$query_values = [];
		$position     = 0;
		foreach ($this::ATTRIBUTES as $name)
		{
			if (\key_exists($name, $values))
			{
				$attributes[] = new \database\parameter\Expression([
					'name'  => $name,
					'table' => $table,
				]);
				$new_values[] = new \database\parameter\Parameter([
					'value'    => $values[$name],
					'position' => $position,
				]);
				$query_values[] = $values[$name];
				$position += 1;
			}
		}
		foreach ($this::ATTRIBUTES as $name)
		{
			if (\key_exists($name, $retrieve))
			{
				if (\is_array($operations))
				{
					if (!\key_exists($name, $operations))
					{
						throw new \Exception();
					}

					$operation = $operations[$name];
				}
				$expressions[] = new \database\parameter\Expression([
					'operator' => new \database\parameter\Operator([
						'symbol' => $operation,
					]),
					'values'   => [
						new \database\parameter\Column([
							'attribute' => new \database\parameter\Attribute([
								'name'  => $name,
								'table' => $table,
							]),
						]),
						new \database\parameter\Parameter([
							'value'    => $retrieve[$name],
							'position' => $position,
						]),
					],
					'type'     => \database\parameter\ExpressionTypes::COMP,
				]);
				$query_values[] = $values[$name];
				$position += 1;
			}
		}

		$where = new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Update([
			'table' => $table,
			'sets'  => [
				'values'     => $new_values,
				'attributes' => $attributes,
			],
			'where' => $where,
		]);

		$connection = \core\DBFactory::connection();

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query   = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $count;
	}
}

?>
