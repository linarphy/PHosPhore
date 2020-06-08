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
	$real_className=$className;
	if (class_exists('\exception\Notice'))
	{
		new \exception\Notice($GLOBALS['lang']['load_class'].' '.$real_className, 'loadclass');
	}
	$fileName = '';
	$namespace = '';

	$includePath = 'class';

	if (false !== ($lastNsPos = strripos($className, '\\')))
	{
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
	$directories=explode(DIRECTORY_SEPARATOR, $fileName);
	$fileName .= '.class.php';
	$fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;

	global $Visitor;
	$lang = $GLOBALS['config']['user_config']['lang'];
	if (isset($Visitor))
	{
		if ($Visitor->getConfigurations()!==null)
		{
			if (isset($Visitor->getConfigurations()['lang']))
			{
				$lang = $Visitor->getConfiguration('lang');
			}
		}
	}
	$lang_len = strlen($lang);
	$fullFileNameConfig = 'config' . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'config.php';
	$fullFileNameLang = 'lang' . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $lang . '.lang.php';
	foreach ($directories as $directory)
	{
		$fullFileNameConfig = substr_replace($fullFileNameConfig, strtolower($directory) . DIRECTORY_SEPARATOR, -10, 0);
		$fullFileNameLang = substr_replace($fullFileNameLang, strtolower($directory) . DIRECTORY_SEPARATOR, - ( 9 + $lang_len ), 0);
		if (file_exists($fullFileNameConfig))
		{
			require_once($fullFileNameConfig);
			if (class_exists('\exception\Notice'))
			{
				new \Exception\Notice($fullFileNameLang.' '.$GLOBALS['lang']['config_file_loaded'], 'loadclass');
			}
		}
		if (file_exists($fullFileNameLang))
		{
			require_once($fullFileNameLang);
			if (class_exists('\exception\Notice'))
			{
				new \Exception\Notice($fullFileNameLang.' '.$GLOBALS['lang']['lang_file_loaded'], 'loadclass');
			}
		}
	}

	if (file_exists($fullFileName))
	{
		require_once$fullFileName;
	}
	else
	{
		throw new \exception\Error($real_className.' '.$GLOBALS['lang']['class_not_exist'], 'loadclass');
	}

	new \exception\Notice($real_className.' '.$GLOBALS['lang']['class_loaded'], 'loadclass');
}
/**
 * Initializes confifuration files
 *
 * @return void
 * @author gugus2000
 **/
function init_conf()
{
	require('./config/core/config.php');
	$mods=array();
	foreach (scandir('./config/mod') as $filename)
	{
		if (substr($filename, -4)==='.php')
		{
			require('./config/mod/'.$filename);
			$mods[]=substr($filename,0,-4);
		}
	}
	require('./config/config.php');
	require($GLOBALS['config']['path_lang'].$GLOBALS['config']['user_config']['lang'].'.lang.php');
	foreach ($mods as $mod)
	{
		new \exception\Notice($GLOBALS['lang']['mod_added'].' '.$mod, 'init');
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
	if (!$GLOBALS['config']['route_mode_strict'])
	{
		if (isset($_GET['custom_route_mode']))
		{
			if (isset($_GET['custom_route_mode_session']))
			{
				if ($_GET['custom_route_mode_session'])
				{
					$_SESSION['custom_route_mode']=$_GET['custom_route_mode'];
					new \exception\Notice($GLOBALS['lang']['router_set_session'], 'init');
				}
				else
				{
					unset($_SESSION['custom_route_mode']);
					new \exception\Notice($GLOBALS['lang']['router_unset_session'], 'init');
				}
				unset($_GET['custom_route_mode_session']);
			}
			$route_mode=$_GET['custom_route_mode'];
			new \exception\Notice($GLOBALS['lang']['router_get'].' '.$route_mode, 'init');
			unset($_GET['custom_route_mode']);
		}
		if (isset($_SESSION['custom_route_mode']))
		{
			$route_mode=$_SESSION['custom_route_mode'];
			new \exception\Notice($GLOBALS['lang']['router_use_session'].' '.$route_mode, 'init');
		}
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
		new \exception\Notice($GLOBALS['lang']['visitor_connected_session_start'].' '.$_SESSION['nickname'].' '.$GLOBALS['lang']['visitor_connected_session_end'], 'init');
		return array(
			'id'       => $_SESSION['id'],
			'nickname' => $_SESSION['nickname'],
		);
	}
	$_SESSION['password']=$GLOBALS['config']['guest_password'];
	new \exception\Notice($GLOBALS['lang']['visitor_guest'], 'init');
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

?>