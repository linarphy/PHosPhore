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

		$QC = new \database\QueryConstructor();

		$QC->insert($this::TABLE);

		foreach ($values as $name => $value)
		{
			$QC->value($name, $value);
		}

		if ($QC->run() !== True)
		{
			throw new \Exception();
		}

		return $this->getIdBy($values);
	}
	/**
	 * Add a database entry and return its index
	 *
	 * @param array $attributes
	 *
	 * @return array|null
	 *//**
	public function add(array $attributes) : ?array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['start'], ['class' => \get_class($this)]);

		$attributes = $this->cleanAttributes($attributes);

		if (\count($attributes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Manager']['add']['no_attributes'], ['class' => \get_class($this)]);

			return null;
		}

		$query = 'INSERT INTO ' . $this::TABLE . ' (' . \implode(', ', \array_keys($attributes)) . ') VALUES (' . \implode(', ', \array_fill(0, \count($attributes), '?')) . ')';
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['query'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values($attributes));

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['success'], ['class' => \get_class($this)]);
		return $this->getIdBy($attributes);
	}
	/**
	 * Generate a LIMIT clause from an array
	 *
	 * @param array bounds Array which can have 3 keys:
	 *                         group => array which have 3 keys:
	 *                             attribute => attribute name
	 *                             operations => array of operation
	 *                             having => array of name => value
	 *                         order => array which have 2 keys:
	 *                             name => attribute name
	 *                             direction => ASC|DESC
	 *                         limit => array which have 2 keys:
	 *                             offset => int
	 *                             number => int
	 *
	 * @return string|null
	 *//**
	public function boundaryInterpreter(array $bounds) : ?string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['start'], ['class' => \get_class($this)]);

		$group_by = '';
		$order_by = '';
		$limit_by = '';

		foreach ($bounds as $key => $value)
		{
			switch ($key)
			{
				case 'group':
					if (!\is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['not_array'], ['class' => \get_class($this)]);

						return null;
					}
					if ($value['attribute'] === null)
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['missing_key'], ['class' => \get_class($this)]);

						return null;
					}
					$group_by = 'GROUP BY ' . $value['attribute'];

					if ($value['operations'] !== null && $value['having'] !== null)
					{
						$group_by .= ' HAVING ' . \implode(' AND ', $this->conditionCreator($value['having'], $value['operations'])[0]);
					}
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['end'], ['class' => \get_class($this), 'query' => $group_by]);
				break;
				case 'order':
					if (!\is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['not_array'], ['class' => \get_class($this)]);
					}
					if (!\in_array($value['name'], $this::ATTRIBUTES))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['unknown_name'], ['class' => \get_class($this)]);

						return null;
					}
					$order_by = 'ORDER BY '.$value['name'];
					if ($value['direction'] != 'ASC' && $value['direction'] != 'DESC')
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['direction'], ['class' => \get_class($this)]);

						return null;
					}
					$order_by .= $value['direction'];
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['end'], ['class' => \get_class($this), 'query' => $order_by]);
					break;
				case 'limit':
					if (!\is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['not_array'], ['class' => \get_class($this)]);
					}
					if (!(\is_numeric($value['offset']) && \is_numeric($value['number'])))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['invalid'], ['class' => \get_class($this)]);

						return null;
					}
					$limit_by = 'LIMIT ' . $value['number'] . ' OFFSET ' . $value['offset'];
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['end'], ['class' => \get_class($this), 'query' => $limit_by]);
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['unkwnown_key'], ['class' => \get_class($this), 'key' => $key]);

					return null;
			}
		}

		$query = $group_by . ' ' . $order_by . ' ' . $limit_by;
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['end'], ['class' => \get_class($this), 'query' => $query]);

		return $query;
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
	 * Convert an association operation/value to an association attributes/(operation with value)
	 *
	 * @param array $values
	 *
	 * @param string|array $operations Default to '='
	 *
	 * @return array|null
	 *//**
	public function conditionCreator(array $values, array|string $operations = null) : ?array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['start'], ['class' => \get_class($this)]);

		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['no_values'], ['class' => \get_class($this)]);

			return null;
		}

		if ($operations === null)
		{
			$operations = '=';
		}

		if (!is_array($operations)) // one operation to every attribute
		{
			$operations = \array_fill_keys(\array_keys($values), $operations);
		}

		$results = [];

		foreach ($values as $name => $value)
		{
			if ($operations[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['missing_operation'], ['class' => \get_class($this), 'attribute' => $name]);

				return null;
			}
			switch ($operations[$name]) // Whitelist
			{
				case '=':
				case '!=':
				case '<>':
				case '<':
				case '>':
				case '<=':
				case '>=':
					$results[$name] = $name . $operations[$name] . '?';
					break;
				case 'IN':
					/* IN is a special case, more complex than the other, values will change */
					/**if (\count($value) === 0) // $value is the array of value that $name can takes
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['empty'], ['class' => \get_class($this), 'attribute' => $name]);

						return null;
					}
					$results[$name] = $name . ' IN (' . \implode(', ', \array_fill(0, \count($value), '?'));

					/* There are now \count($value) new "?" (value to enter). These must be at the good position
					 * \array_map('strval', \array_keys($values)) is a solution to avoid casting string to integer
					 * (see https://www.php.net/manual/function.array-search.php#122377)*//**
					$values = \array_splice($values, \array_search($name, \array_map('strval', \array_keys($values))), 1, $value);
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['not_in_whitelist'], ['class' => \get_class($this), 'operation' => $operations[$name]]);

					return null;
			}
		}

		return [$results, $values];
	}
	/**
	 * count all entries of the table
	 *
	 * @return int
	 */
	public function count() : int
	{
		$QC = new \database\QueryConstructor();

		$QC->select('COUNT', $this::TABLE, alias: 'nbr', is_function: True, function_parameter: $this::INDEX[0]);

		$QC->from($this::TABLE);

		return (int) $QC->run()[0]['nbr'];
	}
	/**
	 * Count all entries of the table
	 *
	 * @return int
	 *//**
	public function count() : int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['count'], ['class' => \get_class($this)]);

		$request = $this->db->prepare('SELECT count(' . \implode(', ', $this::INDEX) . ') AS nbr FROM ' . $this::TABLE);
		$request->execute();

		$data = $request->fetch(\PDO::FETCH_ASSOC);
		return (int)$data['nbr'];
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

		$QC = new \database\QueryConstructor();

		$QC->select('COUNT', $this::TABLE, alias: 'nbr', is_function: True, function_parameter: $this::INDEX[0]);

		$QC->from($this::TABLE);

		$wheres = [];
		$operation = $operations;
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

		return (int) $QC->run()[0]['nbr'];
	}
	/**
	 * Count all entries which comply with a condition
	 *
	 * @param array $values Name => value of attributes
	 *
	 * @param array|string $conditions Name => operator / operator
	 *
	 * @return int
	 *//**
	public function countBy(array $values, array|string $conditions = null) : int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['start'], ['class' => \get_class($this)]);

		$values = $this->cleanAttributes($values);

		if (\count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['values'], ['class' => \get_class($this)]);

			return 0;
		}

		$condition = $this->conditionCreator($values, $conditions);

		$query = 'SELECT count(' . \implode(', ', $this::INDEX) . ') AS nbr FROM ' . $this::TABLE . ' WHERE ' . \implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values($condition[1]));

		$data = $request->fetch(\PDO::FETCH_ASSOC);
		return (int)$data['nbr'];
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

		$QC = new \database\QueryConstructor();

		$wheres = [];
		foreach ($this::ATTRIBUTES as $name)
		{
			$QC->select($name, $this::TABLE);

			if (\key_exists($name, $index))
			{
				$wheres[] = $QC->exp()->col($name, $this::TABLE)
					                  ->param($index[$name])
								      ->op('=')
								      ->end();
			}
		}

		$QC->from($this::TABLE);

		$QC->where($QC->exp()->and(...$wheres)->end());

		return $QC->run()[0];
	}
	/**
	 * Get the result of a sql request from an index
	 *
	 * @param array $index
	 *
	 * @return array
	 *//**
	public function get(array $index) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['get']['start'], ['class' => \get_class($this)]);

		$indexes = [];
		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['get']['missing_index'], ['class' => \get_class($this), 'attribute' => $name]);

				return [];
			}
			$indexes[] = $name . '=?';
		}

		$attributes = [];
		foreach ($this::ATTRIBUTES as $attribute)
		{
			if (\in_array(\strtoupper($attribute), $this::RESERVED_KEYWORD))
			{
				$attributes[] = '`' . $attribute . '`';
			}
			else
			{
				$attributes[] = $attribute;
			}
		}

		$query = 'SELECT ' . \implode(', ', $attributes) . ' FROM ' . $this::TABLE . ' WHERE ' . \implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['get']['end'], ['class' => \get_class($this), 'query' => $query]);

		$request = $this->db->prepare($query);
		$request->execute(\array_values($index));

		return $request->fetch(\PDO::FETCH_ASSOC);
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

		$QC = new \database\QueryConstructor();

		$operation = $operations;
		$wheres = [];
		foreach ($this::ATTRIBUTES as $name)
		{
			$QC->select($name, $this::TABLE);

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

				$wheres[] = $QC->exp()->col($name, $this::TABLE)
								   ->param($values[$name])
								   ->op($operation)
								   ->end();
			}
		}


		$QC->from($this::TABLE);
		$QC->where($QC->exp()->and(...$wheres)->end());

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

			foreach ($order_by as $name => $direction)
			{
				$QC->orderBy($name, $this::TABLE, $direction);
			}

		}

		if ($limit !== null)
		{
			if (\is_int($limit))
			{
				$limit = [$limit];
			}

			if (empty($limit))
			{
				throw new \Exception();
			}

			$QC->limit(...$limit);
		}

		return $QC->run();
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
