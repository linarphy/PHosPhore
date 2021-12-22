<?php

namespace core;

/**
 * Hook manager
 */
class Hook
{
	/**
	 * load associated hook
	 *
	 * @param array $event Event associated to hook
	 *
	 * @param mixed $param Parameter associated to the event
	 *
	 * @return int Number of hook loaded
	 */
	public function load(array $event, mixed $param) : int
	{
		$path_hook_dir = $GLOBALS['config']['core']['path']['hook'] . \implode(DIRECTORY_SEPARATOR, $event) . DIRECTORY_SEPARATOR;
		if (!\is_dir($path_hook_dir))
		{
			return 0;
		}

		$number_loaded = 0;
		foreach (\scandir($path_hook_dir) as $path_file)
		{
			if (\is_file($path_hook_dir . $path_file))
			{
				include($path_hook_dir . $path_file);
				$number_loaded += 1;
			}
		}

		return $number_loaded;
	}
}
