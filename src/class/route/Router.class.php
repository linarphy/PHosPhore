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
	protected ?int $mode = null;
	/**
	 * List of operating modes for Router
	 *
	 * @var array
	 */
	const MODES = [
		'get'   => 1,
		'mixed' => 2,
		'route' => 3,
	];
	/**
	 * constructor
	 *
	 * @param int $mode Operating mode of the router
	 */
	public function __construct(int $mode)
	{
		$this->setMode($mode);
	}
	/**
	 * build a route node needed to get wanted route
	 *
	 * @param array $array_of_available_routes Array containing array containing route object which has corresponding name
	 *
	 * @param int $path_level Number of step already done
	 *
	 * @param \route\Route $root From which route to start
	 *
	 * @return \structure\Node|null
	 */
	public static function buildNode(array $arr_av_routes, int $path_level, \route\Route $root) : ?\structure\Node
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['buildNode']['start']);

		if (count($arr_av_routes) === 0) // there are available routes
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['buildNode']['empty_array']);

			return null;
		}

		$Node = new \structure\Node($root); // "root" node

		if ($path_level === count($arr_av_routes)) // last level route
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['buildNode']['last']);
			return $Node;
		}

		foreach ($arr_av_routes[$path_level] as $av_route)
		{
			$path_av = $av_route->getPath($root->get('id'));
			if ($path_av !== null && $path_av !== $root->getPath($root->get('id'))) // if the available route is a descendant of the "root" route /!\ \route\Route->getPath return a valid string if the root is the available route itself (like .../home/home/...)
			{
				$Child = self::buildNode($arr_av_routes, $path_level + 1, $av_route);
				$Node->addChild($Child);
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['buildNode']['end']);
		return $Node;
	}
	/**
	 * clean non wanted parameters (or not corresponding to the format) from a parameters list for a page
	 *
	 * @param array $parameters Parameters to clean
	 *
	 * @param \route\Route $page Page to load
	 *
	 * @return array
	 */
	public static function cleanParameters(array $parameters, \route\Route $route) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['start'], ['page' => $route->get('name')]);

		try
		{
			$route->retrieve();
		}
		catch (\Exception $e)
		{
			return [];
		}

		$route->retrieveParameters();

		$expected_parameters = $route->get('parameters');
		$cleaned_parameters = [];

		foreach ($expected_parameters as $expected_parameter)
		{
			foreach ($parameters as $parameter)
			{
				if (\preg_match($expected_parameter->getFullRegex(), $parameter))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['found'], ['page' => $route->get('name'), 'name' => $expected_parameter->get('name'), 'value' => $parameter, 'regex' => $expected_parameter->getFullRegex()]);

					$Parameter = new \user\Parameter([
						'key' => $expected_parameter->get('name'),
						'value' => $parameter,
					]);

					$cleaned_parameters[$expected_parameter->get('name')] = $Parameter;
					break;
				}
			}
			if ($expected_parameter->get('necessary'))
			{
				if (!\key_exists($expected_parameter->get('name'), $cleaned_parameters))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['missing'], ['page' => $route->get('name'), 'name' => $expected_parameter->get('name'), 'regex' => $expected_parameter->getFullRegex()]);

					throw new \Exception($GLOBALS['locale']['class']['route']['Router']['cleanParameters']['missing_parameter']);
				}
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['cleanParameters']['end'], ['page' => $route->get('name')]);

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
	public function createLink(array $routes, array $parameters = []) : string
	{
		if (\count($routes) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLink']['empty']);
			return '';
		}
		switch ($this->mode)
		{
			case $this::MODES['get']:
				return $this::createLinkGet($routes, $parameters);
			case $this::MODES['mixed']:
				return $this::createLinkMixed($routes, $parameters);
			case $this::MODES['route']:
				return $this::createLinkRoute($routes, $parameters);
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['unknown_mode'], ['mode' => $this->mode]);
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
	public static function createLinkGet(array $routes, array $parameters = []) : string
	{
		if (\count($routes) === 0)
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
				if ($path)
				{
					$link .= \urlencode($path);
					$parent = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['not_found'], ['route' => $route->id]);
				}
			}
			else if ($route->get('type') === \route\Route::TYPES['page'])
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['file'], ['file' => $route->get('name')]);
			}
			else
			{
				throw new \Exception($GLOBALS['locale']['class']['route']['Router']['createLinkMixed']['unknown_type']);
			}
		}
		if ($routes[\count($routes) - 1]->get('type') === \route\Route::TYPES['file'])
		{
			$path = $routes[\count($routes) - 1].getPath($parent);
			if ($path != False)
			{
				$link .= \urlencode($path);
			}
		}
		if (\count($parameters) != 0)
		{
			foreach ($parameters as $key => $value)
			{
				$link .= '&' . \urlencode($key) . '=' . \urlencode($value);
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkGet']['success'], ['link' => $link]);
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
	public static function createLinkMixed(array $routes, array $parameters = []) : string
	{
		if (\count($routes) === 0)
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
					$link .= \implode('/', \array_map('\\rawurlencode', \explode('/', $path)));
					$parent = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['not_found'], ['route' => $route->id]);
				}
			}
			else if ($route->get('type') === \route\Route::TYPES['page'])
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['file'], ['file' => $route->get('name')]);
			}
			else
			{
				throw new \Exception($GLOBALS['locale']['class']['route']['Router']['createLinkMixed']['unknown_type']);
			}
		}
		if ($routes[\count($routes) - 1]->get('type') === \route\Route::TYPES['file'])
		{
			$path = $routes[\count($routes) - 1]->getPath($parent);
			if ($path != False)
			{
				$link .= \implode('/', \array_map('\\rawurlencode', \explode('/', $path)));
			}
		}
		if (\count($parameters) != 0)
		{
			$link .= '?';

			foreach ($parameters as $key => $value)
			{
				$link .= \urlencode($key) . '=' . \urlencode($value) . '&';
			}

			$link = \substr($link, 0, -1);
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['success'], ['link' => $link]);
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
	public static function createLinkRoute(array $routes, array $parameters = []) : string
	{
		if (\count($routes) === 0)
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
					$link .= \implode('/', \array_map('\\rawurlencode', \explode('/', $path)));
					$parent = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['not_found'], ['route' => $route->id]);
				}
			}
			else if ($route->get('type') === \route\Route::TYPES['page'])
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['file'], ['file' => $route->get('name')]);
			}
			else
			{
				throw new \Exception($GLOBALS['locale']['class']['route']['Router']['createLinkRoute']['unknown_type']);
			}
		}
		if ($routes[\count($routes) - 1]->get('type') === \route\Route::TYPES['page'])
		{
			$path = $routes[\count($routes) - 1]->getPath($parent);
			if ($path != False)
			{
				$link .= \implode('/', \array_map('\\rawurlencode', \explode('/', $path)));
			}
		}
		if (!\str_ends_with($link, '/'))
		{
			$link .= '/';
		}
		if (\count($parameters) != 0)
		{
			$link .= \rawurlencode(' ') . '/';
			foreach ($parameters as $key => $value)
			{
				$link .= \urlencode($value) . '/';
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['success'], ['link' => $link]);
		return $link;
	}
	/**
	 * Transform a string representating an intern link into an array
	 *
	 * @param string $url Link to decode
	 *
	 * @return \route\Route
	 */
	public function decodeRoute(string $url) : \route\Route
	{
		if (\phosphore_count($url) > 0)
		{
			if ($url[\phosphore_count($url) - 1] === '/')
			{
				$url = \substr($url, 0, -1);
			}
		}
		if (\phosphore_count($url) > 0)
		{
			if ($url[0] === '/')
			{
				$url = \substr($url, 1);
			}
		}
		if (\phosphore_count($url) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['decodeRoute']['empty']);

			$RouteManager = new \route\RouteManager();

			$route = $RouteManager->retrieveBy([
				'id' => $GLOBALS['config']['class']['route']['root']['id'],
			])[0];
			$route = self::initPage($route->getDefaultPage(), []);
		}
		else
		{
			switch ($this->mode)
			{
				case $this::MODES['get']:
					$route = $this::decodeWithGet($url);
					break;
				case $this::MODES['mixed']:
					$route = $this::decodeWithMixed($url);
					break;
				case $this::MODES['route']:
					$route = $this::decodeWithRoute($url);
					break;
				default:
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['unknown_mode'], ['mode' => $this->mode]);
					throw new \Exception($GLOBALS['locale']['class']['route']['Router']['unknown_mode']);
					exit();
			}
		}

		return $route;
	}
	/**
	 * Transform a string representating an intern link in an array for the mode get
	 *
	 * @param string $url Link to decode
	 *
	 * @return \route\Route
	 */
	public static function decodeWithGet(string $url) : \route\Route
	{
		if (!isset($_GET['__path__']))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Router']['decodeWithGet']['no_path']);
			$routes = [];
		}
		else
		{
			$path = $_GET['__path__'];
			unset($_GET['__path__']);
			$paths = \explode('/', $path);
			$arr_av_routes = [];
			foreach ($paths as $path)
			{
				$arr_av_routes[] = \route\RouteManager()->retrieveBy([
					'name' => $path,
				]);
			}

			/** TIME CONSUMING OPERATION */
			$root_route = \route\RouteManager()->retrieveBy([
				'id' => 0,
			])[0];
			$tree_routes = \structure\Tree($root_route);
			foreach ($arr_av_routes[0] as $key => $av_routes)
			{
				$Child = $this->buildNode($arr_av_routes, 0, $key);
				if ($Child !== False)
				{
					$tree_routes->get('root')->addChild($Child);
				}
			}
			$routes = $tree_routes->get('root')->getBranchDepth(\count($arr_av_routes));
			if ($routes === False)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithGet']['unknown_route'], ['url' => $url]);
			}
		}

		return $this::initPage(\end($routes)->getDefaultPage(), $_GET);
	}
	/**
	 * Transform a string representating an intern link in an array for the mode mixed
	 *
	 * @param string $url Link to decode
	 *
	 * @return \route\Route
	 */
	public static function decodeWithMixed(string $url) : \route\Route
	{
		$paths = \explode('/', \rawurldecode(\strtok($url, '?')));

		$arr_av_routes = [];
		foreach ($paths as $path)
		{
			$arr_av_routes[] = \route\RouteManager()->retrieveBy([
				'name' => $path,
			]);
		}

		/** TIME CONSUMING OPERATION */
		$root_route = \route\RouteManager()->retrieveBy([
			'id' => 0,
		])[0];
		$tree_routes = \structure\Tree($root_route);
		foreach ($arr_av_routes[0] as $key => $av_routes)
		{
			$Child = $this->buildNode($arr_av_routes, 0, $key);
			if ($Child !== False)
			{
				$tree_routes->get('root')->addChild($Child);
			}
		}
		$routes = $tree_routes->get('root')->getBranchDepth(\count($arr_av_routes));
		if ($routes === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithMixed']['unknown_route'], ['url' => $url]);
		}

		return $this::initPage(\end($routes)->getDefaultPage(), $_GET);
	}
	/**
	 * Transform a string representating an intern link in an array for the mode route
	 *
	 * @param string $url Links to decode
	 *
	 * @return \route\Route
	 */
	public static function decodeWithRoute(string $url) : \route\Route
	{
		$paths = \explode('/', \rawurldecode(\strtok($url, '?')));
		$parameters = [];
		$arr_av_routes = [];

		$RouteManager = new \route\RouteManager();

		foreach ($paths as $key => $path)
		{
			if ($path === ' ') // go to parameter list
			{
				$key -= 1;
				break;
			}

			$arr_av_routes[] = $RouteManager->retrieveBy([ // retrieve all routes with the same name
				'name' => $path,
			]);
		}
		if ($path === ' ') // parameter list
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Router']['decodeWithRoute']['start_parameter_list']);
			foreach (array_slice($paths, $key + 2) as $param)
			{
				$parameters[] = $param;
			}
		}

		/** TIME CONSUMING OPERATION */

		$root_route = $RouteManager->retrieveBy([ // retrieve the root route
			'id' => 1,
		])[0];

		$tree_routes = new \structure\Tree($root_route);

		foreach ($arr_av_routes[0] as $key => $av_routes)
		{
			$Child = self::buildNode($arr_av_routes, 1, $av_routes); // start building a tree
			if ($Child !== null)
			{
				$tree_routes->get('root')->addChild($Child);
			}
		}

		if ($tree_routes->get('root')->getHeight() !== count($arr_av_routes))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithRoute']['no_path'], ['url' => $url]);
			throw new \Exception($GLOBALS['locale']['class']['route']['Router']['decodeWithRoute']['no_path']);
		}

		$routes = $tree_routes->get('root')->getBranchDepth($tree_routes->get('root')->getHeight());

		if ($routes === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['route']['Router']['decodeWithRoute']['unknown_route'], ['url' => $url]);

			return False;
		}

		foreach ($routes as $index => $node)
		{
			$routes[$index] = $node->get('data');
		}

		return self::initPage(\end($routes)->getDefaultPage(), $parameters);
	}
	/**
	 * Initialize page & route
	 *
	 * @param \route\Route $route route defined
	 *
	 * @param array $parameters Parameters given in the url
	 *
	 * @return \route\Route
	 */
	public static function initPage(\route\Route $route, array $parameters) : \route\Route
	{
		$Page = new \user\Page([
			'id' => $route->get('id'),
		]);
		$GLOBALS['Visitor']->set('page', $Page);
		$GLOBALS['Visitor']->get('page')->retrieveParameters();
		$GLOBALS['Visitor']->get('page')->set('parameters', \array_merge($GLOBALS['Visitor']->get('page')->get('parameters'), self::cleanParameters($parameters, $route)));

		return $route;
	}
	/**
	 * Get the actual mode of the router
	 *
	 * @return int
	 */
	public function getMode() : int
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
	protected function setMode(int $mode) : bool
	{
		if (!in_array($mode, $this::MODES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Router']['setMode']['unknown'], ['mode' => $mode]);

			return False;
		}

		$this->mode = $mode;

		return True;
	}
}

?>
