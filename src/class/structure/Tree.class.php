<?php

namespace structure;

/**
 * A tree structure
 */
class Tree
{
	/**
	 * Root node of the tree
	 *
	 * @var \structure\Node
	 */
	protected $root;
	/**
	 * constructor
	 *
	 * @param mixed $root_data Data of the root node of the tree
	 *
	 * @return \structure\Tree
	 */
	public function __construct($root_data)
	{
		$Root = new \structure\Node($root_data);
		$this->set('root', $Root);

		return $this;
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
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['structure']['Tree']['get']['not_found'], array('attribute' => $attribute));

			return null;
		}

		return $this->$attribute;
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
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['structure']['Tree']['set']['not_found'], array('attribute' => $attribute));

			return False;
		}
		$this->$attribute = $value;
	}
}

?>
