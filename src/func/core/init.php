<?php

/**
 * Initialize config, locale and modules
 *
 * @return bool Can only be true or throw an exception
 */
function init()
{

	/** config section **/

	require_once(\join(DIRECTORY_SEPARATOR, ['config', 'core', 'config.php']));
	if (\is_file($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']))
	{
		require($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']);
	}

	/** base function **/

	require_once(\join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['func'], 'core', 'utils.php']));

	/** locale section **/

	$locale = $GLOBALS['config']['core']['locale']['default'];
	if (isset($_SESSION['__locale__']))
	{
		if (\in_array($_SESSION['__locale__'], $GLOBALS['config']['core']['locale']['available']))
		{
			$locale = $_SESSION['__locale__'];
		}
	}
	if (isset($_GET['__locale__']))
	{
		if (\in_array($_GET['__locale__'], $GLOBALS['config']['core']['locale']['available']))
		{
			$locale = $_GET['__locale__'];
		}
	}
	require($GLOBALS['config']['core']['path']['locale'] . 'core' . DIRECTORY_SEPARATOR . $locale . '.' . $GLOBALS['config']['core']['locale']['filename']);

	/** lang section **/

	require($GLOBALS['config']['core']['path']['lang'] . 'core' . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['lang']['server'] . '.' . $GLOBALS['config']['core']['lang']['filename']);

	/** modules section **/

	$mods = [];
	foreach (\scandir($GLOBALS['config']['core']['path']['mod']) as $filename)
	{
		if (\is_dir($GLOBALS['config']['core']['path']['mod'] . $filename) && $filename !== '.' && $filename !== '..')
		{
			$config_file = $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['path']['mod'] . $filename . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['config']['filename'];
			if (\is_file($config_file))
			{
				require($config_file);
			}

			if (isset($GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
			{
				$locale = $GLOBALS['locale']['core']['locale'];
				if (!\in_array($GLOBALS['locale']['core']['locale'], $GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
				{
					$locale = $GLOBALS['config']['core']['locale']['default'];
					if (!\in_array($GLOBALS['config']['core']['locale']['default'], $GLOBALS['config']['mod'][$filename]['core']['locale']['available']))
					{
						$locale = $GLOBALS['config']['mod'][$filename]['core']['locale']['available'];
					}
				}

				$locale_file = $GLOBALS['config']['core']['path']['locale'] . $GLOBALS['config']['core']['path']['mod'] . $filename . DIRECTORY_SEPARATOR . $locale . '.' . $GLOBALS['config']['core']['locale']['filename'];
				if (\is_file($locale_file))
				{
					require($locale_file);
				}

				$mods[] = $filename;
			}
		}
	}

	if (\is_file($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']))
	{
		require($GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename']);
	}

	$index_file = $GLOBALS['config']['core']['path']['mod'] . $GLOBALS['config']['core']['mod']['index_file'];
	if (\is_file($index_file))
	{
		$installed = \file($index_file, FILE_IGNORE_NEW_LINES);
	}
	else
	{
		$installed = [];
	}
	$file = \fopen($index_file, 'a');
	foreach ($mods as $mod)
	{
		if (!\in_array($mod, $installed))
		{
			$install_file = $GLOBALS['config']['core']['path']['mod'] . $mod . DIRECTORY_SEPARATOR . $GLOBALS['config']['core']['mod']['install_file'];
			if (\is_file($install_file))
			{
				require($install_file);
			}
			\fwrite($file, $mod . PHP_EOL);
		}
	}
	\fclose($file);

	return True;
}
/**
 * Get right router constructor param
 *
 * @return int Router mode
 */
function init_router()
{
	if (\in_array($GLOBALS['config']['core']['router']['default'], \route\Router::MODES))
	{
		return $GLOBALS['config']['core']['router']['default'];
	}
	$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['router']['invalid_default']);
}
/**
 * Get right visitor constructor param
 *
 * @return array Array needed to initialize the Visitor constructor contains id and password or has_token
 */
function init_visitor()
{
	if (!isset($_SESSION['__login__']['selector']) || !isset($_SESSION['__login__']['validator']))
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['login']['no_session']);

		$Password = new \user\Password([
			'password_clear' => $GLOBALS['config']['core']['login']['guest']['password'],
		]);

		return [
			'id'       => $GLOBALS['config']['core']['login']['guest']['id'],
			'password' => $Password,
		];
	}

	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['login']['session']);

	$Token = new \user\Token([
		'selector'        => $_SESSION['__login__']['selector'],
		'validator_clear' => $_SESSION['__login__']['validator'],
	]);

	$id_user = $Token->check();

	if ($id_user === False)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['core']['login']['bad_credential']);

		unset($_SESSION['__login__']);

		return init_visitor();
	}

	return [
		'id'    => $id_user,
		'has_token' => True,
	];
}
/**
 * Autoloading function
 *
 * @param string $class_name Name of the class (with namespace)
 *
 * @return bool Can only be true or throw an exception
 */
function load_class($class_name)
{
	$log = False;
	if (isset($GLOBALS['Logger']))
	{
		$log = True;
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['start'], ['class' => $class_name]);
	}

	$file_name = '';
	$namespace = '';

	$include_path = \substr($GLOBALS['config']['core']['path']['class'], 0, -1);

	if (false !== ($last_ns_pos = strripos($class_name, '\\')))
	{
		$namespace = \substr($class_name, 0, $last_ns_pos);
		$class_name = \substr($class_name, $last_ns_pos + 1);
		$file_name = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$file_name .= str_replace('_', DIRECTORY_SEPARATOR, $class_name);
	$directories = explode(DIRECTORY_SEPARATOR, $file_name);
	$file_name .= '.class.php';
	$full_file_name = $include_path . DIRECTORY_SEPARATOR . $file_name;

	if (!isset($GLOBALS['cache']['core']['class_loaded']))
	{
		$GLOBALS['cache']['core']['class_loaded'] = [];
	}
	$path = \substr($GLOBALS['config']['core']['path']['class'], 0, -1);
	foreach ($directories as $directory)
	{
		$path .= DIRECTORY_SEPARATOR . $directory;

		if (!\in_array($path, $GLOBALS['cache']['core']['class_loaded']))
		{
			$config_file = \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['config'], $path, $GLOBALS['config']['core']['config']['filename']]);
			$default_lang_file = \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['lang'], $path, 'en' . '.' . $GLOBALS['config']['core']['lang']['filename']]);
			$lang_file = \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['lang'], $path, $GLOBALS['config']['core']['lang']['server'] . '.' . $GLOBALS['config']['core']['lang']['filename']]);
			$locale_file = \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['locale'], $path, $GLOBALS['locale']['core']['locale']['abbr'] . '.' . $GLOBALS['config']['core']['locale']['filename']]);
			$default_locale_file = \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['locale'], $path, $GLOBALS['config']['core']['locale']['default'] . '.'  . $GLOBALS['config']['core']['locale']['filename']]);
			if (\is_file($config_file))
			{
				require($config_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['config_file'], ['class' => $class_name, 'path' => $config_file]);
				}
			}
			if (\is_file($default_lang_file))
			{
				require($default_lang_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['lang_file'], ['class' => $class_name, 'path' => $default_lang_file]);
				}
			}
			if (\is_file($lang_file))
			{
				require($lang_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['lang_file'], ['class' => $class_name, 'path' => $lang_file]);
				}
			}
			if (\is_file($default_locale_file))
			{
				require($default_locale_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['locale_file'], ['class' => $class_name, 'path' => $default_locale_file]);
				}
			}
			if (\is_file($locale_file))
			{
				require($locale_file);
				if ($log)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['locale_file'], ['class' => $class_name, 'path' => $locale_file]);
				}
			}

			$GLOBALS['cache']['core']['class_loaded'][] = $path;
		}
	}

	if (\is_file(\join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['config'], $GLOBALS['config']['core']['config']['filename']])))
	{
		require \join(DIRECTORY_SEPARATOR, [$GLOBALS['config']['core']['path']['config'], $GLOBALS['config']['core']['config']['filename']]);
	}

	if (\is_file($full_file_name))
	{
		require_once($full_file_name);
	}

	if ($log)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['autoload']['end'], ['class' => $class_name]);
	}
	return True;
}
/**
 * Get class name without namespace
 *
 * @param string $class_name Name of the class with namespace
 *
 * @return string Name of the class without namespace
 */
function get_class_name($class_name)
{
	if ($pos = \strrpos($class_name, '\\')) return \substr($class_name, $pos + 1);
    return $pos;
}
/**
 * Get value of wanted global used by PHosPHore (lang, locale, etc.)
 * for a specific type (class, func, etc.)
 *
 * @param string $global Global wanted.
 *                       Can be 'lang', 'locale', 'cache' or 'config'.
 *
 * @param array $path Path of the class we're in.
 *                    Example:
 *                    [
 *                    	'class',
 *                    	'core',
 *                    	'Base',
 *                    ]
 *
 * @return mixed Value of the global.
 *
 * @throws \UnexpectedValueException $global is not in the acceptlist or path is
 *                     badformed.
 */
function phosphore_get_globals(string $global, array $path) : mixed
{
	if (!\in_array($global, ['lang', 'locale', 'cache', 'config']))
	{
		throw \UnexpectedValueException(
			message: $global . ' is not in the accepted global list, ' .
			         'see func/core/init.php for more information',
		);
	}

	if (!\array_key_exists($global, $GLOBALS))
	{
		throw \UnexpectedValueException(
			message: $global . ' is not already defined in the ' .
			         'GLOBALS variable',
		);
	}

	$value = $GLOBALS[$global];

	foreach ($path as $part)
	{
		if (!\is_string($part))
		{
			throw \UnexpectedValueException(
				message: 'path should be an array of string, by at' .
				         'one element is a ' . \gettype($part),
			);
		}

		if (!\array_key_exists($part, $value))
		{
			throw \UnexpectedValueException(
				message: $global . ' is not defined for this class: ' .
				         $part . ' is not an available key',
			);
		}

		$value = $value[$part];
	}

	return $value;
}
/**
 * Return the cache table associated to the class where this function is
 * called
 *
 * @param string $class_name String returned by get_class function
 *
 * @return mixed
 *
 * @throws \UnexpectedValueException If the class does not define cache global
 */
function phosphore_cache(string $class_name) : mixed
{
	return \phosphore_get_globals(
		'cache',
		\explode('\\', 'class\\' . $class_name),
	);
}
/**
 * Return the config table associated to the class where this function
 * is called
 *
 * @param string $class_name String returned by get_class function
 *
 * @return mixed
 *
 * @throws \UnexpectedValueException If the class does not define config global
 */
function phosphore_config(string $class_name) : mixed
{
	return \phosphore_get_globals(
		'config',
		\explode('\\', 'class\\' . $class_name),
	);
}
/**
 * Return the lang table associated to the class where this function is
 * called
 *
 * @param string $class_name String returned by get_class function
 *
 * @return mixed
 *
 * @throws \UnexpectedValueException If the class does not define lang global
 */
function phosphore_lang(string $class_name) : mixed
{
	return \phosphore_get_globals(
		'lang',
		\explode('\\', 'class\\' . $class_name),
	);
}
/**
 * Return the locale table associated to the class where this function is
 * called
 *
 * @param string $class_name String returned by get_class function
 *
 * @return mixed
 *
 * @throws \UnexpectedValueException If the class does not define locale global
*/
function phosphore_locale(string $class_name) : mixed
{
	return \phosphore_get_globals(
		'locale',
		\explode('\'', 'class\\' . $class_name),
	);
}

init();
\spl_autoload_register('load_class');

?>
