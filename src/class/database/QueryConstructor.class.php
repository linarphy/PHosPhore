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
		if (!$is_function && $function_parameter !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['select']['cannot_parameter'], ['name' => $name, 'parameter' => $function_parameter]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['select']['cannot_parameter']);
		}

		if (empty($table))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['select']['empty_table'], ['name' => $name]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['select']['empty_table']);
		}

		if (empty($name))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['QueryConstructor']['select']['empty_name'], ['table' => $table]);
			throw new \Exception($GLOBALS['locale']['class']['database']['QueryConstructor']['select']['empty_name']);
		}

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

		$this->get('query')->set(
			'select',
			\array_merge(
				$this->get('query')->get('select'),
				[$Column],
			),
		);

		return $this;
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
		if ($this->get('query')->get('from') !== null)
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
					$this->get('query')->get('from')->get('name') === $name &&
					$this->get('query')->get('from')->get('alias') === $alias
				)
			)
			{
				return $this->get('query')->get('from');
			}
		}
		/* search in joins */
		if ($this->get('query')->get('joins') !== null)
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
		if (!empty($this->get('query')->get('select')))
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
	 * add form part to the query
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
		}

		$Table = $this->findTable($Table->get('name'), $Table->get('alias'));
		$this->updateTable($Table);

		$this->get('query')->set('from', $Table);

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
				$this->get('query')->get('form')->get('name') === $table->get('name') &&
				$this->get('query')->get('form')->get('alias') !== $table->get('alias')
			)
			{
				$this->get('query')->get('form')->set('alias', $table->get('alias'));
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
		/* search in other select */
		if (!empty($this->get('query')->get('select')))
		{
			foreach ($this->get('query')->get('select') as $selected_column)
			{
				if
				(
					$selected_column->get('attribute') !== null || // stop here if it does not so attribute can be used later
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
		if ($this->get('query')->get('where') !== null)
		{
			$parameters = \array_merge($parameters, $this->get('query')->get('where')->retrieveParameters());
		}
		if ($this->get('query')->get('having') !== null)
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
