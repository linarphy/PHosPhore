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
	 */
	public function __construct(\PDO $db = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['__construct'], ['class' => \get_class($this)]);

		if ($db === null)
		{
			$db = \core\DBFactory::connection();
		}

		$this->setDB($db);
	}
	/**
	 * Add a database entry and return its index
	 *
	 * @param array $values attribute name => value
	 *
	 * @return array
	 */
	public function add(array $values) : array
	{
		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			throw new \Exception();
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

		try
		{
			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception($exception->getMessage());
		}

		return $this->getIdBy($values);
	}
	/**
	 * Remove from an array all the element where the key is not in the array $this::ATTRIBUTES
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	public function cleanAttributes(array $attributes) : array
	{
		$values = \array_intersect_key($attributes, \array_flip($this::ATTRIBUTES));
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
	 */
	public function count() : int
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

		try
		{
			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute();
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC)[0]['nbr'];
	}
	/**
	 * count entries respecting a condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations is a string, it will be considered as an
	 *                                 array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @return int
	 */
	public function countBy(array $values, array|string $operations = '=') : int
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
						throw new \Exception();
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

		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		try
		{
			$query = $driver_class::displayQuery($Query);
			$request = $connection->prepare($query);
			$request->execute($query_values);
		}
		catch (\PDOException $exception)
		{
			throw new \Exception();
		}

		return $request->fetchAll(\PDO::FETCH_ASSOC)[0]['nbr'];
	}
	/**
	 * Delete an entry
	 *
	 * @param array $index attribute name => value
	 *
	 * @return bool
	 */
	public function delete(array $index) : bool
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

		$QC = new \database\QueryConstructor();

		$QC->delete($this::TABLE);

		$wheres = [];
		foreach ($index as $name => $value)
		{
			$wheres[] = $QC->exp()->col($name, $this::TABLE)
				                  ->param($value)
							      ->op('=')
							      ->end();
		}

		$QC->where($QC->exp()->and(...$wheres)->end());

		return $QC->run();
	}
	/**
	 * Delete an entry
	 *
	 * @param array $index Index of the entry
	 *
	 * @return bool
	 *//**
	public function delete(array $index) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['delete']['start'], ['class', \get_class($this)]);

		$indexes = [];
		$values = [];
		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['delete']['missing_index'], ['class' => \get_class($this), 'attribute' => $name]);

				return False;
			}
			$values[] = $index[$name];
			$indexes[] = $name .= '=?';
		}

		$query = 'DELETE FROM ' . $this::TABLE . ' WHERE ' . \implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['delete']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute($values);

		return True;
	}
	/**
	 * Delete entries which comply with a condition
	 *
	 * @param array $values attribute name => value
	 *
	 * @param array|string $operations attribute name => operation.
	 *                                 If $operations is a string, it will be considered as an
	 *                                 array with the same operation for each entry.
	 *                                 Default to "=".
	 *
	 * @return int Number of deleted entries
	 */
	public function deleteBy(array $values, array|string $operations = '=') : int
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

		$count = $this->countBy($values, $operations);

		if ($count === 0)
		{
			return 0;
		}

		$QC = new \database\QueryConstructor();

		$QC->delete($this::TABLE);

		$operation = $operations;
		$wheres = [];
		foreach ($values as $name => $value)
		{
			if (\is_array($operations))
			{
				if (!\key_exists($name, $operations))
				{
					throw new \Exception();
				}

				$operation = $operations[$name];
			}

			$wheres[] = $QC->exp()->col($name, $this::TABLE)
				                  ->param($value)
							      ->op($operation)
							      ->end();
		}

		$QC->where($QC->exp()->and(...$wheres)->end());

		if ($QC->run() === True)
		{
			return $count;
		}

		return 0;
	}
	/**
	 * Delete entries which comply with a condition
	 *
	 * @param array $values Name => value of attributes
	 *
	 * @param array|string $conditions Name => operator / operator
	 *
	 * @return int Number of deleted entries
	 *//**
	public function deleteBy(array $values, array|string $conditions = null) : int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['start'], ['class' => \get_class($this)]);

		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['values'], ['class' => \get_class($this)]);

			return 0;
		}

		$number = $this->countBy($values, $conditions);

		$condition = $this->conditionCreator($values, $conditions);

		$query = 'DELETE FROM ' . $this::TABLE . ' WHERE ' . \implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values($condition[1]));

		return $number;
	}
	/**
	 * Check the existence of an entry with a given index
	 *
	 * @param array $index
	 *
	 * @return bool
	 */
	public function exist(array $index) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['exist']['start'], ['class' => \get_class($this)]);

		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['exist']['missing_index'], ['class' => \get_class($this), 'attribute' => $name]);

				return False;
			}
		}
		$number = $this->countBy($index);
		if ($number > 1)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Manager']['exist']['more_one_index'], ['class' => \get_class($this), 'number' => $number]);
		}

		return $number != 0;
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
	public function existBy(array $values, array|string $operations = null) : bool
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

		$Table = new \database\parameter\Table([
			'name' => $this::TABLE,
		]);

		$operation = $operations;
		$Selects = [];
		$Expressions = [];
		$position = 0;
		$query_values = [];
		foreach ($this::ATTRIBUTES as $name)
		{
			$Attribute = new \database\parameter\Attribute([
				'name' => $name,
				'table' => $Table,
			]);
			$Select = new \database\parameter\Column([
				'attribute' => $Attribute,
			]);
			$Selects[] = $Select;

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

				$Expression = new \database\parameter\Expression([
					'operator' => new \database\parameter\Operator([
						'symbol' => $operation,
					]),
					'values' => [
						new \database\parameter\Column([
							'attribute' => $Attribute,
						]),
						new \database\parameter\Parameter([
							'value'    => $values[$name],
							'position' => $position,
						]),
					],
					'type'   => \database\parameter\ExpressionTypes::COMP,
				]);
				$query_values[] = $values[$name];
				$Expressions[] = $Expression;
				$position += 1;
			}
		}

		$Expression = new \database\parameter\Expression([
			'expressions' => $Expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]);

		$Query = new \database\request\Select([
			'select' => $Selects,
			'from'   => $Table,
			'where'  => $Expression,
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
					$direction = \database\parameter\OrderByTypes::tryForm($direction);
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
			$query = $driver_class::displayQuery($Query);
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

		$QC = new \database\QueryConstructor();

		$operation = $operations;
		$wheres = [];
		foreach ($this::INDEX as $name)
		{
			$QC->select($name, $this::TABLE);
		}
		foreach ($values as $name => $value)
		{
			if (\is_array($operations))
			{
				if (!\key_exists($name, $operations))
				{
					throw new \Exception();
				}

				$operation = $operations[$name];
			}

			$wheres[] = $QC->exp()->col($name, $this::TABLE)
				                  ->param($value)
							      ->op($operation)
							      ->end();
		}

		$QC->from($this::TABLE);
		$QC->where($QC->exp()->and(...$wheres)->end());

		return $QC->run();
	}
	/**
	 * Get index of entries which comply to condition
	 *
	 * @param array $values Name => value for attribute
	 *
	 * @param array|string $operations Name => operator / operator
	 *
	 * @return array
	 *//**
	public function getIdBy(array $values, array|string $operations = null) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['start'], ['class' => \get_class($this)]);

		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['values'], ['class' => \get_class($this)]);

			return [];
		}

		$condition = $this->conditionCreator($values, $operations);

		$query = 'SELECT ' . \implode(', ', $this::INDEX) . ' FROM ' . $this::TABLE . ' WHERE ' . \implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values($condition[1]));

		return $request->fetchAll();
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

		$QC = new \database\QueryConstructor();

		foreach ($this::INDEX as $name)
		{
			$QC->select($name, $this::TABLE);
		}

		$QC->from($this::TABLE);

		$QC->orderBy($attribute, $this::TABLE, $direction);

		$QC->limit(1, $position);

		return $QC->run();
	}
	/**
	 * Get an index of the nth entry for an attribute
	 *
	 * @param string $attribute Name of the attribute for the order by
	 *
	 * @param int $position Position of the entry (0 = first)
	 *
	 * @param ASC|DESC $direction Direction of the order by
	 *
	 * @return array
	 *//**
	public function getIdByPos(array $attribute, int $position = 0, string $direction = 'DESC') : array
	{
		$GLOBALS['Logger']->get(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['start'], ['class' => \get_class($this)]);

		if (!is_int($position) || ($direction != 'ASC' && $direction != 'DESC') || !in_array($attribute, $this::ATTRIBUTES))
		{
			$GLOBALS['Logger']->get(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['invalid_data'], ['class' => \get_class($this)]);

			return [];
		}

		$query = 'SELECT ' . \implode(', ', $this::INDEX) . ' FROM ' . $this::TABLE . 'ORDER BY ' . $attribute . ' ' . $direction . ' LIMIT 1 OFFSET ' . $position;

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute();

		return $request->fetch(\PDO::FETCH_ASSOC);
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

		$QC = new \database\QueryConstructor();
		$QC->update($this::TABLE);

		foreach ($values as $name => $value)
		{
			$QC->put($name, $value);
		}

		$wheres = [];
		foreach ($index as $name => $value)
		{
			$wheres[] = $QC->exp()->col($name, $this::TABLE)
				                  ->param($value)
							      ->op('=')
							      ->end();
		}
		$QC->where($QC->exp()->and(...$wheres)->end());

		return $QC->run();
	 }
	/**
	 * Update an entry
	 *
	 * @param array $values New values
	 *
	 * @param array $index Index of the entry
	 *
	 * @return bool
	 *//**
	public function update(array $values, array $index) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['update']['start'], ['class' => \get_class($this)]);

		$indexes = [];
		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['update']['missing_index'], ['class' => \get_class($this), 'attribute' => $name]);

				return False;
			}
			$indexes[] = $name . '=?';
		}

		$values = $this->cleanAttributes($values);
		if (\count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['update']['values'], ['class' => \get_class($this)]);

			return False;
		}

		$condition = $this->conditionCreator($values, '=');

		$query = 'UPDATE ' . $this::TABLE  . ' SET ' . \implode(', ', $condition[0]) . ' WHERE ' . \implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['update']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values(\array_merge($condition[1], $index)));

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

		$QC = new \database\QueryConstructor();

		$QC->update($this::TABLE);

		foreach ($values as $name => $value)
		{
			$QC->put($name, $value);
		}

		$operation = $operations;
		$wheres = [];
		foreach ($retrieve as $name => $value)
		{
			if (\is_array($operations))
			{
				if (!\key_exists($name, $operations))
				{
					throw new \Exception();
				}

				$operation = $operations[$name];
			}

			$wheres[] = $QC->exp()->col($name, $this::TABLE)
				                  ->param($value)
			                      ->op($operation)
							      ->end();
		}

		$QC->where($QC->exp()->and(...$wheres)->end());

		if ($QC->run() === True)
		{
			return $count;
		}

		return 0;
	}
	/**
	 * Update entries which comply to condition
	 *
	 * @param array $values_get Name => value for non updated entries
	 *
		if (\count($values_get) === null || \count($values_update) === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['updateBy']['values'], ['class' => \get_class($this)]);

			return 0;
		}

		$number = $this->countBy($values_get, $operations);

		$condition_update = $this->conditionCreator($values_update, '=');
		$condition = $this->conditionCreator($values_get, $operations);

		$query = 'UPDATE ' . $this::TABLE . ' SET ' . \implode(', ', $condition_update[0]) . ' WHERE ' . \implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['Manager']['update']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values(\array_merge(\array_values($values_update), $values_get)));

		return $number;
	}*/
}

?>
