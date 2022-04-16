<?php

namespace structure;

/**
 * A node of a tree
 */
class Node
{
	/**
	 * List of nodes in this node
	 *
	 * @var array
	 */
	protected ?array $children = null;
	/**
	 * Data of this node
	 *
	 * @var mixed
	 */
	protected mixed $data = null;
	/**
	 * Parent of this node
	 *
	 * @var \structure\Node|null
	 */
	protected ?\structure\Node $parent = null;
	/**
	 * constructor
	 *
	 * @param mixed $data Data of this node
	 *
	 * @param \structure\Node|null $parent Parent of this node
	 *
	 * @return \structure\Node
	 */
	public function __construct(mixed $data, ?\structure\Node $parent = null)
	{
		$this->set('data', $data);
		$this->set('children', array());
		$this->set('parent', $parent);

		return $this;
	}
	/**
	 * Add a child node
	 *
	 * @param \structure\Node $child Child node to add
	 *
	 * @return \structure\Node
	 */
	public function addChild(\structure\Node $child) : \structure\Node
	{
		$child->set('parent', $this);
		$this->children[] = $child;

		return $this;
	}
	/**
	 * Display the node
	 *
	 * @return string
	 */
	public function display() : string
	{
		$text = '';
		if ($this->get('data') !== null)
		{
			$text .= \phosphore_display($this->get('data')) . PHP_EOL . \str_repeat('-', \phosphore_count($this->get('data'))) . PHP_EOL;
		}
		if (\phosphore_count($this->get('children')) !== 0)
		{
			foreach ($this->get('children') as $child)
			{
				$text .= '|' . PHP_EOL . '|- ' . $child->display();
			}
		}
		return $text;
	}
	/**
	 * Remove a child node
	 *
	 * @param \structure\Node $child Child node to delete
	 *
	 * @return null|\structure\Node
	 */
	public function removeChild(\structure\Node $child) : ?\structure\Node
	{
		foreach ($this->children as $key => $try_child)
		{
			if ($child === $try_child)
			{
				$temp = $this->children[$key];
				unset($this->children[$key]);
				return $temp;
			}
		}
		return null;
	}
	/**
	 * Get the value of a given attribute
	 *
	 * @param string $attribute Name of the attribute
	 *
	 * @return mixed
	 */
	public function get(string $attribute) : mixed
	{
		if ($this->$attribute === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['structure']['Node']['get']['not_found'], array('attribute' => $attribute));

			return null;
		}

		return $this->$attribute;
	}
	/**
	 * Get ancestors of the node
	 *
	 * @return array
	 */
	public function getAncestors() : array
	{
		if ($this->parent === null)
		{
			return array();
		}
		return array_merge(array($this->parent), $this->parent->getAncestors());
	}
	/**
	 * Get a branch with a defined depth
	 *
	 * @param int $depth Wanted depth
	 *
	 * @return False|array
	 */
	public function getBranchDepth(int $depth) : ?array
	{
		if ($depth === 0)
		{
			if (empty($this->children))
			{
				return array($this);
			}
			return null;
		}
		if (empty($this->children))
		{
			return null;
		}
		foreach ($this->children as $child)
		{
			$result = $child->getBranchDepth($depth - 1);
			if ($result !== False)
			{
				return array_merge(array($this), $result);
			}
		}
		return null;
	}
	/**
	 * Get depth of this node in the tree
	 *
	 * @return int
	 */
	public function getDepth() : int
	{
		if (this->parent === null)
		{
			return 0;
		}
		return $this->parent->getDepth() + 1;
	}
	/**
	 * Get height of this node
	 *
	 * @return int
	 */
	public function getHeight() : int
	{
		if (empty($this->children))
		{
			return 0;
		}

		$height = array();
		foreach ($this->children as $child)
		{
			$height[] = $child->getHeight();
		}

		return max($height) + 1;
	}
	/**
	 * Get neighbors nodes
	 *
	 * @return array
	 */
	public function getNeighbors() : array
	{
		$neighbors = $this->parent->get('children');

		foreach ($neighbors as $key => $neighbour)
		{
			if ($neighbour === $this)
			{
				unset($neighbors[$key]);
			}
		}

		return $neighbors;
	}
	/**
	 * Get root node of the tree
	 *
	 * @return \structure\Node
	 */
	public function getRoot() : \Structure\Node
	{
		if ($this->parent === null)
		{
			return $this;
		}

		return $this->parent->getRoot();
	}
	/**
	 * Set the value of a given attribute
	 *
	 * @param string $attribute Name of the attribute
	 *
	 * @param mixed $value Value of the attribute
	 *
	 * @return bool
	 */
	protected function set(string $attribute, mixed $value) : mixed
	{
		if (!property_exists($this, $attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['structure']['Node']['set']['not_found'], array('attribute' => $attribute));

			return null;
		}

		$this->$attribute = $value;
		return $value;
	}
}

?>
