<?php

/**
 * Returns the class name without its namespace
 *
 * @param string $className Name of the class
 * 
 * @return string
 * @author pierstoval at gmail dot com
 **/
function get_class_name($className)
{
    if ($pos = strrpos($className, '\\')) return substr($className, $pos + 1);
    return $pos;
}
/**
 * Loads the class dynamically
 * 
 * @param string $className Name of the class
 *
 * @return void
 * @author  dave at shax dot com
 **/
function loadClass($className)
{
	$fileName = '';
	$namespace = '';
	$includePath = 'class';

	if (false !== ($lastNsPos = strripos($className, '\\')))
	{
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.class.php';
	$fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

	if (file_exists($fullFileName))
	{
		require_once $fullFileName;
	}
	else
	{
		throw new \Exception('Class "'.$className.'" does not exist.');
	}
}
/**
 * Polyfill of array_key_first
 *
 * @author PHP (PHP.net)
 **/
if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
/**
 * Initiates routing with the session and $_GET
 *
 * @return string
 * @author gugus2000
 **/
function init_router()
{
	$route_mode=$GLOBALS['config']['route_mode'];
	if (isset($_GET['custom_route_mode']))
	{
		if (isset($_GET['custom_route_mode_session']))
		{
			if ((bool)$_GET['custom_route_mode_session'])
			{
				$_SESSION['custom_route_mode']=$_GET['custom_route_mode'];
			}
			else
			{
				unset($_SESSION['custom_route_mode']);
			}
			unset($_GET['custom_route_mode_session']);
		}
		$route_mode=$_GET['custom_route_mode'];
		unset($_GET['custom_route_mode']);
	}
	if (isset($_SESSION['custom_route_mode']))
	{
		$route_mode=$_SESSION['custom_route_mode'];
	}
	return $route_mode;
}
/**
 * Initializes the visitor according to the session
 *
 * @return array
 * @author gugus2000
 **/
function init_visitor()
{
	if (isset($_SESSION['nickname']) && isset($_SESSION['password']) && isset($_SESSION['id']))
	{
		return array(
			'id'       => $_SESSION['id'],
			'nickname' => $_SESSION['nickname'],
		);
	}
	$_SESSION['password']=$GLOBALS['config']['guest_password'];
	return array(
		'id'       => $GLOBALS['config']['guest_id'],
		'nickname' => $GLOBALS['config']['guest_nickname'],
	);
}
/**
 * Retrieves the array of keys from a multi-dimensional array
 *
 * @return array
 * @author Meliborn at https://stackoverflow.com/questions/11234852/how-to-get-all-the-key-in-multi-dimensional-array-in-php (edited by gugus2000)
 **/
function array_keys_multi($array)
{
    $keys = array();

    foreach ($array as $key => $value) {

        if (!is_array($value))		// I don't want key of array to be given
        {
	        $keys[] = $key;
        }
        else
        {
            $keys = array_merge($keys, array_keys_multi($value));
        }
    }

    return $keys;
}
/**
 * flatten an arbitrarily deep multidimensional array
 * into a list of its scalar values
 * (may be inefficient for large structures)
 *  (will infinite recurse on self-referential structures)
 *  (could be extended to handle objects)
 *
 * @return array
 * @author Anonymous at https://www.php.net/manual/fr/function.array-values.php
*/
function array_values_recursive($ary)
{
   $lst = array();
   foreach( array_keys($ary) as $k ){
      $v = $ary[$k];
      if (is_scalar($v)) {
         $lst[] = $v;
      } elseif (is_array($v)) {
         $lst = array_merge( $lst,
            array_values_recursive($v)
         );
      }
   }
   return $lst;
}

/**
 * Utility function for getting random values with weighting
 *
 * @param array weightedValues
 *
 * @return mixed
 * @author Brad at https://stackoverflow.com/questions/445235/generating-random-results-by-weight-in-php
 **/
function getRandomWeightedElement(array $weightedValues) {
	$rand = mt_rand(1, (int) array_sum($weightedValues));
	foreach ($weightedValues as $key => $value)
	{
		$rand -= $value;
		if ($rand <= 0)
		{
			return $key;
		}
	}
}

?>