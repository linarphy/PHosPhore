<?php

namespace database;

/**
 * tool to construct query
 */
class QueryConstructor
{
	use \core\Base;

	/**
	 * current query in construction
	 *
	 * @var \database\parameter\Query
	 */
	protected \database\parameter\Query $query;
	/**
	 * next position for parameter in expressions
	 *
	 * @var int
	 */
	protected int $position = 0;
	/**
	 * current query type
	 *
	 * @var \database\QueryTypes
	 */
	protected \database\QueryTypes $type;
	/**
	 * help function to build a column
	 *
	 * @param string $name Attribute name of function if isFunction is true.
	 *
	 * @param string $table Table name or alias.
	 *
	 * @param ?string $alias Column alias.
	 *                       Default to null.
	 *
	 * @param ?bool $is_function If $name is a function.
	 *                           Default to False.
	 *
	 * @param ?string $function_parameter Function parameter. Must be null if $is_function is False.
	 *                                    Default to null.
	 *
	 * @return \database\parameter\Column
	 */
	public function buildColumn(string $name, string $table, ?string $alias = null, ?bool $is_function = False, ?string $function_parameter = null) : \database\parameter\Column
	{
		if (!$is_function && $function_parameter !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['buildColumn']['cannot_parameter'], ['name' => $name, 'parameter' => $function_parameter]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['buildColumn']['cannot_parameter']);
		}

		if (empty($table))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['buildColumn']['empty_table'], ['name' => $name]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['buildColumn']['empty_table']);
		}

		if (empty($name))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['buildColumn']['empty_name'], ['table' => $table]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['buildColumn']['empty_name']);
		}

		$Column = new \database\parameter\Column([
			'attribute' => new \database\parameter\Attribute([]),
		]);

		if ($is_function)
		{
			$Column->set('function', $name);

			if ($function_parameter !== null && !empty($function_parameter))
			{
				$Column->get('attribute')->set('name', $function_parameter);
			}
			else
			{
				$Column->get('attribute')->set('name', '');
			}
		}
		else
		{
			$Column->get('attribute')->set('name', $name);
		}

		if ($alias !== null && !empty($alias))
		{
			$Column->set('alias', $alias);
		}

		if ($Column->get('attribute') !== null)
		{
			$Column->get('attribute')->set('table', $this->findTable($table));
		}

		return $Column;
	}
	/**
	 * create a delete statement
	 *
	 * @param string $name
	 *
	 * @param ?string $alias
	 *
	 * @return self
	 */
	public function delete(string $name, ?string $alias = null) : self
	{
		if ($this->get('type') === null) // first select statement
		{
			$this->set('type', \database\QueryTypes::delete);
		}
		else if ($this->get('type') !== \database\QueryTypes::delete)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['delete']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['delete']['bad_type']);
		}
		else if ($this->get('query') === null) // SHOULD NEVER HAPPEN (we now it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['delete']['null_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['delete']['null_query']);
		}

		$Table = new \database\parameter\Table([
			'name' => $name,
		]);

		if ($alias !== null && !empty($alias))
		{
			$Table->set('alias', $alias);
		}

		$this->set('query', new \database\request\Delete([
			'delete' => $Table,
		]));

		return $this;
	}
	/**
	 * end the constructor (return the query associated or null if none
	 *
	 * @return ?\database\parameter\Query
	 */
	public function end() : ?\database\parameter\Query
	{
		if ($this->get('query') !== null)
		{
			return $this->get('query');
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['QueryConstructor']['end']['query']);
	}
	/**
	 * alias for expression
	 *
	 * @return \database\ExpressionConstructor
	 */
	public function exp() : \database\ExpressionConstructor
	{
		return $this->expression();
	}
	/**
	 * tool to create an expression for this query
	 *
	 * @return \database\ExpressionConstructor
	 */
	public function expression() : \database\ExpressionConstructor
	{
		return new \database\ExpressionConstructor([
			'query_constructor' => $this,
		]);
	}
	/**
	 * find or create a table in the query
	 *
	 * @param string $table Table name
	 *
	 * @param ?string $alias Table alias. Default to null.
	 *
	 * @return \database\parameter\Table
	 */
	public function findTable(string $table, ?string $alias = null) : \database\parameter\Table
	{
		/* search in from */
		if ($this->get('query') !== null && $this->get('type') === \database\QueryTypes::select && $this->get('query')->get('from') !== null)
		{
			if
			(
				(
					$alias === null &&
					(
						$this->get('query')->get('from')->get('name') === $table ||
						$this->get('query')->get('from')->get('alias') === $table
					)
				) ||
				(
					$alias !== null &&
					$this->get('query')->get('from')->get('name') === $table &&
					$this->get('query')->get('from')->get('alias') === $alias
				)
			)
			{
				return $this->get('query')->get('from');
			}
		}
		/* search in joins */
		if ($this->get('query') !== null && $this->get('type') === \database\QueryTypes::select && $this->get('query')->get('joins') !== null)
		{
			foreach ($this->get('query')->get('joins') as $join)
			{
				if
				(
					(
						$alias === null &&
						(
							$join->get('table')->get('name') === $table ||
							$join->get('table')->get('alias') === $table
						)
					) ||
					(
						$alias !== null &&
						$join->get('table')->get('name') === $table &&
						$join->get('table')->get('alias') === $alias
					)
				)
				{
					return $join->get('table');
				}
			}
		}
		/* search in other select */
		if ($this->get('query') !== null && $this->get('type') === \database\QueryTypes::select && !empty($this->get('query')->get('select')))
		{
			foreach ($this->get('query')->get('select') as $selected_column)
			{
				if
				(
					$selected_column->get('attribute') !== null && // stop here if it does not so attribute can be used later
					(
						$alias === null &&
						(
							$selected_column->get('attribute')->get('table')->get('name') === $table ||
							$selected_column->get('attribute')->get('table')->get('alias') === $table
						)
					) ||
					(
						$alias !== null &&
						$selected_column->get('attribute')->get('table')->get('name') === $table &&
						$selected_column->get('attribute')->get('table')->get('alias') === $alias
					)
				)
				{
					return $selected_column->get('attribute')->get('table');
				}
			}
		}
		/* if no table has been retrieved */
		$Table = new \database\parameter\Table([
			'name' => $table,
		]);

		if ($alias !== null && !empty($alias)) // the empty case is only here because it shouldn't be possible to see it elsewhere
		{
			$Table->set('alias', $alias);
		}

		return $Table;
	}
	/**
	 * set the select query as distinct
	 *
	 * @return self
	 */
	public function distinct() : self
	{
		$this->get('query')->set('distinct', True);

		return $this;
	}
	/**
	 * add from part to the query
	 *
	 * @param string $name Table name
	 *
	 * @param ?string $alias Table alias. Default to null.
	 *
	 * @return self
	 */
	public function from(string $name, ?string $alias = null) : self
	{
		if ($this->get('type') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['from']['null_type']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['null_type']);
		}

		if (!\in_array($this->get('type'), [\database\QueryTypes::delete, \database\QueryTypes::select])) // only accepted for these request
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['from']['bad_type'], ['type' => $type]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['bad_type']);
		}

		if (empty($name))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['from']['empty_name']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['empty_name']);
		}

		$Table = new \database\parameter\Table([
			'name' => $name,
		]);

		if ($alias !== null && !empty($alias))
		{
			$Table->set('alias', $alias);
			$Table = $this->findTable($Table->get('name'), $Table->get('alias'));
			$this->updateTable($Table);
		}
		else
		{
			$Table = $this->findTable($Table->get('name'));
		}

		$this->get('query')->set('from', $Table);

		return $this;
	}
	/**
	 * add group by part to the query
	 *
	 * @param ...string $attributes
	 *
	 * @return self
	 */
	public function groupBy(string ...$attributes) : self
	{
		if (empty($attributes))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['QueryConstructor']['groupBy']['empty']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['groupBy']['empty']);
		}

		foreach ($attributes as $key => $value)
		{
			if ($key % 2 === 0) // it's an attribute name
			{
				$attributes[$key] = new \database\parameter\Attribute([
					'name'  => $value,
					'table' => $this->findTable($attributes[$key + 1]),
				]);
			}
			else // it's a table name
			{
				unset($attributes[$key]);
			}
		}

		$GroupBy = new \database\parameter\GroupBy([
			'attributes' => $attributes,
		]);

		$this->get('query')->set('groupBy', $GroupBy);

		return $this;
	}
	/**
	 * add having part to the query
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @return self
	 */
	public function having(\database\parameter\Expression $expression) : self
	{
		$this->get('query')->set('having', $expression);

		return $this;
	}
	/**
	 * create an insert statement
	 *
	 * @param string $name
	 *
	 * @param ?string $alias
	 *
	 * @return self
	 */
	public function insert(string $name) : self
	{
		if ($this->get('type') === null) // first select statement
		{
			$this->set('type', \database\QueryTypes::insert);
		}
		else if ($this->get('type') !== \database\QueryTypes::insert)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['insert']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['insert']['bad_type']);
		}
		else if ($this->get('query') === null) // SHOULD NEVER HAPPEN (we now it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['insert']['null_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['insert']['null_query']);
		}

		$this->set('query', new \database\request\Insert([
			'table' => new \database\parameter\Table([
				'name' => $name,
			]),
		]));

		return $this;
	}
	/** add a join to the query
	 *
	 * @param string|\database\parameter\JoinTypes $type
	 *
	 * @param string|\database\parameter\Query $table name of the table or subquery
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @param ?string $alias
	 *
	 * @return self
	 */
	public function join(string|\database\parameter\JoinTypes $type, string|\database\parameter\Query $table, \database\parameter\Expression $expression, ?string $alias = null) : self
	{
		$joins = [];

		if ($this->get('query')->get('joins') !== null && !empty($this->get('query')->get('joins')))
		{
			$joins = $this->get('query')->get('joins');
		}

		$Join = new \database\parameter\Join([]);

		if (\is_string($type))
		{
			$type = \database\parameter\JoinTypes::tryFrom($type);
			if ($type === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['join']['unknown_type'], ['type' => $type]);
				throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['join']['unknown_type']);
			}
		}

		$Join->set('type', $type);

		if (\is_string($table))
		{
			$Table = new \database\parameter\Table([
				'name' => $table,
			]);

			if ($alias !== null && !empty($alias))
			{
				$Table->set('alias', $alias);
				$Table = $this->findTable($Table->get('name'), $Table->get('alias'));
				$this->updateTable($Table);
			}
			else
			{
				$Table = $this->findTable($Table->get('name'));
			}
		}
		else // subquery
		{
			$Table = $table;

			if ($alias !== null && !empty($alias))
			{
				$Join->set('subquery_alias', $alias);
			}
		}

		$Join->set('table', $Table);
		$Join->set('expression', $expression);

		$joins[] = $Join;
		$this->get('query')->set('joins', $joins);

		return $this;
	}
	/**
	 * add limits to the query
	 *
	 * @param int $count
	 *
	 * @param ?int $offset
	 *
	 * @return self
	 */
	public function limit(int $count, ?int $offset) : self
	{
		$Limit = new \database\parameter\Limit([
			'count' => $count,
		]);

		if ($offset !== null)
		{
			$Limit->set('offset', $offset);
		}

		$this->get('query')->set('limit', $Limit);

		return $this;
	}
	/**
	 * add orderBy part to the query
	 *
	 * @param string $name
	 *
	 * @param string $table
	 *
	 * @param string|\database\parameter\OrderByTypes $type
	 *
	 * @return self
	 */
	public function orderBy(string $name, string $table, null|string|\database\parameter\OrderByTypes $type = null, ?bool $is_function = False, ?string $function_parameter = null) : self
	{
		$list_order = [];

		if ($this->get('query')->get('orderBy') !== null)
		{
			if ($this->get('query')->get('orderBy')->get('order_by') === null) // should never happens (why do you read this)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['orderBy']['badformed']);
				throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['orderBy']['badformed']);
			}

			$list_order = $this->get('query')->get('orderBy');
		}

		$OrderBy = new \database\parameter\OrderBy([
			'column' => $this->buildColumn($name, $table, is_function: $is_function, function_parameter: $function_parameter),
		]);

		if (\is_string($type))
		{
			$type = \database\parameter\OrderByTypes::tryForm($type);
			if ($type === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['orderBy']['unknown_type'], ['type' => $type]);
				throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['orderBy']['unknown_type']);
			}
		}

		$OrderBy->set('type', $type);

		$list_order[] = $OrderBy;

		$this->get('query')->set('orderBy', new \database\parameter\OrderBy([
			'order_by' => $list_order,
		]));

		return $this;
	}
	/**
	 * update the table already set in the query
	 *
	 * @param \database\parameter\Table $table
	 *
	 * @return int Number of table updated
	 */
	public function updateTable(\database\parameter\Table $table) : int
	{
		$count = 0;
		if ($table->get('alias') === null) // Table is like a string
		{
			return $count;
		}
		/* search in from */
		if ($this->get('query')->get('from') !== null)
		{
			if
			(
				$this->get('query')->get('from')->get('name') === $table->get('name') &&
				$this->get('query')->get('from')->get('alias') !== $table->get('alias')
			)
			{
				$this->get('query')->get('from')->set('alias', $table->get('alias'));
				$count += 1;
			}
		}
		/* search in joins */
		if ($this->get('query')->get('joins') !== null)
		{
			foreach ($this->get('query')->get('joins') as $join)
			{
				if
				(
					$join->get('table')->get('name') === $table->get('name') &&
					$join->get('table')->get('alias') !== $table->get('alias')
				)
				{
					$join->get('table')->set('alias', $table->get('alias'));
					$count += 1;
				}
			}
		}
		/* search in select */
		if (!empty($this->get('query')->get('select')))
		{
			foreach ($this->get('query')->get('select') as $selected_column)
			{
				if
				(
					$selected_column->get('attribute') !== null && // stop here if it does not so attribute can be used later
					(
						$selected_column->get('attribute')->get('table')->get('name') === $table->get('name') &&
						$selected_column->get('attribute')->get('table')->get('alias') !== $table->get('alias')
					)
				)
				{
					$selected_column->get('attribute')->get('table')->set('alias', $table->get('alias'));
					$count += 1;
				}
			}
		}

		return $count;
	}
	/**
	 * retrieve parameters for where & having part
	 *
	 * @return array
	 */
	public function retrieveParameters() : array
	{
		$parameters = [];
		if ($this->get('type') === \database\QueryTypes::insert && $this->get('query')->get('values') !== null)
		{
			$temp = [];

			foreach ($this->get('query')->get('values') as $value)
			{
				if (\get_class($value) === 'database\\parameter\\Parameter')
				{
					$temp[] = $value;
				}
			}

			$parameters = \array_merge($parameters, $temp);
		}
		if ($this->get('type') === \database\QueryTypes::update && $this->get('query')->get('sets') !== null)
		{
			$temp = [];

			foreach ($this->get('query')->get('sets')['values'] as $value)
			{
				if (\get_class($value) === 'database\\parameter\\Parameter')
				{
					$temp[] = $value;
				}
			}

			$parameters = \array_merge($parameters, $temp);
		}
		if (
			(
				$this->get('type') === \database\QueryTypes::delete ||
				$this->get('type') === \database\QueryTypes::select ||
				$this->get('type') === \database\QueryTypes::update
			) && $this->get('query')->get('where') !== null)
		{
			$parameters = \array_merge($parameters, $this->get('query')->get('where')->retrieveParameters());
		}
		if ($this->get('type') === \database\QueryTypes::select && $this->get('query')->get('having') !== null)
		{
			$parameters = \array_merge($parameters, $this->get('query')->get('having')->retrieveParameters());
		}

		$results = [];
		foreach ($parameters as $parameter)
		{
			if ($parameter->get('placeholder') === null)
			{
				$results[$parameter->get('position')] = $parameter->get('value');
			}
			else
			{
				$results[$parameter->get('placeholder')] = $parameter->get('value');
			}
		}
		return $results;
	}
	/**
	 * create a select statement or update it
	 *
	 * @param string $name Attribute name of function if isFunction is true.
	 *
	 * @param string $table Table name or alias.
	 *
	 * @param ?string $alias Column alias.
	 *                       Default to null.
	 *
	 * @param ?bool $is_function If $name is a function.
	 *                           Default to False.
	 *
	 * @param ?string $function_parameter Function parameter. Must be null if $is_function is False.
	 *                                    Default to null.
	 *
	 * @return self
	 */
	public function select(string $name, string $table, ?string $alias = null, ?bool $is_function = False, ?string $function_parameter = null) : self
	{
		if ($this->get('type') === null) // first select statement
		{
			$this->set('type', \database\QueryTypes::select);

			$this->set('query', new \database\request\Select([
				'select' => [],
			]));
		}
		else if ($this->get('type') !== \database\QueryTypes::select)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['select']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['select']['bad_type']);
		}
		else if ($this->get('query') === null) // SHOULD NEVER HAPPEN (we now it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['select']['null_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['select']['null_query']);
		}

		$this->get('query')->set(
			'select',
			\array_merge(
				$this->get('query')->get('select'),
				[$this->buildColumn($name, $table, $alias, $is_function, $function_parameter)],
			),
		);

		return $this;
	}
	/**
	 * put another attribute => value in the sets to the query
	 *
	 * @param string $name
	 *
	 * @param string $value
	 *
	 * @param ?string $placeholder
	 *
	 * @return self
	 */
	public function put(string $name, mixed $value, ?string $placeholder = null) : self
	{
		$values = [];
		$attributes = [];

		if ($this->get('query')->get('sets') !== null && !empty($this->get('query')->get('sets')))
		{
			$values = $this->get('query')->get('sets')['values'];
			$attributes = $this->get('query')->get('sets')['attributes'];
		}

		$Parameter = new \database\parameter\Attribute([
			'name'  => $name,
			'table' => $this->get('query')->get('table'),
		]);
		$Value = new \database\parameter\Parameter([
			'value' => $value,
		]);

		if ($placeholder !== null && !empty($placeholder))
		{
			$Value->set('placeholder', $placeholder);
		}
		else
		{
			$Value->set('position', $this->get('position'));
			$this->set('position', $this->get('position') + 1);
		}

		$attributes[] = $Parameter;
		$values[] = $Value;

		$this->get('query')->set('sets', [
			'values'     => $values,
			'attributes' => $attributes,
		]);

		return $this;
	}
	/**
	 * run the query
	 *
	 * @return array
	 */
	public function run() : array
	{
		if ($this->get('type') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['run']['no_type']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['run']['no_type']);
		}
		if ($this->get('query') === null) // should never happend (of course it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['run']['no_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['run']['no_query']);
		}

		$connection = \core\DBFactory::connection();

		if (!\in_array(\strtoupper($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)), \core\DBFactory::DRIVERS))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['run']['unsuported_driver'], ['driver' => $connection->getAttribute(PDO::ATTR_DRIVER_NAME)]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['run']['unsuported_driver']);
		}
		$driver_class = '\\database\\' . \ucwords(\strtolower($connection->getAttribute(\PDO::ATTR_DRIVER_NAME)));

		$request = $connection->prepare($driver_class::displayQuery($this->get('query')));
		$request->execute($this->retrieveParameters());

		return $request->fetchAll();
	}
	/**
	 * create a table statement
	 *
	 * @param string $name
	 *
	 * @return self
	 */
	public function table(string $name) : self
	{
		if ($this->get('type') === null) // first select statement
		{
			$this->set('type', \database\QueryTypes::table);
		}
		else if ($this->get('type') !== \database\QueryTypes::table)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['table']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['table']['bad_type']);
		}
		else if ($this->get('query') === null) // SHOULD NEVER HAPPEN (we now it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['table']['null_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['table']['null_query']);
		}

		$this->set('query', new \database\request\Table([
			'table' => new \database\parameter\Table([
				'name' => $name,
			]),
		]));

		return $this;
	}
	/**
	 * create an update statement
	 *
	 * @param string $name
	 *
	 * @return self
	 */
	public function update(string $name) : self
	{
		if ($this->get('type') === null) // first update statement
		{
			$this->set('type', \database\QueryTypes::update);
		}
		else if ($this->get('type') !== \database\QueryTypes::update)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['update']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['update']['bad_type']);
		}
		else if ($this->get('query') === null) // SHOULD NEVER HAPPEN (we now it will)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['update']['null_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['update']['null_query']);
		}

		$this->set('query', new \database\request\Update([
			'table' => new \database\parameter\Table([
				'name' => $name,
			]),
		]));

		return $this;
	}
	/**
	 * add a value to the query
	 *
	 * @param string $name
	 *
	 * @param string $value
	 *
	 * @param ?string $placeholder
	 *
	 * @return self
	 */
	public function value(string $name, mixed $value, ?string $placeholder = null) : self
	{
		$values = [];
		$parameters = [];

		if ($this->get('query')->get('values') !== null && !empty($this->get('query')->get('values')))
		{
			$values = $this->get('query')->get('values');
		}
		if ($this->get('query')->get('parameters') !== null && !empty($this->get('query')->get('parameters')))
		{
			$parameters = $this->get('query')->get('parameters');
		}

		$Parameter = new \database\parameter\Attribute([
			'name'  => $name,
			'table' => $this->get('query')->get('table'),
		]);
		$Value = new \database\parameter\Parameter([
			'value' => $value,
		]);

		if ($placeholder !== null && !empty($placeholder))
		{
			$Value->set('placeholder', $placeholder);
		}
		else
		{
			$Value->set('position', $this->get('position'));
			$this->set('position', $this->get('position') + 1);
		}

		$parameters[] = $Parameter;
		$values[] = $Value;

		$this->get('query')->set('values', $values);
		$this->get('query')->set('parameters', $parameters);

		return $this;
	}
	/**
	 * add where part to the query
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @return self
	 */
	public function where(\database\parameter\Expression $expression) : self
	{
		$this->get('query')->set('where', $expression);

		return $this;
	}
}

?>
