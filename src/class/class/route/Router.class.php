<?php

namespace route;

/**
 * Manage, create and cut internals links
 */
class Router
{
	/**
	 * Operating mode of the router
	 *
	 * @var int
	 */
	protected $mode;
	/**
	 * List of operating modes for Router
	 *
	 * @var array
	 */
	const MODES = array(
		'get' => 1,
		'mixed' => 2,
		'route' => 3,
	);
	/**
	 * constructor
	 *
	 * @param int $mode Operating mode of the router
	 */
	public function __construct(mode: $mode)
	{
		$this->set('mode', $mode);
	}
	/**
	 * clean non wanted parameters (or not corresponding to the format) from a parameters list for a page
	 *
	 * @param array $parameters Parameters to clean
	 *
	 * @return array
	 */
	public function cleanParameters(parameters: $parameters, page: $page)
	{
		if (!$page instanceOf '\route\Route')
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['cleanParameters']['bad_page']);

			return array();
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['cleanParameters']['start'], array('page' => $page->display()));

		$expected_parameters = $page->retrieveParameters();
		$cleaned_parameters = array();

		foreach ($expected_parameters as $expected_parameter)
		{
			foreach ($parameters as $parameter)
			{
				if (preg_match($expected_parameter->getFullRegex(), $parameter))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['cleanParameters']['found'], array('page' => $page->display(), 'name' => $expected_parameter->get('name'), 'value' => $parameter, 'regex' => $expected_parameter->getFullRegex()));
					$cleaned_parameters[$expected_parameter->get('name')] = $parameter;
					break;
				}
			}
			if ($expected_parameter->get('necessary'))
			{
				if ($cleaned_parameters[$expected_parameter->get('name')] === null)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['cleanParameters']['missing'], array('page' => $page->display(), 'name' => $expected_parameter->get('name'), 'regex' => $expected_parameter->getFullRegex()));

					$Notification = new \user\Notification(array(
						'text'         => $GLOBALS['locale']['class']['route']['router']['missing_parameter'],
						'substitution' => array('name' => $expected_parameter->get('name'), 'regex' => $expected_parameter->get('regex')),
						'type'         => \user\Notification::TYPES['error'],
					));

					if ($page != $GLOBALS['config']['core']['route']['error']) // infinite loading
					{
						header('location: ' . $this->createLink($GLOBALS['config']['core']['route']['error']));
						exit();
					}
					else
					{
						throw new \Exception($GLOBALS['locale']['class']['route']['router']['cleanParameters']['missing_parameter']);
					}
				}
			}
		}
		return $cleaned_parameters;
	}
	/**
	 * Create an intern link with the given array
	 *
	 * @param array $routes Array which can force a chosen path to the route
	 *
	 * @param array $parameters Parameters to add to the link
	 *
	 * @return string
	 */
	public function createLink(routes: $routes, parameters: $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['route']['router']['createLink']['empty']);
			return '';
		}
		switch ($this->mode)
		{
			case $this::MODE['get']:
				return $this->createLinkGet($routes, $parameters);
			case $this::MODE['mixed']:
				return $this->createLinkMixed($routes, $parameters);
			case $this::MODE['route']:
				return $this->createLinkRoute($routes, $parameters);
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['log_message']['class']['route']['router']['createLink']['mode'], array('mode' => $this->mode));
				return '';
		}
	}
	/**
	 * Create an intern link with the given array for the mode get
	 *
	 * @param array $routes Array which can force a chosen path to the route
	 *
	 * @param array $parameters Parameters to add to the link
	 *
	 * @return string
	 */
	public function createLinkGet(routes: $routes, parameters: $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['route']['router']['createLinkGet']['empty']);
			return '';
		}

		$link = '?__path__=';
		$parent = null;
		foreach ($routes as $route)
		{
			if ($route->get('type') === \route\Route::TYPES['folder'])
			{
				$path = $route->getPath($parent);
				if ($path != False)
				{
					$link .= urlencode($path);
					$parent = $route->get('id');
				}
			}
		}
		if (count($parameters) != 0)
		{
			foreach ($parameters as $key => $value)
			{
				$link .= '&' . urlencode($key) . '=' . urlencode($value);
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['createLinkGet']['success'], array('link' => $link));
		return $link;
	}
	/**
	 * Create an intern link with the given array for the mode mixed
	 *
	 * @param array $routes Array which can force a chosen path to the route
	 *
	 * @param array $parameters Parameters to add to the link
	 *
	 * @return string
	 */
	public function createLinkMixed(routes: $routes, parameters: $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['route']['router']['createLinkMixed']['empty']);
			return '';
		}

		$parent = null;
		$link = '';

		foreach ($routes as $route)
		{
			if ($route->get('type') === \route\Route::TYPES['folder'])
			{
				$path = $route->getPath($parent);
				if ($path != False)
				{
					$link .= implode("/", array_map("rawurlencode", explode("/", $path)));
					$parent = $route->get('id');
				}
			}
		}
		if (count($parameters) != 0)
		{
			$link .= '?';

			foreach ($parameters as $key => $value)
			{
				$link .= urlencode($key) . '=' . urlencode($value) . '&';
			}

			$link = substr($link, 0, -1);
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['createLinkMixed']['success'], array('link' => $link));
		return $link;
	}
	/**
	 * Create an intern link with the given array for the mode route
	 *
	 * @param array $routes Array which can force a chosen path to the route
	 *
	 * @param array $parameters Parameters to add to the link
	 *
	 * @return string
	 */
	public function createLinkRoute(routes: $routes, parameters: $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['class']['route']['router']['createLinkRoute']['empty']);
			return '';
		}

		$parent = null;
		$link = '';

		foreach ($routes as $route)
		{
			if ($route->get('type') === \route\Route::TYPES['folder'])
			{
				$path = $route->getPath($parent);
				if ($path != False)
				{
					$link .= implode("/", array_map("rawurlencode", explode("/", $path)));
					$parent = $route->get('id');
				}
			}
		}
		if (count($parameters) != 0)
		{
			if (!str_ends_with($link, '/'))
			{
				$link .= '/';
			}

			foreach ($parameters as $key => $value)
			{
				$link .= urlencode($value) . '/';
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['class']['route']['router']['createLinkRoute']['success'], array('link' => $link));
		return $link;
	}
}

?>
