<?php

/**
 * count the number of element in an array, character in a string or defined properties in an object
 * (return 0 for non valid element)
 *
 * @var mixed $var variable to count
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
 * @var mixed $var Variable to convert
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
		return \get_class($var) . ' : ' . phosphore_display((array) $var);
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

?>
