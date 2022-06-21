<?php

namespace database;

/**
 * tool to construct expression
 */
class ExpressionConstructor
{
	use \core\Base;

	/**
	 * current expression in construction
	 *
	 * @var \database\parameter\Expression
	 */
	protected \database\parameter\Expression $expression;
	/**
	 * queryConstructor linked to this expressionConstructor
	 *
	 * @var \database\parameter\QueryConstructor $query_constructor
	 */
	protected \database\QueryConstructor $query_constructor;
	/**
	 * current expression type
	 *
	 * @var \database\parameter\ExpressionTypes
	 */
	protected \database\parameter\ExpressionTypes $type;
	/**
	 * add a value for comparison type
	 *
	 * @param string $type
	 *
	 * @param ...mixed $arguments
	 *
	 * @return self
	 */
	public function add(string $type, ...$arguments) : self
	{
		if ($this->get('type') === null)
		{
			$this->set('type', \database\parameter\ExpressionTypes::COMP);
		}
		else if ($this->get('type') !== \database\parameter\ExpressionTypes::COMP)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['add']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['add']['bad_type']);
		}

		switch ($type)
		{
			case 'Query':
			case 'Q':
				$result = $this->addSubQuery(...$arguments);
				break;
			case 'Parameter':
			case 'P':
				$result = $this->addParameter(...$arguments);
				break;
			case 'Column':
			case 'C':
				$result = $this->addColumn(...$arguments);
				break;
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['add']['unknown_arguments'], ['number' => \count($arguments)]);
				throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['add']['unknown_arguments']);
		}


		if ($this->get('expression') === null)
		{
			$this->set('expression', new \database\parameter\Expression([
					'values' => [
						$result,
					],
					'type' => \database\parameter\ExpressionTypes::COMP,
				]));
		}
		else if (\in_array(\count($this->get('expression')->get('values')), [0, 1]))
		{
			$this->get('expression')->set(
				'values',
				\array_merge(
					$this->get('expression')->get('values'),
					[$result],
				),
			);
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['add']['too_much'], ['number' => \count($this->get('expression')->get('values'))]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['add']['too_much']);
		}

		return $this;
	}
	/**
	 * add a column for comparison type
	 *
	 * @param string $name
	 *
	 * @param string $table
	 *
	 * @param ?string $alias
	 *
	 * @param ?bool $is_function
	 *
	 * @param ?string $function_parameter
	 *
	 * @return \database\parameter\Column
	 */
	public function addColumn(string $name, string $table, ?string $alias = null, ?bool $is_function = False, ?string $function_parameter = null) : \database\parameter\Column
	{
		if (!$is_function && $function_parameter !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['addColumn']['cannot_parameter'], ['name' => $name, 'parameter' => $function_parameter]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['addColumn']['cannot_parameter']);
		}

		if (empty($table))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['addColumn']['empty_table'], ['name' => $name]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['addColumn']['empty_table']);
		}

		if (empty($name))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['addColumn']['empty_name'], ['table' => $table]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['addColumn']['empty_name']);
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

		if ($Column->get('attribute') !== null && $this->get('query_constructor') !== null)
		{
			$Column->get('attribute')->set('table', $this->get('query_constructor')->findTable($table));
		}

		return $Column;
	}
	/**
	 * add a parameter for comparison type
	 *
	 * @param mixed $value
	 *
	 * @param ?string $placeholder
	 *
	 * @return \database\parameter\Parameter
	 */
	public function addParameter(mixed $value, ?string $placeholder = null) : \database\parameter\Parameter
	{
		$Parameter = new \database\parameter\Parameter([
			'value' => $value,
		]);

		if ($placeholder !== null && !empty($placeholder))
		{
			$Parameter->set('placeholder', $placeholder);
		}
		else
		{
			if ($this->get('query_constructor') !== null)
			{
				$Parameter->set('position', $this->get('query_constructor')->get('position'));
				$this->get('query_constructor')->set('position', $this->get('query_constructor')->get('position') + 1);
			}
			else if ($this->get('expression') !== null)
			{
				$Parameter->set('position', \count($this->get('expression')->get('values')));
			}
			else
			{
				$Parameter->set('position', 0);
			}
		}

		return $Parameter;
	}
	/**
	 * add a subQuery for comparison type
	 *
	 * @param \database\parameter\Query $sub_query
	 *
	 * @return \database\parameter\Query
	 */
	public function addSubQuery(\database\parameter\Query $sub_query) : \database\parameter\Query
	{
		if ($this->get('expression')->get('operator') !== null && \get_class($this->get('expression')->get('operator')) === 'database\\parameter\\Operator')
		{
			$this->get('expression')->set('sub_operator',
				new \database\parameter\SubOperation([
					'symbol' => $this->get('expression')->get('operator')->get('symbol'),
				]),
			);
			$this->get('expression')->set('operator', null);
		}

		return $sub_query;
	}
	/**
	 * create an and statement
	 *
	 * @param ...\database\parameter\Expression $expression
	 *
	 * @return self
	 */
	public function and(\database\parameter\Expression ...$expressions) : self
	{
		$this->set('type', \database\parameter\ExpressionTypes::AND);
		$this->set('expression', new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::AND,
		]));

		return $this;
	}
	/**
	 * alias for operator
	 *
	 * @param string $operator
	 *
	 * @return self
	 */
	public function op(string $operator) : self
	{
		return $this->operator($operator);
	}
	/**
	 * create a comparison statement
	 *
	 * @param string $operator
	 *
	 * @return self
	 */
	public function operator(string $operator) : self
	{
		if ($this->get('type') === null)
		{
			$this->set('type', \database\parameter\ExpressionTypes::COMP);
		}
		else if ($this->get('type') !== \database\parameter\ExpressionTypes::COMP)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['ExpressionConstructor']['select']['bad_type'], ['type' => $this->get('type')]);
			throw new \Exception($GLOBALS['locale']['class']['database']['ExpressionConstructor']['select']['bad_type']);
		}

		if (
			$this->get('expression') !== null &&
			$this->get('expression')->get('values') !== null &&
			(
				(
					\count($this->get('expression')->get('values')) === 1 &&
					\get_class($this->get('expression')->get('values')[0]) === 'database\\parameter\\Query'
				) ||
				(
					\count($this->get('expression')->get('values')) === 2 &&
					(
						\is_subclass_of(\get_class($this->get('expression')->get('values')[0]), 'database\\parameter\\Query') ||
						\is_subclass_of(\get_class($this->get('expression')->get('values')[1]), 'database\\parameter\\Query')
					)
				)
			)
		)
		{
			$Operator = new \database\parameter\SubOperator([
				'symbol' => $operator,
			]);

			if ($this->get('expression') === null)
			{
				$this->set('expression', new \database\parameter\Expression([
					'sub_operator' => $Operator,
					'values'   => [],
					'type' => \database\parameter\ExpressionTypes::COMP,
				]));
			}
			else
			{
				$this->get('expression')->set('sub_operator', $Operator);
			}
		}
		else
		{
			$Operator = new \database\parameter\Operator([
				'symbol' => $operator,
			]);

			if ($this->get('expression') === null)
			{
				$this->set('expression', new \database\parameter\Expression([
					'operator' => $Operator,
					'values'   => [],
					'type' => \database\parameter\ExpressionTypes::COMP,
				]));
			}
			else
			{
				$this->get('expression')->set('operator', $Operator);
			}
		}

		return $this;
	}
	/**
	 * create an or statement
	 *
	 * @param ...\database\parameter\Expression $expression
	 *
	 * @return self
	 */
	public function or(\database\parameter\Expression ...$expressions) : self
	{
		$this->set('type', \database\parameter\ExpressionTypes::OR);
		$this->set('expression', new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::OR,
		]));

		return $this;
	}
	/**
	 * create a xor statement
	 *
	 * @param ...\database\parameter\Expression $expression
	 *
	 * @return self
	 */
	public function xor(\database\parameter\Expression ...$expressions) : self
	{
		$this->set('type', \database\parameter\ExpressionTypes::XOR);
		$this->set('expression', new \database\parameter\Expression([
			'expressions' => $expressions,
			'type'        => \database\parameter\ExpressionTypes::XOR,
		]));

		return $this;
	}
}

?>
