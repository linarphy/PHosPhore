<?php

namespace core;

/**
 * Object managed in the database
 */
abstract class Managed
{
	/**
	 * Unique index
	 *
	 * @var array
	 */
	const INDEX = array('id');
	/**
	 * Constructor
	 *
	 * @param array $attributes Defined values of the object attributes
	 */
	public function __construct(attributes: $attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['construct'], array('class' => get_class($this)));

		$this->hydrate();
	}
	/**
	 * Insert the object in the database
	 *
	 * @return bool
	 */
	public function add()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['add']['start'], array('class' => get_class($this)));

		$index = $this->manager()->add($this->table());

		if ($index === False | count($index) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['class']['core']['managed']['add']['error'], array('class' => get_class($this)));
			return $index;
		}

		foreach ($index as $name => $value)
		{
			$this->set($name, $value);
		}
		return True;
	}
	/**
	 * Display a given array into a readable and safe form
	 *
	 * @param array $list Array to display
	 *
	 * @return string
	 */
	public static function arrDisp(list: $list)
	{
		$display = '';
		if (count($list) === 0)
		{
			return $display;
		}
		foreach ($list as $element)
		{
			if (is_string($element))
			{
				$display .= htmlspecialchars($element);
			}
			else if (is_bool($element))
			{
				if ($element)
				{
					$display .= 'True';
				}
				else
				{
					$display .= 'False';
				}
			}
			else if (is_int($element) | is_float($element))
			{
				$display .= (string) $element;
			}
			else if (is_null($element))
			{
				$display .= '';
			}
			else if (is_resource($element))
			{
				$display .= get_resource_type($element);
			}
			else if (is_array($element))
			{
				$display .= '(' . self::arrDisp($element) . ')';
			}
			else if (is_object($element))
			{
				if (method_exists($element, 'display'))
				{
					$display .= $element->display();
				}
				$display .= get_class($element);
			}
			else if (is_callable($element))
			{
				if ($element instanceOf \Closure)
				{
					$display .= 'closure';
				}
				$display .= 'unknown';
			}
			else if (is_iterable($element))
			{
				$display .= 'iterable';
			}
			else
			{
				$display .= 'unknown type';
			}
			$display .= ',';
		}
	}
	/**
	 * Clone the object (return a new one with the same attributes)
	 */
	public function clone()
	{
		$class = get_class($this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['clone'], array('class' => $class));
		return new $class($this->table());
	}
	/**
	 * Delete the object in the database
	 *
	 * @return bool
	 */
	public function delete()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['delete']['start'], array('class', get_class($this)));

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']['managed']['delete']['not_exist'], array('class' => get_class($this)));

			return False;
		}
		$index = $this->getIndex();
		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']['managed']['delete']['missing_index'], array('class' => get_class($this)));

			return False;
		}

		return $this->manager()->delete($this->getIndex());
	}
	/**
	 * Convert this object into a safe and readable form
	 *
	 * @return string
	 */
	public function display()
	{
		return $this::arrDisp($this->table());
	}
	/**
	 * Convert any attribute into a safe and readable form
	 *
	 * @param string $attribute Attribute to display
	 *
	 * @return string
	 */
	public function displayer(attribute: $attribute)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['displayer']['start'], array('class', get_class($this)));

		$display = $this::getDisp($attribute);
		if (method_exists($this, $display))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['displayer']['exist'], array('class', get_class($this), 'attribute' => $attribute));

			return $this->$display();
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['displayer']['not_exist'], array('class', get_class($this), 'attribute' => $attribute));

		$attribute = $this->get($attribute);

		if (is_string($attribute))
		{
			return htmlspecialchars($attribute);
		}
		if (is_bool($attribute))
		{
			if ($attribute)
			{
				return 'True';
			}
			return 'False';
		}
		if (is_int($attribute) | is_float($attribute))
		{
			return (string) $attribute;
		}
		if (is_null($attribute))
		{
			return '';
		}
		if (is_resource($attribute))
		{
			return get_resource_type($attribute);
		}
		if (is_array($attribute))
		{
			return arrDisp($attribute);
		}
		if (is_object($attribute))
		{
			if (method_exists($attribute, 'display'))
			{
				return $attribute->display();
			}
			return get_class($attribute);
		}
		if (is_callable($attribute))
		{
			if ($attribute instanceOf \Closure)
			{
				return 'closure';
			}
			return '';
		}
		if (is_iterable($attribute))
		{
			return 'iterable';
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['core']['type']['unknown'], array('class' => get_class($this), 'attribute' => $attribute));

		return '';
	}
	/**
	 * Check if the associated data exist in the database
	 *
	 * @return bool
	 */
	public function exist()
	{
		$index = $this->getIndex();
		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']['managed']['exist']['missing_index'], array('class' => get_class($this)));

			return False;
		}
		return $this->manager()->exist($index);
	}
	/**
	 * Hydrate object with array
	 *
	 * @param array $attributes Array having $attribute => $value
	 *
	 * @return int Number of attributes set
	 */
	public function hydrate($attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['hydrate'], array('class' => get_class($this)));

		$count = 0;
		foreach ($attributes as $attribute => $value)
		{
			if ($this->$attribute != null)
			{
				if ($this->set($attribute, $value))
				{
					$count += 1;
				}
			}
		}
		return $count;
	}
	/**
	 * Get the value of the given attribute
	 *
	 * @param string $attribute
	 *
	 * @return mixed
	 */
	public function get(attribute: $attribute)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['get']['start']);

		if ($this->$attribute === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['class']['core']['managed']['get']['not_defined']);

			return null;
		}

		$method = $this::getGet($attribute);
		if (method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['get']['getter']);

			return $this->$method();
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['get']['default']);

		return $this->$attribute;
	}
	/**
	 * Get the name of the displayer method for the attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getDisp(attribute: $attribute)
	{
		if (count($attribute) === 0)
		{
			return '';
		}
		return 'display' . ucfirst($attribute);
	}
	/**
	 * Get the name of the getter method for the attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getGet(attribute: $attribute)
	{
		if (count($attribute) === 0)
		{
			return '';
		}
		switch (ucfirst($attribute))
		{
			case 'Disp':
			case 'Get':
			case 'Index':
			case 'Set':
				return '';
		}
		return 'get' . ucfirst($attribute);
	}
	/**
	 * Get the index values of this object
	 *
	 * @return array|False
	 */
	public function getIndex()
	{
		$index = array();
		foreach ($this::INDEX as $attribute)
		{
			$value = $this->get($attribute);
			if ($value === null)
			{
				return False;
			}
			$index[$attribute] = $value;
		}
		return $index;
	}
	/**
	 * Get the name of the setter method fore the attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getSet(attribute: $attribute)
	{
		if (count($attribute) === 0)
		{
			return '';
		}
		return 'set' . ucfirst($attribute);
	}
	/**
	 * Check if the two objects have same index value (are the same)
	 *
	 * @param object $object
	 *
	 * @return bool
	 */
	public function isIdentical(object: $objet)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['isIdentical'], array('class_1' => get_class($this), 'class_2' => get_class($objet)));

		if (get_class($this) != get_class($this))
		{
			return False;
		}
		foreach ($this::INDEX as $attribute)
		{
			if ($this->$attribute === null || $this->$attribute === null)
			{
				return False;
			}
			if ($this->get($attribute) != $object->get($attribute))
			{
				return False;
			}
		}
		return True;
	}
	/**
	 * Create an instance of the associated manager
	 *
	 * @param \PDO $connection
	 *
	 * @return mixed
	 */
	public function manager(connection: $connection = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['manager']['start'], array('class' => get_class($this)));

		$manager = get_class($this) . 'Manager';
		if (!class_exists($manager))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['log_message']['class']['core']['managed']['manager']['not_defined'], array('class' => get_class($this)));

			return null;
		}
		return new $manager($connection);
	}
	/**
	 * Retrieve data from the database
	 *
	 * @return int Number of attributes retrieved
	 */
	public function retrieve()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['retrieve']['start'], array('class' => get_class($this)));

		$count = 0;

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['retrieve']['not_defined'], array('class' => get_class($this)));

			return $count;
		}

		$index = array();
		foreach ($this::INDEX as $attribute)
		{
			$index[$attribute] = $this->get($attribute);
		}

		return $this->hydrate($this->manager()->get($index));
	}
	/**
	 * Set the value of an attribute
	 *
	 * @param string $attribute
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	protected function set(attribute: $attribute, value: $value)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['set']['start'], array('class' => get_class($this), 'attribute' => $attribute));

		if ($this->$attribute === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['class']['core']['managed']['set']['undefined'], array('class' => get_class($this), 'attribute' => $attribute));

			return False;
		}

		$method = $this::getSet($attribute);
		if (method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['set']['custom_method'], array('class' => get_class($this), 'attribute' => $attribute, 'method' => $method));

			return $this->$method($value);
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['set']['undefined'], array('class' => get_class($this), 'attribute' => $attribute));

		$this->$attribute = $value; // No type checking !
	}
	/**
	 * Convert an objet to an array
	 *
	 * @param int $depth Depth of the recursion if there is an objet in the objet, -1 for infinite, 0 for no recursion.
	 *                   Default to 0.
	 *
	 * @param object|null $object Object to convert or null for this object
	 *
	 * @return array
	 */
	public function table(depth: $depth = 0, object: $object = null)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']('managed']['table']['start'], array('class' => get_class($this)));

		$attributes = array();

		if ($depth < -1)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']('managed']['table']['depth'], array('class' => get_class($this), 'depth' => $depth));
			return $attributes;
		}
		if ($object === null)
		{
			$object = $this;
		}

		foreach (array_keys(get_class_vars(get_class($object))) as $attribute)
		{
			if (is_object($this->$attribute))
			{
				if ($depth === 0)
				{
					$attributes[$attribute] = $this->$attribute;
				}
				else
				{
					if ($depth != -1)
					{
						$depth -= 1;
					}
					$attributes[$attribute] = $this->table(object = $this->$attribute, depth = $depth);
				}
			}
			else
			{
				$attributes[$attribute] = $this->$attribute;
			}
		}
		return $attributes;
	}
	/**
	 * Update the database
	 *
	 * @return bool
	 */
	public function update()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['core']['managed']['update']['start'] array('class' => get_class($this)));

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']['managed']['update']['not_exist'], array('class' => get_class($this)));

			return False;
		}
		$index = $this->getIndex();

		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['core']['managed']['update']['missing_index'], array('class' => get_class($this)));

			return False;
		}

		$this->manager()->update($this->table(), $this->getIndex());
	}
}

?>
