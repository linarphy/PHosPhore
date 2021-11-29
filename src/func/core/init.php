<?php

/**
 * Initialize config, locale and modules
 *
 * @return bool
 */
function init()
{

	/** config section **/

	require_once(join(DIRECTORY_SEPARATOR, array('config', 'core', 'config.php')));
	require($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']);

	/** base function **/

	require_once(join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['func'], 'core', 'utils.php')));

	/** locale section **/

	$locale = $GLOBALS['config']['core']['locale']['default'];
	if (isset($_SESSION['__locale__']))
	{
		if (in_array($_SESSION['__locale__'], $GLOBALS['config']['core']['locale']['available']))
		{
			$locale = $_SESSION['__locale__'];
		}
	}
	if (isset($_GET['__locale__']))
	{
		if (in_array($_GET['__locale__'], $GLOBALS['config']['core']['locale']['available']))
		{
			$locale = $_GET['__locale__'];
		}
	}
	require($GLOBALS['config']['core']['path']['locale'] . 'core' . DIRECTORY_SEPARATOR . $locale . '.' . $GLOBALS['config']['core']['locale']['filename']);

	/** lang section **/

	require($GLOBALS['config']['core']['path']['lang'] . 'core' . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['lang']['server'] . '.' . $GLOBALS['config']['core']['lang']['filename']);

	/** modules section **/

	$mods = array();
	foreach (scandir($GLOBALS['config']['core']['path']['mod']) as $filename)
	{
		if (is_dir($GLOBALS['config']['core']['path']['mod'] . $filename) && $filename !== '.' && $filename !== '..')
		{
			$config_file = $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['path']['mod'] . $filename . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['config']['filename'];
			if (is_file($config_file))
			{
				require($config_file);
			}

			if (isset($GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
			{
				$locale = $GLOBALS['locale']['core']['locale'];
				if (!in_array($GLOBALS['locale']['core']['locale'], $GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
				{
					$locale = $GLOBALS['config']['core']['locale']['default'];
					if (!in_array($GLOBALS['config']['core']['locale']['default'], $GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
					{
						$locale = $GLOBALS['config']['mod'][$filename]['core']['locale']['available'];
					}
				}

				$locale_file = $GLOBALS['config']['core']['path']['locale'] . $GLOBALS['config']['core']['path']['mod'] . $filename . DIRECTORY_SEPARATOR . $locale . '.' . $GLOBALS['config']['core']['locale']['filename'];
				if (is_file($locale_file))
				{
					require($locale_file);
				}

				$mods[] = $filename;
			}
		}
	}

	require($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']);

	$index_file = $GLOBALS['config']['core']['path']['mod'] . $GLOBALS['config']['core']['mod']['index_file'];
	if (is_file($index_file))
	{
		$installed = file($index_file, FILE_IGNORE_NEW_LINES);
	}
	else
	{
		$installed = array();
	}
	$file = fopen($index_file, 'a');
	foreach ($mods as $mod)
	{
		if (!in_array($mod, $installed))
		{
			$install_file = $GLOBALS['config']['core']['path']['mod'] . $mod . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['mod']['install_file'];
			if (is_file($install_file))
			{
				require($install_file);
			}
			fwrite($file, $mod . PHP_EOL);
		}
	}
	fclose($file);

	return True;
}
/**
 * Get right router constructor param
 *
 * @return int
 */
function init_router()
{
	if (in_array($GLOBALS['config']['core']['router']['default'], \route\Router::MODES))
	{
		return $GLOBALS['config']['core']['router']['default'];
	}
	$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['router']['invalid_default']);
}
/**
 * Get right visitor constructor param
 *
 * @return array
 */
function init_visitor()
{
	if (isset($_SESSION['__login__']['id']) && isset($_SESSION['__login__']['password']))
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['login']['session']);

		$Password = new \user\Password(array(
			'password_clear' => $_SESSION['__login__']['password'],
		));
		return array(
			'id'       => $_SESSION['__login__']['id'],
			'password' => $Password,
		);
	}
	$Password = new \user\Password(array(
		'password_clear' => $GLOBALS['config']['core']['login']['guest']['password'],
	));
	return array(
		'id'       => $GLOBALS['config']['core']['login']['guest']['id'],
		'password' => $Password,
	);
}
/**
 * Autoloading function
 *
 * @param string $class_name Name of the class (with namespace)
 */
function load_class($class_name)
{
	$log = False;
	if (isset($GLOBALS['Logger']))
	{
		$log = True;
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['start'], array('class' => $class_name));
	}

	$file_name = '';
	$namespace = '';

	$include_path = substr($GLOBALS['config']['core']['path']['class'], 0, -1);

	if (false !== ($last_ns_pos = strripos($class_name, '\\')))
	{
		$namespace = substr($class_name, 0, $last_ns_pos);
		$class_name = substr($class_name, $last_ns_pos + 1);
		$file_name = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name);
	$directories = explode(DIRECTORY_SEPARATOR, $file_name);
	$file_name .= '.class.php';
	$full_file_name = $include_path . DIRECTORY_SEPARATOR . $file_name;

	if (!isset($GLOBALS['cache']['core']['class_loaded']))
	{
		$GLOBALS['cache']['core']['class_loaded'] = array();
	}
	$path = $GLOBALS['config']['core']['path']['class'];
	foreach ($directories as $directory)
	{
		$path .= DIRECTORY_SEPARATOR . $directory;

		if (!in_array($path, $GLOBALS['cache']['core']['class_loaded']))
		{
			$config_file = join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['config'], $path, $GLOBALS['config']['core']['config']['filename']));
			$lang_file = join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['lang'], $path, $GLOBALS['config']['core']['lang']['server'] . '.' . $GLOBALS['config']['core']['lang']['filename']));
			$locale_file = join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['config'], $path, $GLOBALS['locale']['core']['locale'] . '.' . $GLOBALS['config']['core']['locale']['filename']));
			$default_locale_file = join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['config'], $path, $GLOBALS['config']['core']['locale']['default'] . '.'  . $GLOBALS['config']['core']['locale']['filename']));
			if (is_file($config_file))
			{
				require($config_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['config_file'], array('class' => $class_name, 'path' => $config_file));
				}
			}
			if (is_file($lang_file))
			{
				require($lang_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['lang_file'], array('class' => $class_name, 'path' => $lang_file));
				}
			}
			if (is_file($default_locale_file))
			{
				require($default_locale_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['locale_file'], array('class' => $class_name, 'path' => $default_locale_file));
				}
			}
			if (is_file($locale_file))
			{
				require($locale_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['locale_file'], array('class' => $class_name, 'path' => $locale_file));
				}
			}

			$GLOBALS['cache']['core']['class_loaded'][] = $path;
		}
	}

	require(join(DIRECTORY_SEPARATOR, array($GLOBALS['config']['core']['path']['config'], $GLOBALS['config']['core']['config']['filename'])));

	if (is_file($full_file_name))
	{
		require_once($full_file_name);
	}

	if ($log)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['end'], array('class' => $class_name));
	}
}
/**
 * Get class name without namespace
 *
 * @param string $class_name Name of the class with namespace
 *
 * @return string
 */
function get_class_name($class_name)
{
	if ($pos = strrpos($class_name, '\\')) return substr($class_name, $pos + 1);
    return $pos;
}

init();
spl_autoload_register('load_class');

?>
