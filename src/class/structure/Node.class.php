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
	protected $children;
	/**
	 * Data of this node
	 *
	 * @var mixed
	 */
	protected $data;
	/**
	 * Parent of this node
	 *
	 * @var \structure\Node|null
	 */
	protected $parent;
	/**
	 * constructor
	 *
	 * @param mixed $data Data of this node
	 *
	 * @param \structure\Node|null $parent Parent of this node
	 *
	 * @return \structure\Node
	 */
	public function __construct($data, $parent = null)
	{
		$this->set('data', $data);
		$this->set('children', array());
		$this->set('parent', $parent);
	}
	/**
	 * Add a child node
	 *
	 * @param \structure\Node $child Child node to add
	 *
	 * @return \structure\Node
	 */
	public function addChild($child)
	{
		$child->set('parent', $this);
		$this->children[] = $child;

		return $this;
	}
	/**
	 * Remove a child node
	 *
	 * @param \structure\Node $child Child node to delete
	 *
	 * @return bool
	 */
	public function removeChild($child)
	{
		$return = False;
		foreach ($this->children as $key => $try_child)
		{
			if ($child === $try_child)
			{
				$return = True;
				unset($this->children[$key]);
			}
		}
		return $return;
	}
	/**
	 * Get the value of a given attribute
	 *
	 * @param string $attribute Name of the attribute
	 *
	 * @return mixed
	 */
	public function get($attribute)
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
	public function getAncestors()
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
	public function getBranchDepth($depth)
	{
		if ($depth === 0)
		{
			if (empty($this->children))
			{
				return array($this);
			}
			return False;
		}
		if (empty($this->children))
		{
			return False;
		}
		foreach ($this->children as $child)
		{
			$result = $child->getBranchDepth($depth - 1);
			if ($result != False)
			{
				return array_merge($this, $result);
			}
		}
		return False;
	}
	/**
	 * Get depth of this node in the tree
	 *
	 * @return int
	 */
	public function getDepth()
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
	public function getHeight()
	{
		if (empty($this->children))
		{
			return 0;
		}

		$height = array();
		foreach ($this->children as $child)
		{
			$height[] = $child->height();
		}

		return max($height) + 1;
	}
	/**
	 * Get neighbors nodes
	 *
	 * @return array
	 */
	public function getNeighbors()
	{
		$neighbors = $this->parent->get('children');

		foreach ($neighbors as $key => $neighbour)
		{
			if ($neighbour === $this)
			{
				unset $neighbors[$key];
			}
		}

		return $neighbors;
	}
	/**
	 * Get root node of the tree
	 *
	 * @return \structure\Node
	 */
	public function getRoot()
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
	protected function set($attribute, $value)
	{
		if ($this->$attribute === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['structure']['Node']['set']['not_found'], array('attribute' => $attribute));

			return False;
		}
		$this->$attribute = $value;
	}
}

?>
