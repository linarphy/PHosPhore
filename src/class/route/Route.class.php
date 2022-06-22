<?php

namespace route;

/**
 * A page or dynamic folder to url
 */
class Route extends \core\Managed
{
	/**
	 * index in the database (which is the index of the path
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * folder of the route
	 *
	 * @var \route\Folder
	 */
	protected ?\route\Folder $folder = null;
	/**
	 * index of the associated folder
	 *
	 * @var int
	 */
	protected ?int $id_folder = null;
	/**
	 * name of the route
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * parameters of the route
	 *
	 * @var array
	 */
	protected ?array $parameters = null;
	/**
	 * type of the route
	 *
	 * @var bool
	 */
	protected ?bool $type = null;
	/**
	 * types of the route
	 *
	 * @var array
	 */
	const TYPES = [
		'page'   => True,
		'folder' => False,
	];
	/* Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id'        => 'int',
		'id_folder' => 'int',
		'name'      => 'string',
		'type'      => 'bool',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * Get the "default" page to this folder route
	 *
	 * @return null|\route\Route
	 */
	public function getDefaultPage() : ?\route\Route
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['start']);

		if ($this->get('type') === self::TYPES['page'])
		{
			return $this;
		}
		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['no_retrieved']);

			return null;
		}
		if ($this->get('type') !== self::TYPES['folder'])
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['unknown_type'], ['type' => $this->get('type')]);

			return null;
		}

		$Page = new \user\Page([
			'id' => $this->get('id'),
		]);

		$Page->retrieve();
		$Page->retrieveParameters();

		if (\phosphore_count($Page->get('parameters')) !== 0)
		{
			foreach ($Page->get('parameters') as $Parameter)
			{
				if ($Parameter->get('key') === 'default_page')
				{
					$route = new \route\Route([
						'id' => $Parameter->get('value'),
					]);
					$route->retrieve();

					if ($route->isIdentical($this))
					{
						$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['inf_recursion']);
						throw new \Exception($GLOBALS['locale']['class']['route']['Route']['getDefaultPage']['inf_recursion']);
					}

					return $route->getDefaultPage();
				}
			}
		}

		$LinkRouteManager = new \route\LinkRouteRoute();
		$routes_child = $LinkRouteManager->retrieveBy([
			'id_route_parent' => $this->get('id'),
		], class_name: 'route\Route', attributes_conversion: [
			'id_route_child' => 'id',
		]);

		if (empty($routes_child))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['no_children']);

			return null;
		}

		foreach ($routes_child as $route) // quicker for one level
		{
			if ($route->get('type') === $this::TYPES['page'])
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['end']);

				return $route;
			}
		}

		foreach ($route_child as $route) // not found the quick way
		{
			$value = $route->getDefaultPage();

			if ($value !== null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['end']);

				return $value;
			}
		}

		return null;
	}
	/**
	 * Get one of the "path" to this route
	 *
	 * @param int $root_id From which folder to start the path
	 *
	 * @param array $loaded Id of route loaded to avoid infinite recursion
	 *
	 * @return null|string
	 */
	public function getPath(int $root_id = null, array $loaded = []) : ?string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['start'], ['this_route' => $this->id, 'id_root' => $root_id]);

		if ($this->id === $root_id)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['found_itself'], ['this_route' => $this->id, 'id_root' => $root_id]);
			return $this->name . '/';
		}

		if (in_array($this->id, $loaded)) // break infinite recursion
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Route']['getPath']['infinite_recursion'], ['this_route' => $this->id, 'id_root' => $root_id]);
			return null;
		}

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy([
				'id_route_child' => $this->id,
			],
			class_name: '\\route\\Route',
			attributes_conversion: ['id_route_parent' => 'id'],
		);

		if (empty($routes)) // root route
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['no_parent'], ['this_route' => $this->id, 'id_root' => $root_id]);
			if ($root_id === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['empty_id'], ['this_route' => $this->id]);
				return $this->name . '/';
			}
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['path_not_exist'], ['this_route' => $this->id, 'id_root' => $root_id]);
			return null;
		}
		foreach ($routes as $route)
		{
			$loaded[] = $this->id;
			$path = $route->getPath($root_id, $loaded);
			if ($path !== null)
			{
				$path .= $this->name;
				if ($route->type === $this::TYPES['folder'])
				{
					$path .= '/';
				}
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['found'], ['this_route' => $this->id, 'id_root' => $root_id, 'path' => $path]);
				return $path;
			}
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['not_found'], ['this_route' => $this->id, 'id_root' => $root_id]);
		return null;
	}
	/**
	 * load route files (config, locale, lang) from every folder which contains the route
	 *
	 * @var bool All files exist and are loaded
	 */
	public function loadSubFiles() : bool
	{
		if (!isset($GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles']))
		{
			$GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles'] = [];
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['start'], ['name' => $this->displayer('name')]);

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy([
			'id_route_child' => $this->id,
		], class_name: '\route\Route', attributes_conversion: [
			'id_route_parent' => 'id',
		]);

		if (\count($routes) !== 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (!\key_exists($route->get('id'), \array_flip($GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles']))) // avoid circular reference
				{
					$route->loadSubFiles();
					$GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles'][] = $route->get('id');
				}
			}
		}

		$Folder = $this->retrieveFolder();

		if ($Folder->get('name') === null)
		{

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['end'], ['name' => $this->displayer('name')]);

			return 0;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['current'], ['name' => $this->displayer('name')]);

		$count = 0;

		$path_config = $Folder->getConfigFile();
		$path_locale = $Folder->getLocaleFile();
		$path_lang   = $Folder->getLangFile();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['list_files'], [
			'config' => $path_config,
			'locale' => $path_locale,
			'lang'   => $path_lang,
		]);

		if (\is_file($path_config))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['config'], ['path' => $path_config]);
			include($path_config);
			$count += 1;
		}
		if (\is_file($path_locale))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['locale'], ['path' => $path_locale]);
			include($path_locale);
			$count += 1;
		}
		if (\is_file($path_lang))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['lang'], ['path' => $path_lang]);
			include($path_lang);
			$count += 1;
		}
		$GLOBALS['Hook']->load(['class', 'route', 'Route', 'loadSubFiles', 'include'], $this);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['end'], ['name' => $this->displayer('name')]);

		return $count === 3;
	}
	/**
	 * Retrieve the folder associated with this route
	 *
	 * @return \route\Folder
	 */
	public function retrieveFolder() : \route\Folder
	{
		$Folder = new \route\Folder([
			'id' => $this->get('id_folder'),
		]);
		$Folder->retrieve();

		$this->set('folder', $Folder);

		return $this->folder;
	}
	/**
	 * Retrieve route parameter
	 *
	 * @param int $level depth of the stack
	 *
	 * @return array
	 */
	public function retrieveParameters(int $level = 0) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['start']);

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy([
			'id_route_child' => $this->id,
		], class_name: '\route\Route', attributes_conversion: ['id_route_parent' => 'id']);

		$parameters = [];

		if ($level === 0)
		{
			$GLOBALS['cache']['class']['route']['Route']['loaded']['parameters'] = [];
		}

		if (\count($routes) !== 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (!isset(\array_flip($GLOBALS['cache']['class']['route']['Route']['loaded']['parameters'])[$route->get('id')])) // avoid circular reference
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['loading_parameters']);

					$parameters = \array_merge($parameters, $route->retrieveParameters($level + 1));
					$GLOBALS['cache']['class']['route']['Route']['loaded']['parameters'][] = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['already_loaded'], ['route' => $route->get('name')]);
				}
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['root_parameters']);
		}

		$LinkManager = new \route\LinkRouteParameter();

		$this->parameters = \array_merge($parameters, $LinkManager->retrieveBy([
			'id_route' => $this->id,
		], class_name: '\route\Parameter', attributes_conversion: ['id_parameter' => 'id']));

		return $this->get('parameters');
	}
}

?>
