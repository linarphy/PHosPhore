<?php

namespace core;

/**
 * Manage server logs
 */
class Logger
{
	/**
	 * Folder where logs are stored
	 *
	 * @var string
	 */
	protected $folder;
	/**
	 * Vanilla types
	 *
	 * @var array
	 */
	const TYPES = array(
		'debug'   => 'debug',
		'info'    => 'info',
		'warning' => 'warning',
		'error'   => 'error',
		'others'  => 'others',
	);
	/**
	 * Log an event in the logs
	 *
	 * @param string $type Type of the event
	 *
	 * @param string $message Message of the event
	 *
	 * @param array $substitution Substitution array, which contains list of string to replace placeholder
	 */
	public function log($type, $message, $substitution = array())
	{
		$config = $GLOBALS['config']['class']['core']['Logger'];

		/* manage content */

		$tokens = preg_split('/({(?:\\}|[^\\}])+})/', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

		if (count($substitution) < 0)
		{
			foreach ($substitution as $name => $value)
			{
				if (in_array('{' . $name . '}', $tokens))
				{
					foreach (array_keys($tokens, '{' . $name . '}') as $key)
					{
						$tokens[$key] = $value;
					}
				}
			}
		}

		$message = implode($tokens);

		$tokens = preg_split('/({(?:\\}|[^\\}])+})/Um', $config['format'], -1, PREG_SPLIT_DELIM_CAPTURE);

		$backtrace = debug_backtrace();
		$key = array_search(__FUNCTION__, array_column($backtrace, 'function'));
		$backtrace = $backtrace[$key];

		foreach ($tokens as $key => $token)
		{
			switch ($token)
			{
				case '{date}':
					$tokens[$key] = date($config['date_format']);
					break;
				case '{file}':
					$tokens[$key] = $backtrace['file'];
					break;
				case '{line}':
					$tokens[$key] = $backtrace['line'];
					break;
				case '{message}':
					$tokens[$key] = $message;
					break;
				case '{type}':
					$tokens[$key] = $type;
					break;
			}
		}
		$content = implode($tokens) . PHP_EOL;

		/* manage file */

		if ( $config['logged_types'] === '*' || in_array($type, $config['logged_types']))
		{
			if (!is_dir($config['directory']))
			{
				if (!mkdir($config['directory'], 0774))
				{
					throw new \Exception('cannot create the directory ' . $config['directory'] . '. Please check permissions');
				}
			}

			$directory = $config['directory'] . DIRECTORY_SEPARATOR . $type;
			if (!is_dir($directory))
			{
				if (!mkdir($directory, 0774))
				{
					throw new \Exception('cannot create the directory ' . $directory . '. Please check permissions');
				}
			}

			$file = fopen($directory . DIRECTORY_SEPARATOR . 'log.txt', 'a');
			if (!$file)
			{
				throw new \Exception('cannot create the log file ' . $directory . DIRECTORY_SEPARATOR . 'log.txt');
			}
			fwrite($file, $content);
			if (!fclose($file))
			{
				throw new \Exception('cannot close the log file ' . $directory . DIRECTORY_SEPARATOR . 'log.txt');
			}
		}
	}
}

?>
