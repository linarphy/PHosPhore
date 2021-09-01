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
	public function __construct($mode)
	{
		$this->setMode($mode);
	}
	/**
	 * build a route node needed to get wanted route
	 *
	 * @param array $array_of_available_routes Array containing array containing route object which has corresponding name
	 *
	 * @param int $row Key of the level corresponding of the node
	 *
	 * @param int $column Key of the data corresponding of the node
	 *
	 * @return \structure\Node|False
	 */
	public function buildNode($array_of_available_routes, $row, $column)
	{
		$Node = \structure\Node($array_of_available_routes[$row][$column]);

		if (count($array_of_available_routes) >= $row)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['buildNode']['undefined'], array('index' => $row));

			return False;
		}
		else if (count($array_of_available_routes) < $row + 1)
		{
			foreach ($array_of_available_routes[$row + 1] as $key => $route)
			{
				if ($route->getPath($Node->get('data') != False))
				{
					$Child = $this->buildNode($array_of_available_routes, $row + 1, $key);
					if ($Child != False)
					{
						$Node->addChild($Child);
					}
				}
			}
			if (empty($Node->get('children')))
			{
				return False;
			}
		}
		return $Node;
	}
	/**
	 * clean non wanted parameters (or not corresponding to the format) from a parameters list for a page
	 *
	 * @param array $parameters Parameters to clean
	 *
	 * @return array
	 */
	public function cleanParameters($parameters, $page)
	{
		if (!$page instanceOf \route\Route)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['bad_page']);

			return array();
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['start'], array('page' => $page->display()));

		$expected_parameters = $page->retrieveParameters();
		$cleaned_parameters = array();

		foreach ($expected_parameters as $expected_parameter)
		{
			foreach ($parameters as $parameter)
			{
				if (preg_match($expected_parameter->getFullRegex(), $parameter))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['found'], array('page' => $page->display(), 'name' => $expected_parameter->get('name'), 'value' => $parameter, 'regex' => $expected_parameter->getFullRegex()));
					$cleaned_parameters[$expected_parameter->get('name')] = $parameter;
					break;
				}
			}
			if ($expected_parameter->get('necessary'))
			{
				if ($cleaned_parameters[$expected_parameter->get('name')] === null)
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['missing'], array('page' => $page->display(), 'name' => $expected_parameter->get('name'), 'regex' => $expected_parameter->getFullRegex()));

					$Notification = new \user\Notification(array(
						'text'         => $GLOBALS['locale']['class']['route']['Router']['missing_parameter'],
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
						throw new \Exception($GLOBALS['locale']['class']['route']['Router']['cleanParameters']['missing_parameter']);
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
	public function createLink($routes, $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLink']['empty']);
			return '';
		}
		switch ($this->mode)
		{
			case $this::MODES['get']:
				return $this->createLinkGet($routes, $parameters);
			case $this::MODES['mixed']:
				return $this->createLinkMixed($routes, $parameters);
			case $this::MODES['route']:
				return $this->createLinkRoute($routes, $parameters);
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['unknown_mode'], array('mode' => $this->mode));
				throw new \Exception($GLOBALS['locale']['class']['route']['Router']['unknown_mode']);
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
	public function createLinkGet($routes, $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['empty']);
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
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['not_found'], array('route' => $route->id));
				}
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['file'], array('file' => $route->get('name')));
			}
		}
		if ($routes[count($routes) - 1].get('type') === \route\Route::TYPES['file'])
		{
			$path = $routes[count($routes) - 1].getPath($parent);
			if ($path != False)
			{
				$link .= urlencode($path);
			}
		}
		if (count($parameters) != 0)
		{
			foreach ($parameters as $key => $value)
			{
				$link .= '&' . urlencode($key) . '=' . urlencode($value);
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['success'], array('link' => $link));
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
	public function createLinkMixed($routes, $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['empty']);
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
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['not_found'], array('route' => $route->id));
				}
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['file'], array('file' => $route->get('name')));
			}
		}
		if ($routes[count($routes) - 1].get('type') === \route\Route::TYPES['file'])
		{
			$path = $routes[count($routes) - 1].getPath($parent);
			if ($path != False)
			{
				$link .= implode("/", array_map("rawurlencode", explode("/", $path)));
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

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['success'], array('link' => $link));
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
	public function createLinkRoute($routes, $parameters = array())
	{
		if (count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['empty']);
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
					$link .= implode('/', array_map('rawurlencode', explode('/', $path)));
					$parent = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['not_found'], array('route' => $route->id));
				}
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['file'], array('file' => $route->get('name')));
			}
		}
		if ($routes[count($routes) - 1].get('type') === \route\Route::TYPES['file'])
		{
			$path = $routes[count($routes) - 1].getPath($parent);
			if ($path != False)
			{
				$link .= implode("/", array_map("rawurlencode", explode("/", $path)));
			}
		}
		if (!str_ends_with($link, '/'))
		{
			$link .= '/';
		}
		if (count($parameters) != 0)
		{
			$link .= rawurlencode(' ') + '/';
			foreach ($parameters as $key => $value)
			{
				$link .= urlencode($value) . '/';
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['success'], array('link' => $link));
		return $link;
	}
	/**
	 * Transform a string representating an intern link into an array
	 *
	 * @param string $url Link to decode
	 *
	 * @return array
	 */
	public function decodeRoute($url)
	{
		if (count($url) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['decodeRoute']['empty']);
			return array();
		}
		switch ($this->mode)
		{
			case $this::MODES['get']:
				return $this->decodeWithGet($url);
			case $this::MODES['mixed']:
				return $this->decodeWithMixed($url);
			case $this::MODES['route']:
				return $this->decodeWithRoute($url);
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['unknown_mode'], array('mode' => $this->mode));
				throw new \Exception($GLOBALS['locale']['class']['route']['Router']['unknown_mode']);
				exit();
		}
	}
	/**
	 * Transform a string representating an intern link in an array for the mode get
	 *
	 * @param string $url Link to decode
	 *
	 * @return array
	 */
	public function decodeWithGet($url)
	{
		if (!isset($_GET['__path__']))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['decodeWithGet']['no_path']);
			$routes = array();
		}
		else
		{
			$path = $_GET['__path__'];
			unset($_GET['__path__']);
			$paths = explode('/', $path);
			$arr_av_routes = [];
			foreach ($paths as $path)
			{
				$arr_av_routes[] = \route\RouteManager()->retrieveBy(array(
					'name' => $path,
				));
			}

			/** TIME CONSUMING OPERATION */
			$root_route = \route\RouteManager()->retrieveBy(array(
				'id' => 0,
			))[0];
			$tree_routes = \structure\Tree($root_route);
			foreach ($arr_av_routes[0] as $key => $av_routes)
			{
				$Child = $this->buildNode($arr_av_routes, 0, $key);
				if ($Child != False)
				{
					$tree_routes->get('root')->addChild($Child);
				}
			}
			$routes = $tree_routes->get('root')->getBranchDepth(count($arr_av_routes));
			if ($routes == False)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithGet']['unknown_route'], array('url' => $url));
			}
		}

		$Page = new \user\Page(array(
			'id' => end($routes)->get('id'),
		));
		$Page->retrieve();
		return [
			'routes'     => $routes,
			'parameters' => $this->cleanparameters($_get, $Page),
			'page'       => $Page,
		];
	}
	/**
	 * Transform a string representating an intern link in an array for the mode mixed
	 *
	 * @param string $url Link to decode
	 *
	 * @return array
	 */
	public function decodeWithMixed($url)
	{
		$paths = explode('/', rawurldecode(strtok($url, '?')));

		$arr_av_routes = [];
		foreach ($paths as $path)
		{
			$arr_av_routes[] = \route\RouteManager()->retrieveBy(array(
				'name' => $path,
			));
		}

		/** TIME CONSUMING OPERATION */
		$root_route = \route\RouteManager()->retrieveBy(array(
			'id' => 0,
		))[0];
		$tree_routes = \structure\Tree($root_route);
		foreach ($arr_av_routes[0] as $key => $av_routes)
		{
			$Child = $this->buildNode($arr_av_routes, 0, $key);
			if ($Child != False)
			{
				$tree_routes->get('root')->addChild($Child);
			}
		}
		$routes = $tree_routes->get('root')->getBranchDepth(count($arr_av_routes));
		if ($routes == False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithMixed']['unknown_route'], array('url' => $url));
		}

		$Page = new \user\Page(array(
			'id' => end($routes)->get('id'),
		));
		$Page->retrieve();
		return [
			'routes'     => $routes,
			'parameters' => $this->cleanparameters($_get, $Page),
			'page'       => $Page,
		];
	}
	/**
	 * Transform a string representating an intern link in an array for the mode route
	 *
	 * @param string $url Links to decode
	 *
	 * @return array
	 */
	public function decodeWithRoute($url)
	{
		$paths = explode('/', rawurldecode(strtok($url, '?')));
		$parameters = [];
		$arr_av_routes = [];
		foreach ($paths as $key => $path)
		{
			if ($path === ' ')
			{
				foreach (array_slice($path, $key + 1) as $param)
				{
					$parameters[] = $param;
				}
			}
			$arr_av_routes[] = \route\RouteManager()->retrieveBy(array(
				'name' => $path,
			));
		}

		/** TIME CONSUMING OPERATION */
		$root_route = \route\RouteManager()->retrieveBy(array(
			'id' => 0,
		))[0];
		$tree_routes = \structure\Tree($root_route);
		foreach ($arr_av_routes[0] as $key => $av_routes)
		{
			$Child = $this->buildNode($arr_av_routes, 0, $key);
			if ($Child != False)
			{
				$tree_routes->get('root')->addChild($Child);
			}
		}
		$routes = $tree_routes->get('root')->getBranchDepth($tree_routes->get('root')->getHeight());
		if ($routes == False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithRoute']['unknown_route'], array('url' => $url));
		}

		$Page = new \user\Page(array(
			'id' => end($routes)->get('id'),
		));
		$Page->retrieve();
		return [
			'routes'     => $routes,
			'parameters' => $this->cleanParameters($parameters, $Page),
			'page'       => $Page,
		];
	}
	/**
	 * Get the actual mode of the router
	 *
	 * @return int
	 */
	public function getMode()
	{
		return $this->mode;
	}
	/**
	 * Set the mode of the router
	 *
	 * @param int $mode Mode of the router
	 *
	 * @return bool
	 */
	protected function setMode($mode)
	{
		if (!in_array($mode, $this::MODES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['setMode'], array('mode' => $mode));

			return False;
		}

		$this->mode = $mode;

		return True;
	}
}

?>