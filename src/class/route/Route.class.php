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
	protected $id;
	/**
	 * folder of the route
	 *
	 * @var \route\Folder
	 */
	protected $folder;
	/**
	 * name of the route
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * parameters of the route
	 *
	 * @var array
	 */
	protected $parameters;
	/**
	 * type of the route
	 *
	 * @var bool
	 */
	protected $type;
	/**
	 * types of the route
	 *
	 * @var array
	 */
	const TYPES = array(
		'page'   => True,
		'folder' => False,
	);
	/* Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id'   => 'int',
		'name' => 'string',
		'type' => 'bool',
	);
	/**
	 * Get the "default" page to this folder route
	 *
	 * @return False | \route\Route
	 */
	public function getDefaultPage()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['start']);

		if ($this->get('type') === $this::TYPES['page'])
		{
			return $this;
		}
		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['no_retrieved']);

			return False;
		}
		if ($this->get('type') !== $this::TYPES['folder'])
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['unknown_type'], array('type' => $this->get('type')));

			return False;
		}

		$LinkRouteManager = new \route\LinkRouteRoute();
		$routes_child = $LinkRouteManager->retrieveBy(array(
			'id_route_parent' => $this->get('id'),
		), class_name: 'route\Route', attributes_conversion: array(
			'id_route_child' => 'id',
		));

		if (empty($routes_child))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['no_children']);

			return False;
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

			if ($value !== False)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getDefaultPage']['end']);

				return $value;
			}
		}

		return False;
	}
	/**
	 * Get one of the "path" to this route
	 *
	 * @param int $root_id From which folder to start the path
	 *
	 * @param array $loaded Id of route loaded to avoid infinite recursion
	 *
	 * @return False|string
	 */
	public function getPath($root_id = null, $loaded = array())
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['start'], array('this_route' => $this->id, 'id_root' => $root_id));

		if ($this->id === $root_id)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['found_itself'], array('this_route' => $this->id, 'id_root' => $root_id));
			return $this->name . '/';
		}

		if (in_array($this->id, $loaded)) // break infinite recursion
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Route']['getPath']['infinite_recursion'], array('this_route' => $this->id, 'id_root' => $root_id));
			return False;
		}

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_child' => $this->id,
		));

		if (empty($routes)) // root route
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['no_parent'], array('this_route' => $this->id, 'id_root' => $root_id));
			if ($root_id === null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['empty_id'], array('this_route' => $this->id));
				return $this->name . '/';
			}
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['path_not_exist'], array('this_route' => $this->id, 'id_root' => $root_id));
			return False;
		}
		foreach ($routes as $route)
		{
			$loaded[] = $this->id;
			$path = $route->getPath($root_id, $loaded);
			if ($path != False)
			{
				$path .= $this->name;
				if ($route->type === $this::TYPES['folder'])
				{
					$path .= '/';
				}
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['found'], array('this_route' => $this->id, 'id_root' => $root_id, 'path' => $path));
				return $path;
			}
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['getPath']['not_found'], array('this_route' => $this->id, 'id_root' => $root_id));
		return False;
	}
	/**
	 * load route files (config, locale, lang) from every folder which contains the route
	 *
	 * @var bool All files exist and are loaded
	 */
	public function loadSubFiles()
	{
		if (!isset($GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles']))
		{
			$GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles'] = array();
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['start'], array('name' => $this->displayer('name')));

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_child' => $this->id,
		), class_name: '\route\Route', attributes_conversion: array(
			'id_route_parent' => 'id',
		));

		if (count($routes) !== 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (!key_exists($route->get('id'), array_flip($GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles']))) // avoid circular reference
				{
					$route->loadSubFiles();
					$GLOBALS['cache']['class']['route']['Route']['loaded']['subfiles'][] = $route->get('id');
				}
			}
		}

		$Folder = $this->retrieveFolder();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['current'], array('name' => $this->displayer('name')));

		$count = 0;

		$path_config = $Folder->getConfigFile();
		$path_locale = $Folder->getLocaleFile();
		$path_lang   = $Folder->getLangFile();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['list_files'], array(
			'config' => $path_config,
			'locale' => $path_locale,
			'lang'   => $path_lang,
		));

		if (is_file($path_config))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['config'], array('path' => $path_config));
			include($path_config);
			$count += 1;
		}
		if (is_file($path_locale))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['locale'], array('path' => $path_locale));
			include($path_locale);
			$count += 1;
		}
		if (is_file($path_lang))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['lang'], array('path' => $path_lang));
			include($path_lang);
			$count += 1;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['end'], array('name' => $this->displayer('name')));

		return $count === 3;
	}
	/**
	 * Retrieve the folder associated with this route
	 *
	 * @return \route\Folder
	 */
	public function retrieveFolder()
	{
		$Folder = new \route\Folder(array(
			'id' => $this->id,
		));
		$Folder->retrieve();

		$this->folder = $Folder;

		return $this->folder;
	}
	/**
	 * Retrieve route parameter
	 *
	 * @return array
	 */
	public function retrieveParameters()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['start']);

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_child' => $this->id,
		), class_name: '\route\Route');

		$parameters = array();

		if (count($routes) !== 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (array_flip($GLOBALS['cache']['class']['route']['Route']['loaded']['parameters'])[$route->get('id_route_parent')] != null) // avoid circular reference
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['loading_parameters']);

					$parameters = array_merge($parameters, $route->retrieveParameters());
					$GLOBALS['cache']['class']['route']['Route']['loaded']['parameters'][] = $result['id_route_parent'];
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['already_loaded'], array('route' => $route->get('name')));
				}
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['root_parameters']);
		}

		$LinkManager = \route\LinkRouteParameter();
		$this->parameters = array_merge($parameters, $LinkManager->retrieveBy(array(
			'id_route' => $this->id,
		)));

		return $this->parameters;
	}
}

?>
