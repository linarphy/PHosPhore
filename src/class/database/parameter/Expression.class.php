<?php

namespace database\parameter;

/**
 * an expression
 */
class Expression
{
	use \core\Base;

	/**
	 * expressions inside this expression (for other type than comparison one)
	 *
	 * @var ?array
	 */
	protected ?array $expressions = null;
	/**
	 * operator used if in comparison type and not with a subquery without operator like IN
	 *
	 * @var ?\database\parameter\Operator
	 */
	protected ?\database\parameter\Operator $operator;
	/**
	 * values for this expression (comparison type)
	 *
	 * @var ?array
	 */
	protected ?array $values = null;
	/**
	 * sub operator used if in comparison type with a subquery
	 *
	 * @var ?\database\parameter\SubOperator
	 */
	protected ?\database\parameter\SubOperator $sub_operator = null;
	/**
	 * type of the expression
	 *
	 * @var \database\parameter\ExpressionTypes
	 */
	protected \database\parameter\ExpressionTypes $type;
	/**
	 * retrieves parameters for this expression
	 *
	 * @return array
	 */
	public function retrieveParameters() : array
	{
		$parameters = [];

		if ($this->get('expressions') === null)
		{
			foreach ($this->get('values') as $value)
			{
				if (\get_class($value) === 'database\\parameter\\Parameter')
				{
					$parameters[] = $value;
				}
			}
			return $parameters;
		}
		else
		{
			foreach ($this->get('expressions') as $expression)
			{
				$parameters = \array_merge($parameters, $expression->retrieveParameters());
			}
			return $parameters;
		}
	}
}

?>
