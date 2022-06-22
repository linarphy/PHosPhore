<?php

namespace core;

/**
 * Object managed in the database
 */
abstract class Managed
{
	use \core\Base;

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
	 * Insert the object in the database
	 *
	 * @return array
	 */
	public function add() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['start'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'add', 'start'], $this);

		$index = $this->manager()->add($this->table())[0];

		if ($index === False || \phosphore_count($index) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Managed']['add']['error'], ['class' => \get_class($this)]);
			return $index;
		}

		foreach ($index as $name => $value)
		{
			$this->set($name, $value);
		}
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'add', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['add']['success'], ['class' => \get_class($this)]);
		return $index;
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
		return $display;
	}
	/**
	 * Delete the object in the database
	 *
	 * @return bool
	 */
	public function delete() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['start'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'delete', 'start'], $this);

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

		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'delete', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['delete']['success'], ['class' => \get_class($this)]);

		return $this->manager()->delete($this->getIndex());
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
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'exist', 'end'], $this);
		return $this->manager()->exist($index);
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
			}
			$index[$attribute] = $value;
		}
		return $index;
	}
	/**
	 * Check if the two objects have same index value (are the same)
	 *
	 * @param object $object
	 *
	 * @return bool
	 */
	public function isIdentical($object) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['start'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'isIdentical', 'start'], [$this, $object]);

		if (\get_class($this) !== \get_class($this))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_class'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
			return False;
		}
		foreach ($this::INDEX as $attribute)
		{
			if ($this->$attribute === null || $object->$attribute === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['missing_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($object), 'attribute' => $attribute]);
				return False;
			}
			if ($this->get($attribute) !== $object->get($attribute))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_index'], ['class_1' => \get_class($this), 'class_2' => \get_class($object), 'attribute' => $attribute]);
				return False;
			}
		}
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'isIdentical', 'end'], [$this, $object]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['isIdentical']['same'], ['class_1' => \get_class($this), 'class_2' => \get_class($object)]);
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

		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'manager', 'end'], $this);
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
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'retrieve', 'start'], $this);

		if (!$this->exist())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['not_defined'], ['class' => \get_class($this)]);

			throw new \Exception($GLOBALS['locale']['class']['core']['Managed']['retrieve']['not_exist']);
		}
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'retrieve', 'check'], $this);

		$index = [];
		foreach ($this::INDEX as $attribute)
		{
			$index[$attribute] = $this->get($attribute);
		}

		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'retrieve', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['retrieve']['end'], ['class' => \get_class($this)]);

		$this->hydrate($this->manager()->get($index));

		return $this;
	}
	/**
	 * Update the database
	 *
	 * @return bool
	 */
	public function update() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Managed']['update']['start'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'update', 'start'], $this);

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

		$GLOBALS['Hook']->load(['class', 'core', 'Managed', 'update', 'end'], $this);
		$this->manager()->update(\array_diff_key($this->table(), $this->getIndex()), $this->getIndex());

		return True;
	}
}

?>
