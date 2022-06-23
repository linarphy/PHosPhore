<?php

namespace core;

/**
 * core basic methods
 */
trait Base
{
	/**
	 * Constructor
	 *
	 * @param array $attributes Defined values of the object attributes
	 */
	public function __construct(array $attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['__construct'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', '__construct', 'start'], [$this, $attributes]);

		$this->hydrate($attributes);

		$GLOBALS['Hook']::load(['class', 'core', 'Base', '__construct', 'end'], [$this, $attributes]);
	}
	/**
	 * Clone the object (return a new one with the same attributes)
	 *
	 * @return self
	 */
	public function clone() : self
	{
		$class = \get_class($this);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'clone', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['clone'], ['class' => $class]);
		return new $class($this->table());
	}
	/**
	 * Convert this object or one of its attribute into a safe and readable form
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);

		if ($attribute === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['object'], ['class' => \get_class($this)]);
			return \htmlspecialchars(\phosphore_display($this->table()));
		}

		if (!\property_exists($this, $attribute))
		{
			var_dump($this, $attribute);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Base']['display']['undefined'], ['class' => \get_class($this), 'attribute' => $attribute]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['display']['undefined']);
		}

		$method = $this::getDisp($attribute);

		if (\method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['exist'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
			return $this->$method($attribute);
		}

		if (\is_object($this->get($attribute)))
		{
			if (\method_exists($this->get($attribute), 'display'))
			{
				return $this->get($attribute)->display();
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['display']['not_exist'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
		return \htmlspecialchars(\phosphore_display($this->get($attribute)));
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
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'start'], [$this, $attribute]);

		if (!\property_exists($this, $attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Base']['get']['not_defined'], ['class' => \get_class($this), 'attribute' => $attribute]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['get']['not_defined']);
		}

		$method = $this::getGet($attribute);

		if (\method_exists($this, $method))
		{
			$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'end'], [$this, $attribute]);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['getter'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
			return $this->$method();
		}

		if (!isset($this->$attribute))
		{
			return null;
		}

		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'get', 'end'], [$this, $attribute]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['get']['default'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
		return $this->$attribute;
	}
	/**
	 * Get the name of the displayer method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getDisp(string $attribute) : string
	{
		if (empty($attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Base']['getDisp']['empty'], ['class' => \get_class($this), 'attribute' => $attribute]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['getDisp']['empty']);
		}

		return 'display' . \ucfirst($attribute);
	}
	/**
	 * Get the name of the getter method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getGet(string $attribute) : string
	{
		if (empty($attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Base']['getGet']['empty'], ['class' => \get_class($this), 'attribute' => $attribute]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['getGet']['empty']);
		}

		switch (\ucfirst($attribute)) // special case where the getter method name is already taken
		{
			case 'Get':
			case 'Set':
			case 'Disp':
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Base']['getGet']['special'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => 'get_' . \ucfirst($attribute)]);
				return 'get_' . \ucfirst($attribute);
		}

		return 'get' . \ucfirst($attribute);
	}
	/**
	 * Get the name of the setter method for an attribute
	 *
	 * @param string $attribute
	 *
	 * @return string
	 */
	public static function getSet(string $attribute) : string
	{
		if (empty($attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Base']['getSet']['empty'], ['class' => \get_class($this), 'attribute' => $attribute]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['getSet']['empty']);
		}

		return 'set' . \ucfirst($attribute);
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
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['hydrate']['start'], ['class' => \get_class($this)]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'hydrate', 'start'], [$this, $attributes]);

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

		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'hydrate', 'end'], [$this, $attributes]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['hydrate']['end'], ['class' => \get_class($this), 'count' => $count]);
		return $count;
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
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['start'], ['class' => \get_class($this), 'attribute' => $attribute]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'start'], [$this, $attribute, $value]);

		if (!\property_exists($this, $attribute))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Base']['set']['undefined'], ['class' => \get_class($this), 'attribute' => $attribute]);
			return False;
		}

		$method = $this::getSet($attribute);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'check'], $this);

		if (\method_exists($this, $method))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['custom_method'], ['class' => \get_class($this), 'attribute' => $attribute, 'method' => $method]);
			return $this->$method($value);
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['set']['default_method'], ['class' => \get_class($this), 'attribute' => $attribute]);
		$this->$attribute = $value;
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'set', 'end'], $this);
		return True;
	}
	/**
	 * Convert an object to an array
	 *
	 * @param int $depth Depth of the recursion if there is an object, -1 for infinite, 0 for no recursion.
	 *                   Default to 0.
	 *
	 * @param bool $strict If True, null value will be displayed, but it can throw fatal error if every properties are not initialized.
	 *                     Default to False;
	 *
	 * @return array
	 */
	public function table(int $depth = 0, bool $strict = False) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Base']['table']['start'], ['class' => \get_class($this), 'depth' => $depth]);
		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'start'], [$this, $depth]);

		$attributes = [];

		if ($depth < -1)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['Base']['table']['undefined_depth'], ['class' => \get_class($this), 'depth' => $depth]);
			throw new \Exception($GLOBALS['locale']['class']['core']['Base']['table']['undefined_depth']);
		}

		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'check'], [$this, $depth]);

		foreach (\array_keys(\get_class_vars(\get_class($this))) as $attribute)
		{
			if ($strict || isset($this->$attribute))
			{
				if (\is_object($this->$attribute))
				{
					if ($depth === 0)
					{
						$attributes[$attribute] = $this->$attribute;
					}
					else if ($depth > 0)
					{
						$attributes[$attribute] = \phosphore_table($this->$attribute, $depth - 1);
					}
					else // depth === -1
					{
						$attributes[$attribute] = \phosphore_table($this->$attribute, $depth);
					}
				}
				else
				{
					$attributes[$attribute] = $this->$attribute;
				}
			}
		}

		$GLOBALS['Hook']::load(['class', 'core', 'Base', 'table', 'end'], [$this, $depth]);
		return $attributes;
	}
}

?>
