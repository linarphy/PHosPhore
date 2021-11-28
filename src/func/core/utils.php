<?php

/**
 * count the number of element in an array, character in a string or defined properties in an object
 * (return 0 for non valid element)
 *
 * @var mixed $var variable to count
 */
function phosphore_count(mixed $var)
{
	if (is_array($var))
	{
		return count($var);
	}
	else if (is_string($var))
	{
		return iconv_strlen($var, 'UTF-8') ? : 0;	// return False
	}
	else if (is_object($var))
	{
		return count(array_filter((array)$var, function($element)	// return defined properties (not null)
		{
			return !is_null($element);
		}));
	}
	return 0;
}

?>
