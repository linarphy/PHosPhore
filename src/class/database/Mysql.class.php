<?php

namespace database;

/**
 * mysql tools
 */
class Mysql
{
	/**
	 * accepted operators
	 *
	 * @var array
	 */
	const OPERATORS = [
		'=',
		'>=',
		'>',
		'<=',
		'<',
		'<>',
		'!=',
		'<=>',
		'NOT',
		'IS NOT NULL',
		'IS NULL',
	];
	/**
	 * accepted sub operator (for subquery)
	 *
	 * @var array
	 */
	const SUB_OPERATORS = [
		'ANY',
		'IN',
		'SOME',
		'ALL',
	];
	/**
	 * display alias for mysql query
	 *
	 * @param string $alias
	 *
	 * @return string
	 */
	public static function displayAlias(string $alias) : string
	{
		return '`' . $alias . '`';
	}
	/**
	 * display attribute for mysql query
	 *
	 * @param \database\parameter\Attribute $attribute
	 *
	 * @return string
	 */
	public static function displayAttribute(\database\parameter\Attribute $attribute) : string
	{
		return self::displayTable($attribute->get('table')) . '.`' . $attribute->display('name') . '`';
	}
	/**
	 * display attributes for mysql query
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public static function displayAttributes(array $attributes) : string
	{
		foreach ($attributes as $key => $attribute)
		{
			$attributes[$key] = self::displayAttribute($attribute);
		}
		return \implode(', ', $attributes);
	}
	/**
	 * display column for mysql query
	 *
	 * @param \database\parameter\Column $column
	 *
	 * @param bool $alias If alias must be used.
	 *                    Default to False.
	 *
	 * @return string
	 */
	public static function displayColumn(\database\parameter\Column $column, bool $alias = False) : string
	{
		$display = '';

		if ($column->get('alias') !== null && $alias)
		{
			return self::displayAlias($column->get('alias'));
		}

		if ($column->get('attribute') !== null) // can be false if some function are used (like RAND)
		{
			$display .= self::displayAttribute($column->get('attribute'));
		}

		if ($column->get('function') !== null)
		{
			$display = $column->display('function') . '(' . $display . ')';
		}

		if ($display !== '')
		{
			return $display;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['Mysql']['displayColumn']['nothing']);
		throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayColumn']['nothing']);
	}
	/**
	 * display delete part for mysql query
	 *
	 * @param \database\parameter\Table $table
	 *
	 * @return string
	 */
	public static function displayDelete(\database\parameter\Table $table) : string
	{
		$display = self::displayTable($table, False);

		if ($table->get('alias') !== null)
		{
			return $display . ' AS ' . self::displayAlias($table->get('alias'));
		}

		return $display;
	}
	/**
	 * display distinct part for mysql query
	 *
	 * @param bool $distinct
	 *
	 * @return string
	 */
	public static function displayDistinct(bool $distinct) : string
	{
		return $distinct ? 'DISTINCT' : '';
	}
	/**
	 * display expression for mysql query
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @return
	 */
	public static function displayExpression(\database\parameter\Expression $expression) : string
	{
		if ($expression->get('type') === \database\parameter\ExpressionTypes::COMP) // comparison mode
		{
			if (\count($expression->get('values')) < 1)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['little_values'], ['number' => \count($expression->get('values'))]);
				throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['little_values']);
			}

			if (\count($expression->get('values')) > 2)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['big_values'], ['number' => \count($expression->get('values'))]);
				throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['big_values']);
			}

			if (!($expression->get('sub_operator') === null XOR $expression->get('operator') === null)) // one of it should be null when the other should not
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['impossible_operator'], ['operator' => $expression->get('operator'), 'sub_operator' => $expression->get('sub_operator')]);
				throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['impossible_operator']);
			}

			if ($expression->get('sub_operator') !== null) // there is a subquery
			{
				if (!$expression->get('sub_operator')->check(self::SUB_OPERATORS))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['bad_sub_operator'], ['sub_operator' => $expression->get('sub_operator')]);
					throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['bad_sub_operator']);
				}

				$display = '';
				$containQuery = False;

				foreach ([$expression->get('values')[0], $expression->get('sub_operator'), $expression->get('values')[1]] as $value)
				{
					switch (\get_class($value))
					{
						case 'database\\parameter\\Column':
							$display .= self::displayColumn($value) . ' ';
							break;
						case 'database\\parameter\\Parameter':
							$display .= self::displayParameter($value) . ' ';
							break;
						case 'database\\parameter\\SubOperator':
							$display .= $value->display() . ' ';
							break;
						default:
							if (\is_subclass_of(\get_class($value), 'database\\parameter\\Query'))
							{
								$containQuery = True;
								$display .= '(' . self::displayQuery($value) . ') ';
								break;
							}
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['bad_type'], ['class' => \get_class($value)]);
							throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['bad_type']);
							break;
					}
				}

				if (!$containQuery)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['no_query']);
					throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['no_query']);
				}

				return \substr($display, 0, -1); // remove the last space
			}
			else
			{
				if (!$expression->get('operator')->check(self::OPERATORS))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['bad_operator'], ['operator' => $expression->get('operator')]);
					throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['bad_operator']);
				}

				$display = '';

				foreach ([$expression->get('values')[0], $expression->get('operator'), $expression->get('values')[1]] as $value)
				{
					switch (\get_class($value))
					{
						case 'database\\parameter\\Column':
							$display .= self::displayColumn($value) . ' ';
							break;
						case 'database\\parameter\\Parameter':
							$display .= self::displayParameter($value) . ' ';
							break;
						case 'database\\parameter\\Operator':
							$display .= $value->display() . ' ';
							break;
						default:
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayExpression']['bad_type'], ['class' => \get_class($value)]);
							throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayExpression']['bad_type']);
							break;
					}
				}

				return \substr($display, 0, -1); // remove the last space
			}
		}
		else
		{
			$results = $expression->get('expressions');

			foreach ($results as $key => $value)
			{
				$results[$key] = self::displayExpression($value);
			}

			return '(' . \implode(' ' . $expression->get('type')->value . ' ', $results) . ')';
		}
	}
	/**
	 * display from part for mysql query
	 *
	 * @param \database\parameter\Table $table
	 *
	 * @return string
	 */
	public static function displayFrom(\database\parameter\Table $table) : string
	{
		$display = 'FROM ';

		if ($table->get('subquery') !== null)
		{
			return $display . '(' . self::displayQuery($table->get('subquery')) . ')';
		}

		$display .= self::displayTable($table, False);

		if ($table->get('alias') !== null)
		{
			return $display . ' AS ' . self::displayAlias($table->get('alias'));
		}

		return $display;
	}
	/**
	 * display a group by for mysql query
	 *
	 * @param \database\parameter\GroupBy $group_by
	 *
	 * @return string
	 */
	public static function displayGroupBy(\database\parameter\GroupBy $group_by) : string
	{
		return 'GROUP BY ' . self::displayGroupByAppend($group_by);
	}
	/**
	 * display the group by without the first keyword for mysql query
	 *
	 * @param \database\parameter\GroupBy $group_by
	 *
	 * @return string
	 */
	public static function displayGroupByAppend(\database\parameter\GroupBy $group_by) : string
	{
		if ($group_by->get('group_by') !== null)
		{
			$results = $group_by->get('group_by');

			foreach ($results as $key => $value)
			{
				$results[$key] = self::displayGroupByAppend($value);
			}

			return \implode(', ', $results);
		}

		return self::displayAttributes($group_by->get('attributes'));
	}
	/**
	 * display having part for mysql query
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @return string
	 */
	public static function displayHaving(\database\parameter\Expression $expression)
	{
		return 'HAVING ' . self::displayExpression($expression);
	}
	/**
	 * display a join for mysql query
	 *
	 * @param \database\parameter\Join $join
	 *
	 * @return string
	 */
	public static function displayJoin(\database\parameter\Join $join) : string
	{
		$display = $join->get('type')->value . ' ';

		if ($join->get('table') !== null)
		{
			$display .= self::displayTable($join->get('table'), False);

			if ($join->get('table')->get('alias') !== null)
			{
				$display .= ' AS ' . self::displayAlias($join->get('table')->get('alias'));
			}
		}
		else
		{
			$display .= ' (' . self::displayQuery($join->get('subquery')) . ')';

			if ($join->get('subquery_alias') !== null)
			{
				$display .= ' AS ' . self.displayAlias($join->get('subquery_alias'));
			}
		}

		if (\in_array($join->get('type'), $join::TYPES_WITHOUT_ON))
		{
			return $display;
		}
		return $display . ' ON (' . self::displayExpression($join->get('expression')) . ')';
	}
	/**
	 * display joins for mysql query
	 *
	 * @param array $joins
	 *
	 * @return string
	 */
	public static function displayJoins(array $joins) : string
	{
		foreach ($joins as $key => $join)
		{
			$joins[$key] = self::displayJoin($join);
		}
		return \implode(' ', $joins);
	}
	/**
	 * display limit for mysql query
	 *
	 * @param \database\parameter\Limit $limit
	 *
	 * @return string
	 */
	public static function displayLimit(\database\parameter\Limit $limit)
	{
		$display = 'LIMIT ';

		if ($limit->get('offset') !== null)
		{
			$display .= $limit->display('offset') . ', ';
		}

		return $display . $limit->display('count');
	}
	/**
	 * display order by for mysql query
	 *
	 * @param \database\parameter\OrderBy $order_by
	 *
	 * @return string
	 */
	public static function displayOrderBy(\database\parameter\OrderBy $order_by) : string
	{
		return 'ORDER BY ' . self::displayOrderByAppend($order_by);
	}
	/**
	 * display order by without the first keyword for mysql query
	 *
	 * @param \database\parameter\OrderBy $order_by
	 *
	 * @return string
	 */
	public static function displayOrderByAppend(\database\parameter\OrderBy $order_by) : string
	{
		if ($order_by->get('order_by') !== null)
		{
			$results = $order_by->get('order_by');
			foreach ($results as $key => $value)
			{
				$results[$key] = self::displayOrderByAppend($value);
			}

			return \implode(', ', $results);
		}

		if ($order_by->get('type'))
		{
			return self::displayColumn($order_by->get('column')) . ' ' . $order_by->display('type')->value;
		}

		return self::displayColumn($order_by->get('column'));
	}
	/**
	 * display a parameter for mysql
	 *
	 * @param \database\parameter\Parameter $parameter
	 *
	 * @return string
	 */
	public static function displayParameter(\database\parameter\Parameter $parameter) : string
	{
		if ($parameter->get('placeholder'))
		{
			return ':' . $parameter->get('placeholder');
		}

		return '?';
	}
	/**
	 * display parameters part (for insert) for mysql
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public static function displayParameters(array $attributes) : string
	{
		$display = '(';

		foreach ($attributes as $attribute)
		{
			$display .= '`' . $attribute->display('name') . '`, ';
		}

		return substr($display, 0, -2) . ')';
	}
	/**
	 * display a query for mysql
	 *
	 * @param \database\parameter\Query $query
	 *
	 * @return string
	 */
	public static function displayQuery(\database\parameter\Query $query) : string
	{
		$display = $query::KEYWORD;
		$table = $query->table();

		foreach ($query::STEPS as $step)
		{
			if (\key_exists($step, $table))
			{
				$value = $table[$step];

				$method_name = 'display' . \ucfirst($step);

				if (!\method_exists(__CLASS__, $method_name))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayQuery']['no_method'], ['method' => $method_name, 'step' => $step]);
					throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayQuery']['no_method']);
				}
				if ($value !== null) // needed for method like displayDistinct
				{
					$display .= ' ' . self::$method_name($value);
				}
			}
			else if (\in_array($step, $query::STEPS_REQUIRED))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['Mysql']['displayQuery']['required'], ['method' => $method_name, 'step' => $step]);
				throw new \Exception($GLOBALS['locale']['class']['database']['Mysql']['displayQuery']['required']);
			}
		}

		return $display;
	}
	/**
	 * display select part for mysql query
	 *
	 * @param array $columns
	 *
	 * @return string
	 */
	public static function displaySelect(array $columns) : string
	{
		foreach ($columns as $key => $column)
		{
			$temp = self::displayColumn($column);

			if ($column->get('alias') !== null)
			{
				$temp .= ' AS ' . self::displayAlias($column->get('alias'));
			}

			$columns[$key] = $temp;
		}

		return \implode(', ', $columns);
	}
	/**
	 * display set for mysql query
	 *
	 * @param array $set
	 *
	 * @return string
	 */
	public static function displaySets(array $set) : string
	{
		$display = 'SET ';

		foreach ($set['attributes'] as $key => $value)
		{
			$display .= '`' . $value->display('name') . '` = ' . self::displayParameter($set['values'][$key]) . ', ';
		}

		return substr($display, 0, -2);
	}
	/**
	 * display table for mysql query
	 *
	 * @param \database\parameter\Table $table
	 *
	 * @param bool $alias If alias must be used.
	 *                    Default to True.
	 *
	 * @return string
	 */
	public static function displayTable(\database\parameter\Table $table, bool $alias = True) : string
	{
		if ($table->get('alias') !== null && $alias)
		{
			return '`' . $table->display('alias') . '`';
		}
		return '`' . $table->display('name') . '`';
	}
	/**
	 * display values part for mysql query
	 *
	 * @param array $values
	 *
	 * @return string
	 */
	public static function displayValues(array $values) : string
	{
		$display = 'VALUES (';

		foreach ($values as $value)
		{
			$display .= self::displayParameter($value) . ', ';
		}

		return substr($display, 0, -2) . ')';
	}
	/**
	 * display where part for mysql query
	 *
	 * @param \database\parameter\Expression $expression
	 *
	 * @return string
	 */
	public static function displayWhere(\database\parameter\Expression $expression) : string
	{
		return 'WHERE ' . self::displayExpression($expression);
	}

}

?>
