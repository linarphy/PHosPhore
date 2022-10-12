<?php

/**
 * count the number of element in an array, character in a string or defined properties in an object
 * (return 0 for non valid element)
 *
 * @param mixed $var variable to count
 *
 * @return int number of elements
 */
function phosphore_count(mixed $var)
{
	if (\is_array($var))
	{
		return \count($var);
	}
	else if (\is_string($var))
	{
		return \iconv_strlen($var, 'UTF-8') ? : 0;	// return False
	}
	else if (\is_object($var))
	{
		return \count(\array_filter((array)$var, function($element)	// return defined properties (not null)
		{
			return !\is_null($element);
		}));
	}
	return 0;
}

/**
 * convert nearly anything to a string (not protected for html, use html_special_chars)
 *
 * @param mixed $var Variable to convert
 *
 * @return string string conversion result
 */
function phosphore_display(mixed $var)
{
	if (\is_string($var))
	{
		return $var;
	}
	if (\is_bool($var))
	{
		return ($var ? 'True' : 'False');
	}
	if (\is_int($var) || \is_float($var))
	{
		return (string) $var;
	}
	if (\is_null($var))
	{
		return 'null';
	}
	if (\is_resource($var))
	{
		return \get_resource_type($var);
	}
	if (\is_array($var))
	{
		$ret = 'array (';
		foreach ($var as $key => $el)
		{
			$ret .= ' ' . phosphore_display($key) . ' => ' . phosphore_display($el);
		}
		return $ret . ' )';
	}
	if (\is_object($var))
	{
		return \get_class($var) . ' : ' . phosphore_display(phosphore_table($var, 3)); // arbitrary recursion value
	}
	if (\is_callable($var))
	{
		if ($var instanceOf \Closure)
		{
			return 'a closure';
		}
		return 'unknown callable';
	}
	if (\is_iterable($var))
	{
		return 'iterable';
	}
	return 'cannot convert the variable that should be here to a string';
}
/**
 * convert any object into a table
 *
 * @param int $depth Depth of the recursion if there is an object. -1 for infinite, 0 for no recursion.
 *                   Default to 0.
 *
 * @param object $object Object to convert
 *
 * @return array
 */
function phosphore_table(object $object, int $depth = 0) : array
{
	if (\in_array(\core\Base::class, \class_uses($object)))
	{
		return $object->table();
	}

	$attributes = [];

	if ($depth < -1)
	{
		throw new \Exception('Depth cannot be below -1');
	}

	foreach (\array_keys(\get_class_vars(\get_class($object))) as $attribute)
	{
		if (\is_object($object->$attribute))
		{
			if ($depth === 0)
			{
				$attributes[$attribute] = $object->$attribute;
			}
			else if ($depth > 0)
			{
				$attributes[$attribute] = phosphore_table($object->$attribute, $depth - 1);
			}
			else // depth === -1
			{
				$attributes[$attribute] = phosphore_table($object->$attribute, $depth);
			}
		}
		else
		{
			$attributes[$attribute] = $object->$attribute;
		}
	}

	return $attributes;
}
/**
 * check if the element of a deep array is set
 *
 * @param array $keys
 *
 * @param array $array
 *
 * @return bool
 */
function phosphore_element_exists(array $keys, array $array) : bool
{
	foreach ($keys as $key)
	{
		if (!\key_exists($key, $array))
		{
			return False;
		}
		$array = $array[$key];
	}

	return True;
}

?>
