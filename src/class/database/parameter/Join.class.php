<?php

namespace database\parameter;

/**
 * used to join multiple table
 */
class Join
{
	use \core\Base;

	/**
	 * available types
	 *
	 * @var array
	 */
	const TYPES = [
		'INNER JOIN',
		'RIGHT JOIN',
		'LEFT JOIN',
		'CROSS JOIN',
	];
	/**
	 * join type which does not need an ON condition for mysql
	 *
	 * @var array
	 */
	const TYPES_WITHOUT_ON = [
		'CROSS JOIN',
	];
	/**
	 * expression to join (if needed)
	 *
	 * @var ?\database\parameter\Expression
	 */
	protected ?\database\parameter\Expression $expression;
	/**
	 * subquery if not a table to join
	 *
	 * @var ?\database\parameter\Query
	 */
	protected ?\database\parameter\Query $subquery;
	/**
	 * subquery alias if any
	 *
	 * @var ?string
	 */
	protected ?string $subquery_alias = null;
	/**
	 * table to join
	 *
	 * @var ?\database\parameter\Table
	 */
	protected ?\database\parameter\Table $table;
	/**
	 * type of the join
	 *
	 * @var string
	 */
	protected string $type;
	/**
	 * set the type
	 *
	 * @param string $type
	 *
	 * @return bool
	 */
	public function setType(string $type) : bool
	{
		if (!\in_array($type, $this::TYPES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['parameter']['Join']['setType']['unknown'], ['type' => $type]);
			throw new \Exception($GLOBALS['locale']['class']['database']['parameter']['Join']['setType']['unknown']);
		}

		$this->type = $type;

		return True;
	}
}

?>
