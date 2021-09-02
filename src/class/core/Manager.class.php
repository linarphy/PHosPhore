<?php

namespace core;

/**
 * Manager the connection between a PHP object and its data stored in a database
 */
class abstract Manager
{
	/**
	 * PDO database connection
	 *
	 * @var \PDO
	 */
	protected $db;
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
	const ATTRIBUTES = array();
	/**
	 * Index (primary keys)
	 *
	 * @var array
	 */
	const INDEX = array();
	/**
	 * Constructor
	 *
	 * @param mixed|null $db PDO database connection.
	 *                        If null, \core\DBConnection::MysqlConnection() will be used.
	 *                        Default to null
	 *
	 */
	public function __construct($db = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['__construct'], array('class' => get_class($this)));

		if ($db === null)
		{
			$db = \core\DBConnection::MysqlConnection();
		}

		$this->set('db', $db);
	}
	/**
	 * Add a database entry and return its index
	 *
	 * @param array $attributes
	 *
	 * @return array|bool
	 */
	public function add($attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['start'], array('class' => get_class($this)));

		$attributes = $this->cleanAttributes($attributes);

		if (count($attributes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Manager']['add']['no_attributes'], array('class' => get_class($this)));

			return False;
		}

		$query = 'INSERT INTO ' . $this::TABLE . '(' . implode(',', array_keys($attributes)) . ') VALUES (' . implode(',', array_fill(0, count($attributes), '?')) . ')';
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['query'], array('class' => get_class($this), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute(array_values($attributes));

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['add']['success'], array('class' => get_class($this)));
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
	 * @return string|False
	 */
	public static function boundaryInterpreter($bounds)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['start'], array('class' => get_class(self)));

		$group_by = '';
		$order_by = '';
		$limit_by = '';

		foreach ($bounds as $key => $value)
		{
			switch ($key)
			{
				case 'group':
					if (!is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['not_array'], array('class' => get_class(self)));

						return False;
					}
					if ($value['attribute'] === null)
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['missing_key'], array('class' => get_class(self)));

						return False;
					}
					$group_by = 'GROUP BY ' . $value['attribute'];

					if ($value['operations'] != null && $value['having'] != null)
					{
						$group_by .= ' HAVING ' . implode(' AND ', $this::conditionCreator($value['having'], $value['operations'])[0]);
					}
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['end'], array('class' => get_class(self), 'query' => $group_by));
				break;
				case 'order':
					if (!is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['not_array'], array('class' => get_class(self)));
					}
					if (!in_array($value['name'], self::ATTRIBUTES))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['unknown_name'], array('class' => get_class(self)));

						return False;
					}
					$order_by = 'ORDER BY '.$value['name'];
					if ($value['direction'] != 'ASC' && $value['direction'] != 'DESC')
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['direction'], array('class' => get_class(self)));

						return False;
					}
					$order_by .= $value['direction'];
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['end'], array('class' => get_class(self), 'query' => $order_by));
					break;
				case 'limit':
					if (!is_array($value))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['not_array'], array('class' => get_class(self)));
					}
					if (!(is_numeric($value['offset']) && is_numeric($value['number'])))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['invalid'], array('class' => get_class(self)));

						return False;
					}
					$limit_by = 'LIMIT ' . $value['number'] . ' OFFSET ' . $value['offset'];
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['end'], array('class' => get_class(self), 'query' => $limit_by));
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['unkwnown_key']], array('class' => get_class(self), 'key' => $key));

					return False;
			}
		}

		$query = $group_by . ' ' . $order_by . ' ' . $limit_by;
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['end'], array('class' => get_class(self), 'query' => $query));

		return $query;
	}
	/**
	 * Remove from an array all the element where the key is not in the array $this::ATTRIBUTES
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	public function cleanAttributes($attributes)
	{
		return array_intersect_key($attributes, array_flip($this::ATTRIBUTES));
	}
	/**
	 * Convert an association operation/value to an association attributes/(operation with value)
	 *
	 * @param array $values
	 *
	 * @param string|array $operations Default to '='
	 *
	 * @return array|False
	 */
	public static function conditionCreator($values, $operations = '=')
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['start'], array('class' => get_class(self)));

		$values = self->cleanAttributes($values);

		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['no_values'], array('class' => get_class(self)));

			return False;
		}

		if (!is_array($operations)) // one operation to every attribute
		{
			$operations = array_fill_keys(array_keys($values), $operations);
		}

		$results = array();

		foreach ($values as $name => $value)
		{
			if ($operations[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['missing_operation'], array('class' => get_class(self), 'attribute' => $name));

				return False;
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
					if (count($value) === 0) // $value is the array of value that $name can takes
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['empty'], array('class' => get_class(self), 'attribute' => $name));

						return False;
					}
					$results[$name] = $name . ' IN (' . implode(',', array_fill(0, count($value), '?'));

					/* There are now count($value) new "?" (value to enter). These must be at the good position
					 * array_map('strval', array_keys($values)) is a solution to avoid casting string to integer
					 * (see https://www.php.net/manual/function.array-search.php#122377)*/
					$values = array_splice($values, array_search($name, array_map('strval', array_keys($values))), 1, $value);
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['not_in_whitelist'], array('class' => get_class(self), 'operation' => $operations[$name]));

					return False;
			}
		}

		return [$results, $values];
	}
	/**
	 * Count all entries of the table
	 *
	 * @return int
	 */
	public function count()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['count'], array('class' => get_class($this)));

		$request = $this->db->prepare('SELECT count(' . implode(',', $this::INDEX) . ') AS nbr FROM ' . $this::TABLE);
		$request->execute();

		$data = $request->fetch(\PDO::FETCH_ASSOC);
		return (int)$data['nbr'];
	}
	/**
	 * Count all entries which comply with a condition
	 *
	 * @param array $values Name => value of attributes
	 *
	 * @param array|string $conditions Name => operator / operator
	 *
	 * @return int
	 */
	public function countBy($values, $conditions = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['start'], array('class' => get_class($this)));

		$values = $this->cleanAttributes($values);

		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['values'], array('class' => get_class($this)));

			return 0;
		}

		$condition = $this::conditionCreator($values, $conditions);

		$query = 'SELECT count(' . implode(',', $this::INDEX) . ') AS nbr FROM ' . $this::TABLE . ' WHERE ' . implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['countBy']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute($condition[1]);

		$data = $request->fetch(\PDO::FETCH_ASSOC);
		return (int)$data['nbr'];
	}
	/**
	 * Delete an entry
	 *
	 * @param array $index Index of the entry
	 *
	 * @return bool
	 */
	public function delete($index)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['delete']['start'], array('class', get_class($this)));

		$indexes = array();
		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['delete']['missing_index'], array('class' => get_class($this), 'attribute' => $name));

				return False;
			}
			$indexes[] = $name .= '=?';
		}

		$query = 'DELETE FROM ' . $this::TABLE . ' WHERE ' . implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['delete']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute();

		return True;
	}
	/**
	 * Delete entries which comply with a condition
	 *
	 * @param array $values Name => value of attributes
	 *
	 * @param array|string $conditions Name => operator / operator
	 *
	 * @return int Number of deleted entries
	 */
	public function deleteBy($values, $conditions = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['start'], array('class' => get_class($this)));

		$values = $this->cleanAttributes($values);

		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['values'], array('class' => get_class($this)));

			return 0;
		}

		$number = $this->countBy($values, $conditions);

		$condition = $this::conditionCreator($values, $conditions);

		$query = 'DELETE FROM ' . $this::TABLE . 'WHERE ' . implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['deleteBy']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute($operation[1]);

		return $number;
	}
	/**
	 * Check the existence of an entry with a given index
	 *
	 * @param array $index
	 *
	 * @return bool
	 */
	public function exist($index)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['exist']['start'], array('class' => get_class($this)));

		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['exist']['missing_index'], array('class' => get_class($this), 'attribute' => $name));

				return False;
			}
		}
		$number = $this->countBy($index);
		if ($number > 1)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Manager']['exist']['more_one_index'], array('class' => get_class($this), 'number' => $number));
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
	public function existBy($values, $operations = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['existBy'], array('class' => get_class($this)));
		return $this->countBy($values, $operations) != 0;
	}
	/**
	 * Get the result of a sql request from an index
	 *
	 * @param array $index
	 *
	 * @return array
	 */
	public function get($index)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['get']['start'], array('class' => get_class($this)));

		$indexes = array();
		foreach ($this::INDEX as $name)
		{
			if ($index[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['get']['missing_index'], array('class' => get_class($this), 'attribute' => $name));

				return array();
			}
			$indexes[] = $name . '=?';
		}

		$query = 'SELECT ' . implode(',', $this::ATTRIBUTES) . ' FROM ' . $this::TABLE . ' WHERE ' . implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['get']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute($index);

		return $request->fetch(\PDO::FETCH_ASSOC);
	}
	/**
	 * Get results of sql request
	 *
	 * @param array $values Name => value of attribute
	 *
	 * @param array|string $operations Name => operator / operator
	 *
	 * @param array $bounds See boundaryInterpreter method for description
	 *
	 * @return array
	 */
	public function getBy($values, $operations = null, $bounds = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getBy']['start'], array('class' => get_class($this)));

		$values = $this->cleanAttributes($values);

		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['getBy']['values'], array('class' => get_class($this)));

			return False;
		}

		$operation = $this::conditionCreator($values, $operations);

		$limit = '';
		if ($bounds != null)
		{
			$limit = $this::boundaryInterpreter($bounds);
		}

		$query = 'SELECT ' . implode(',', $this::ATTRIBUTES) . ' FROM ' . $this::TABLE . $condition[0] . $limit;

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getBy']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute($condition[1]);

		return $request->fetchAll();
	}
	/**
	 * db getter
	 *
	 * @return \PDO
	 */
	public function getDb()
	{
		return $this->db;
	}
	/**
	 * Get index of entries which comply to condition
	 *
	 * @param array $values Name => value for attribute
	 *
	 * @param array|string $operations Name => operator / operator
	 *
	 * @return array
	 */
	public function getIdBy($values, $operations = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['start'], array('class' => get_class($this)));

		$values = $this->cleanAttributes($values);

		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['values'], array('class' => get_class($this)));

			return array();
		}

		$operation = $this::conditionCreator($values, $operations);

		$query = 'SELECT ' . implode(',', $this::INDEX) . ' FROM ' . $this::TABLE . $condition[0];

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdBy']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute($condition[1]);

		return $return->fetchAll();
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
	 */
	public function getIdByPos($attribute, $position = 0, $direction = 'DESC')
	{
		$GLOBALS['Logger']->get(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['start'], array('class' => get_class(self)));

		if (!is_int($position) || ($direction != 'ASC' && $direction != 'DESC') || !in_array($attribute, $this::ATTRIBUTES))
		{
			$GLOBALS['Logger']->get(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['invalid_data'], array('class' => get_class(self)));

			return array();
		}

		$query = 'SELECT ' . implode(',', $this::INDEX) . ' FROM ' . $this::TABLE . 'ORDER BY ' . $attribute . ' ' . $direction . ' LIMIT 1 OFFSET ' . $position;

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['end'], array('class' => get_class(self), 'query' => $query));

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
	public function getNextId()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['getNextId'], array('class' => get_class($this)));

		$results = array();
		foreach ($this::INDEX as $name)
		{
			$results[$name] = $this->getIdByPos($name, 0, 'ASC')[$name];
			if (is_numeric($results[$name]))
			{
				$results[$name] = (int) $results[$name] + 1;
			}
		}
		return $results
	}
	/**
	 * Create an instance of the \core\Managed class associated to this one
	 *
	 * @param array $table Array for hydratation
	 *
	 * @return mixed
	 */
	public function managed($table)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['managed']['start'], array('class' => get_class($this)));

		$managed = substr(get_class($this), 0, -7);
		if (!class_exists($managed))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['managed']['not_defined'], array('class' => get_class($this), 'managed' => $managed));

			return False;
		}

		return new $managed($table);
	}
	/**
	 * Retrieves directly objects which comply to a condition
	 *
	 * @param array $values Name => value of attribute
	 *
	 * @param array|string $operations Name => operator / operator
	 *
	 * @param array $bounds See boundaryInterpreter method for description of this array
	 *
	 * @param string $class_name Class name if different (LinkManager for example)
	 *
	 * @param array $attributes_conversion Convert attribute name if custom class. For example: array('id_route' => 'id') convert id_route attribute to id to retrieve \route\Route object
	 *
	 * @return array
	 */
	public function retrieveBy($values, $operations = null, $bounds = null, $class_name= '', $attributes_conversion = array())
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['start'], array('class' => get_class($this)));

		$results = $this->getBy($values, $operations, $bounds);
		$Objects = array();

		if ($class_name === '')
		{
			foreach ($results as $result)
			{
				$Objects[] = $this->managed($result);
			}
		}
		else
		{
			if (!class_exists($class_name))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_not_defined'], array('class' => get_class(self), 'managed' => $class_name));

				return False;
			}

			$class_manager_name = $class_name . 'Manager';
			if (!class_exists($class_manager_name))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_manager_not_defined'], array('class' => get_class(self), 'manager' => $class_manager_name));

				return False;
			}

			$manager = new $class_manager_name();

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
							unset $result[$key];
						}
					}
					$Objects[] = $manager->retrieveBy($result);
				}
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['end'], array('class' => get_class(self)));

		return $Objects;
	}
	/**
	 * db setter
	 *
	 * @param \PDO $db PDO connection to the database
	 */
	protected function setDb($db)
	{
		if ($db instanceOf \PDO)
		{
			$this->db = $db;
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['setDb'], array('class' => get_class(self)));
		}
	}
	/**
	 * Update an entry
	 *
	 * @param array $values New values
	 *
	 * @param array $index Index of the entry
	 *
	 * @return bool
	 */
	public function update($values, $index)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['update']['start'], array('class' => get_class(self)));

		$indexes = array();
		foreach ($this::INDEX as $name)
		{
			if ($values[$name] === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['update']['missing_index'], array('class' => get_class(self), 'attribute' => $name));

				return False;
			}
			$indexes[] = $name . '=?';
		}

		$values = $this->cleanAttributes($values);
		if (count($values) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['update']['values'], array('class' => get_class(self)));

			return False;
		}

		$condition = $this::conditionCreator($index, '=');

		$query = 'UPDATE ' . $this::TABLE  . ' SET ' . implode(',', $condition[0]) . ' WHERE ' . implode(' AND ', $indexes);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['update']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute(array_merge($condition[1], $index));

		return True;
	}
	/**
	 * Update entries which comply to condition
	 *
	 * @param array $values_get Name => value for non updated entries
	 *
	 * @param array $values_update Name => value for updated entries
	 *
	 * @param array|string $operations Name => operator / operator
	 *
	 * @return int Number of updated values
	 */
	public function updateBy($values_get, $values_update, $operations = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['updateBy']['start'], array('class' => get_class(self)));

		$values_get = $this->cleanAttributes($values_get);
		$values_update = $this->cleanAttributes($values_update);

		if (count($values_get) === null || count($values_update) === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Manager']['updateBy']['values'], array('class' => get_class(self)));

			return 0;
		}

		$number = $this->countBy($values_get, $operations);

		$condition_update = $this::conditionCreator($values_update, '=');
		$condition = $this::conditionCreator($values_get, $operations);

		$query = 'UPDATE ' . $this::TABLE . ' SET ' . implode(',', $condition_update[0]) . ' WHERE ' . implode(' AND ', $condition[0]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Manager']['Manager']['update']['end'], array('class' => get_class(self), 'query' => $query));

		$request = $this->db->prepare($query);
		$request->execute(array_merge(array_values($values_update), $values_get));

		return $number;
	}
}

?>
