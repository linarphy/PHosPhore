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
	const INDEX = [];
	/** Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [];
	/**
	 * Constructor
	 *
	 * @param array $attributes Defined values of the object attributes
	 */
	public function __construct(array $attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['__construct'], ['class' => \get_class($this)]);

		$this->hydrate($attributes);

		return $this;
	}
	/**
	 * Insert the object in the database
	 *
	 * @return bool
	 */
	public function add() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['start'], ['class' => \get_class($this)]);

		$index = $this->manager()->add($this->table());

		if ($index === False || \phosphore_count($index) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Managed']['add']['error'], ['class' => \get_class($this)]);
			return $index;
		}

		foreach ($index as $name => $value)
		{
			$this->set($name, $value);
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['success'], ['class' => \get_class($this)]);
		return True;
	}
	/**
	 * Display a given array into a readable and safe form
	 *
	 * @param array $list Array to display
	 *
	 * @return string
	 */
	public static function arrDisp(array $list) : string
	{
		$display = '';
		if (\count($list) === 0)
		{
			return $display;
		}
		foreach ($list as $element)
		{
			if (\is_string($element))
			{
				$display .= \htmlspecialchars($element);
			}
			else if (\is_bool($element))
			{
				$display .= ($element ? 'True' : 'False');
			}
			else if (\is_int($element) || \is_float($element))
			{
				$display .= (string) $element;
			}
			else if (\is_null($element))
			{
				$display .= '';
			}
			else if (\is_resource($element))
			{
				$display .= \get_resource_type($element);
			}
			else if (is_array($element))
			{
				$display .= '(' . self::arrDisp($element) . ')';
			}
			else if (\is_object($element))
			{
				if (\method_exists($element, 'display'))
				{
					$display .= $element->display();
				}
				$display .= \get_class($element);
			}
			else if (\is_callable($element))
			{
				if ($element instanceOf \Closure)
				{
					$display .= 'closure';
				}
				$display .= 'unknown';
			}
			else if (\is_iterable($element))
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
	 *
	 * @return \core\Managed
	 */
	public function clone() : self
	{
		$class = \get_class($this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['clone'], ['class' => $class]);
		return new $class($this->table());
	}
	/**
	 * Delete the object in the database
	 *
	 * @return bool
	 */
	public function delete() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['start'], ['class' => \get_class($this)]);

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['delete']['not_exist'], ['class' => \get_class($this)]);

			return False;
		}
		$index = $this->getIndex();
		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['delete']['missing_index'], ['class' => \get_class($this)]);

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['success'], ['class' => \get_class($this)]);

		return $this->manager()->delete($this->getIndex());
	}
	/**
	 * Convert this object into a safe and readable form
	 *
	 * @return string
	 */
	public function display() : string
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
	public function displayer(string $attribute) : string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['displayer']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);

		$display = $this::getDisp($attribute);
		if (\method_exists($this, $display))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['displayer']['exist'], ['class' => \get_class($this), 'attribute' => $attribute]);

			return $this->$display();
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['displayer']['not_exist'], ['class' => \get_class($this), 'attribute' => $attribute]);

		$attribute = $this->get($attribute);

		if (\is_string($attribute))
		{
			return \htmlspecialchars($attribute);
		}
		if (\is_bool($attribute))
		{
			if ($attribute)
			{
				return 'True';
			}
			return 'False';
		}
		if (\is_int($attribute) || \is_float($attribute))
		{
			return (string) $attribute;
		}
		if (\is_null($attribute))
		{
			return '';
		}
		if (\is_resource($attribute))
		{
			return \get_resource_type($attribute);
		}
		if (is_array($attribute))
		{
			return self::arrDisp($attribute);
		}
		if (\is_object($attribute))
		{
			if (\method_exists($attribute, 'display'))
			{
				return $attribute->display();
			}
			return \get_class($attribute);
		}
		if (\is_callable($attribute))
		{
			if ($attribute instanceOf \Closure)
			{
				return 'closure';
			}
			return '';
		}
		if (\is_iterable($attribute))
		{
			return 'iterable';
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['core']['type']['unknown']);

		return '';
	}
	/**
	 * Check if the associated data exist in the database
	 *
	 * @return bool
	 */
	public function exist() : bool
	{
		$index = $this->getIndex();
		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['exist']['missing_index'], ['class' => \get_class($this)]);

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
	public function hydrate(array $attributes) : int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['hydrate']['start'], ['class' => \get_class($this)]);

		$count = 0;
		foreach ($attributes as $attribute => $value)
		{
			if (\property_exists($this, $attribute))
			{
				if ($this->set($attribute, $value))
				{
					$count += 1;
				}
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['hydrate']['end'], ['class' => \get_class($this), 'count' => $count]);
		return $count;
	}
	/**
	 * Get the value of the given attribute
	 *
	 * @param string $attribute
	 *
	 * @return mixed
	 */
	public function get(string $attribute) : mixed
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['get']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);

		if (!\property_exists($this, $attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Managed']['get']['not_defined'], ['class' => \get_class($this), 'attribute' => $attribute]);

			return null;
		}

		$method = $this::getGet($attribute);
		if (\method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['get']['getter'], ['class' => \get_class($this), 'attribute' => $attribute]);

			return $this->$method();
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['get']['default'], ['class' => \get_class($this), 'attribute' => $attribute]);

		return $this->$attribute;
	}
	/**
	 * Get the name of the displayer method for the attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getDisp(string $attribute) : string
	{
		if (\phosphore_count($attribute) === 0)
		{
			return '';
		}
		return 'display' . \ucfirst($attribute);
	}
	/**
	 * Get the name of the getter method for the attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getGet(string $attribute) : string
	{
		if (\phosphore_count($attribute) === 0)
		{
			return '';
		}
		switch (\ucfirst($attribute))
		{
			case 'Disp':
			case 'Get':
			case 'Index':
			case 'Set':
				return '';
		}
		return 'get' . \ucfirst($attribute);
	}
	/**
	 * Get the index values of this object
	 *
	 * @return null|False
	 */
	public function getIndex() : ?array
	{
		$index = [];
		foreach ($this::INDEX as $attribute)
		{
			$value = $this->get($attribute);
			if ($value === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Managed']['getIndex'], ['attribute' => $attribute]);
				throw new \Exception($GLOBALS['locale']['class']['core']['Managed']['getIndex']);
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
	public static function getSet(string $attribute) : string
	{
		if (\phosphore_count($attribute) === 0)
		{
			return '';
		}
		return 'set' . \ucfirst($attribute);
	}
	/**
	 * Check if the two objects have same index value (are the same)
	 *
	 * @param object $object
	 *
	 * @return bool
	 */
	public function isIdentical($objet) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['start'], ['class_1' => \get_class($this), 'class_2' => \get_class($objet)]);

		if (\get_class($this) !== \get_class($this))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_class'], ['class_1' => \get_class($this), 'class_2' => \get_class($objet)]);
			return False;
		}
		foreach ($this::INDEX as $attribute)
		{
			if ($this->$attribute === null || $object->$attribute === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['missing_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($objet), 'attribute' => $attribute]);
				return False;
			}
			if ($this->get($attribute) !== $object->get($attribute))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($objet), 'attribute' => $attribute]);
				return False;
			}
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['same'], ['class_1' => \get_class($this), 'class_2' => \get_class($objet)]);
		return True;
	}
	/**
	 * Create an instance of the associated manager
	 *
	 * @param \PDO $connection
	 *
	 * @return mixed
	 */
	public function manager(\PDO $connection = null) : mixed
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['manager']['start'], ['class' => \get_class($this)]);

		$manager = \get_class($this) . 'Manager';
		if (!\class_exists($manager))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Managed']['manager']['not_defined'], ['class' => \get_class($this)]);

			return null;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['manager']['end'], ['class' => \get_class($this)]);
		return new $manager($connection);
	}
	/**
	 * Retrieve data from the database
	 *
	 * @return \core\Managed Number of attributes retrieved
	 */
	public function retrieve() : self
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['start'], ['class' => \get_class($this)]);

		$count = 0;

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['not_defined'], ['class' => \get_class($this)]);

			return $count;
		}

		$index = [];
		foreach ($this::INDEX as $attribute)
		{
			$index[$attribute] = $this->get($attribute);
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['end'], ['class' => \get_class($this)]);

		$this->hydrate($this->manager()->get($index));

		return $this;
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
	public function set(string $attribute, mixed $value) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['set']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);

		if (!\property_exists($this, $attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Managed']['set']['undefined'], ['class' => \get_class($this), 'attribute' => $attribute]);

			return False;
		}

		$method = $this::getSet($attribute);
		if (\method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['set']['custom_method'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);

			return $this->$method($value);
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['set']['default_method'], ['class' => \get_class($this), 'attribute' => $attribute]);
		if (\key_exists($attribute, $this::ATTRIBUTES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['set']['typed_attribute'], ['class' => \get_class($this), 'attribute' => $attribute]);

			switch ($this::ATTRIBUTES[$attribute])
			{
				case 'int':
					$value = (int) $value;
					break;
				case 'string':
					$value = (string) $value;
					break;
				case 'bool':
					$value = (bool)  $value;
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['set']['unkown_type'], ['type' => $this::ATTRIBUTES[$attribute]]);
					break;
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['set']['not_typed'], ['class' => \get_class($this), 'attribute' => $attribute]);
		}

		$this->$attribute = $value; // No type checking !

		return True;
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
	public function table(int $depth = 0, object $object = null) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['table']['start'], ['class' => \get_class($this), 'depth' => $depth]);

		$attributes = [];

		if ($depth < -1)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['table']['undefined_depth'], ['class' => \get_class($this), 'depth' => $depth]);
			return $attributes;
		}
		if ($object === null)
		{
			$object = $this;
		}

		foreach (\array_keys(\get_class_vars(\get_class($object))) as $attribute)
		{
			if (\is_object($this->$attribute))
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
					$attributes[$attribute] = $this->table($depth, $this->$attribute);
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
	public function update() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['update']['start'], ['class' => \get_class($this)]);

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Managed']['update']['not_exist'], ['class' => \get_class($this)]);

			return False;
		}
		$index = $this->getIndex();

		if ($index === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['managed']['update']['missing_index'], ['class' => \get_class($this)]);

			return False;
		}

		$this->manager()->update($this->table(), $this->getIndex());
	}
}

?>
