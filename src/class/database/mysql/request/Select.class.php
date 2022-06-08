<?php

namespace database\mysql\request;

/**
 * select request builder for mysql
 */
class Select extends \database\Request
{
	/**
	 * steps for constructing the query
	 *
	 * @var array
	 */
	const STEPS = [
		'attribute',
		'table',
		'join',
		'condition',
		'order',
		'group',
		'limit',
	];
	/**
	 * required steps for cosntructing the query
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [
		'attribute',
		'from',
	];
	/**
	 * conditions
	 *
	 * @var array
	 */
	protected array $conditions = [];
	/**
	 * group
	 *
	 * @var null|\database\parameter\Group
	 */
	protected ?\database\parameter\Group $group = null;
	/**
	 * joins
	 *
	 * @var array
	 */
	protected array $joins = [];
	/**
	 * limit
	 *
	 * @var null|\database\parameter\Limit
	 */
	protected ?\database\parameter\Limit $limit = null;
	/**
	 * order
	 *
	 * @var null|\database\parameter\Order
	 */
	protected ?\database\parameter\Order $order = null;
	/**
	 * attributes
	 *
	 * @var array
	 */
	protected array $attributes = [];
	/**
	 * table
	 *
	 * @var null|\database\parameter\Table
	 */
	protected ?\database\parameter\Table $table = null;
	/**
	 * add a condition
	 *
	 * @param \database\parameter\Condition $condition
	 *
	 * @return self
	 */
	public function addCondition(\database\parameter\Condition $condition) : self
	{
		$this->set(
			'conditions',
			\array_merge(
				$this->get('conditions'),
				$condition,
			),
		);

		return $this;
	}
	/**
	 * add a group
	 *
	 * @param \database\parameter\Group $group
	 *
	 * @return self
	 */
	public function addGroup(\database\parameter\Group $group) : self
	{
		$this->set('group', $group);

		return $this;
	}
	/**
	 * add a join
	 *
	 * @param \database\parameter\Join $join
	 *
	 * @return self
	 */
	public function addJoin(\database\parameter\Join $join) : self
	{
		$this->set(
			'joins',
			\array_merge(
				$this->get('joins'),
				$join,
			),
		);

		return $this;
	}
	/**
	 * add a limit
	 *
	 * @param \database\parameter\Limit $limit
	 *
	 * @return self
	 */
	public function addLimit(\database\parameter\Limit $limit) : self
	{
		$this->set('limit', $limit);

		return $this;
	}
	/**
	 * add an order
	 *
	 * @param \database\parameter\Order $order
	 *
	 * @return self
	 */
	public function addOrder(\database\parameter\Order $order) : self
	{
		$this->set('order', $order);

		return $this;
	}
	/**
	 * add an attribute
	 *
	 * @param \database\parameter\Attribute $attribute
	 *
	 * @return self
	 */
	public function addAttribute(\database\parameter\Attribute $attribute) : self
	{
		$this->set(
			'attributes',
			\array_merge(
				$this->get('attributes'),
				$attribute,
			),
		);

		return $this;
	}
	/**
	 * add a table
	 *
	 * @param string $table
	 *
	 * @return self
	 */
	public function addTable(\database\parameter\Table $table) : self
	{
		$this->set('table', $table);

		return $this;
	}
	/**
	 * construct conditions part
	 *
	 * @return string
	 */
	public function constructConditions() : string
	{
		$display = ' WHERE';

		foreach ($this->get('conditions') as $condition)
		{
			if (!$this->check(\database\Mysql::OPERATORS))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['mysql']['request']['Select']['constructConditions']['bad_operator'], ['operator' => $condition->get('operator')->get('symbol')]);
				throw new \Exception($GLOBALS['lang']['class']['database']['mysql']['request']['Select']['constructConditions']['bad_operator']);
			}

			$display = ' ' . \database\Mysql::displayAttribute($condition->get('attribute')) . $condition->get('operator')->display() . '?';
			MAKE CONDITIONNAL STATEMENT (AND, OR, etc.)

			$this->set(
				'parameters',
				\array_merge(
					$this->get('parameters'),
					$condition->get('value'),
				),
			);
		}

		return $display
	}
	/**
	 * construct group part
	 *
	 * @return string
	 */
	public function constructGroups() : string
	{

		return ' GROUP BY ' . \database\Mysql::displayAttributes($this->get('group')->get('attributes'));
	}
	/**
	 * construct joins part
	 *
	 * @return string
	 */
	public function constructJoins() : string
	{
		$display = '';

		foreach ($this->get('joins') as $join)
		{
			$display .= $join->get('type') . ' ' . $join->get('table');
			if ($join->get('alias') !== null)
			{
				$display .= ' AS ' . $join->get('alias');
			}
			$display .= ' ON ' . $join->get('attributes')[0] . '=' . $join->get('attributes')[1];
		}

		return $display;
	}
	/**
	 * construct limit part
	 *
	 * @return string
	 */
	public function constructLimits() : string
	{
		if ($this->get('limit')->get('offset') === null)
		{
			return ' LIMIT ' . $this->get('limit')->get('count');
		}
		return ' LIMIT ' . $this->get('limit')->get('offset') . ', ' . $this->get('limit')->get('count');
	}
	/**
	 * construct order part
	 *
	 * @return string
	 */
	public function constructOrders() : string
	{
		$display = ' ORDER BY';

		foreach ($this->get('order')->get('attributes') as $attribute)
		{
			$display .= ' ' . $attribute->get('name');
			if ($attribute->hasType())
			{
				$display .= ' ' . $attribute->get('type');
			}
			$display .= ',';
		}

		return \substr($display, 0, -1); // remove the last comma
	}
	/**
	 * construct attribute part
	 *
	 * @return string
	 */
	public function constructAttributes() : string
	{
		$display = 'SELECT ';

		foreach ($this->get('attributes') as $attribute)
		{
			$display .= $attribute->get('name') . ', ';
		}

		return \substr($display, 0, -2); // remove the last comma
	}
	/**
	 * construct table part
	 *
	 * @return string
	 */
	public function constructTables() : string
	{
		return ' FROM ' . $this->get('table')->get('name');
	}
	/**
	 * checks if there are conditions
	 *
	 * @return bool
	 */
	public function hasConditions() : bool
	{
		return \phosphore_count($this->get('conditions')) !== 0;
	}
	/**
	 * checks if there is a group
	 *
	 * @return bool
	 */
	public function hasGroup() : bool
	{
		return $this->get('group') !== null;
	}
	/**
	 * checks if there are joins
	 *
	 * @return bool
	 */
	public function hasJoins() : bool
	{
		return \phosphore_count($this->get('joins')) !== 0;
	}
	/**
	 * checks if there is a limit
	 *
	 * @return bool
	 */
	public function hasLimits() : bool
	{
		return $this->get('limit') !== null;
	}
	/**
	 * checks if there is an order
	 *
	 * @return bool
	 */
	public function hasOrders() : bool
	{
		return $this->get('order') !== null;
	}
	/**
	 * checks if there are attributes
	 *
	 * @return bool
	 */
	public function hasAttributes() : bool
	{
		return \phosphore_count($this->get('attributes')) !== 0;
	}
	/**
	 * checks if there is a table
	 *
	 * @return bool
	 */
	public function hasTables() : bool
	{
		return $this->get('table') !== null;
	}
}

?>
