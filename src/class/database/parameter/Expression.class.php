<?php

namespace database\parameter;

/**
 * an expression
 */
class Expression
{
	use \core\Base;

	/**
	 * available expression type
	 *
	 * @var array
	 */
	const TYPES = [
		'comparison',
		'AND',
		'OR',
		'XOR',
	];
	/**
	 * columns used if in comparison type
	 *
	 * @var array
	 */
	protected array $columns;
	/**
	 * expressions inside this expression (for other type than comparison one)
	 *
	 * @var array
	 */
	protected array $expressions;
	/**
	 * operator used if in comparison type and not with a subquery without operator like IN
	 *
	 * @var \database\parameter\Operator
	 */
	protected \database\parameter\Operator $operator;
	/**
	 * sub-operator used if in comparison type and with a subquery
	 *
	 * @var \database\parameter\SubOperator
	 */
	protected \database\parameter\SubOperator $sub_operator;
	/**
	 * subquery if in comparison type
	 *
	 * @var \database\parameter\Query
	 */
	protected \database\parameter\Query $subquery;
	/**
	 * type of the expression
	 *
	 * @var string
	 */
	protected string $type;
	/**
	 * set the type
	 *
	 * @param string
	 *
	 * @return bool
	 */
	public function setType(string $type) : bool
	{
		if (!\in_array($type, $this::TYPES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['parameter']['Expression']['setType']['unknown'], ['type' => $type]);
			throw new \Exception($GLOBALS['locale']['class']['database']['parameter']['Expression']['setType']['unknown']);
		}

		$this->type = $type;

		return True;
	}
}

?>
