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
	 * name of the route
	 *
	 * @var string
	 */
	protected $name;
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
	/**
	 * Get one of the "path" to this route
	 *
	 * @param int $root_id From which folder to start the path
	 *
	 * @param array $loaded Id of route loaded to avoid infinite recursion
	 *
	 * @return False|string
	 */
	public function getPath(root_id: $root_id = null, loaded: $loaded = array())
	{
		if ($this->id === $root_id)
		{
			return $this->name . '/';
		}

		if (in_array($this->id, $loaded)) // break infinite recursion
		{
			return False;
		}

		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_chil' => $this->id,
		));

		if (count($routes) === 0) // root route
		{
			if ($root_id === null)
			{
				return $this->name . '/';
			}
			return False;
		}
		foreach ($routes as $route)
		{
			$loaded[] = $this->id;
			$path = $route->getPath($root_id, $loaded)
			if ($path != False)
			{
				$path .= $this->name;
				if ($route->type === $this::TYPES['folder'])
				{
					$path .= '/';
				}
				return $path;
			}
		}
		return False;
	}
	/**
	 * load route files (config, locale, log_message) from every folder which contains the route
	 *
 * @var bool All files exist and are loaded
	 */
	public function loadSubFiles()
	{
		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_child' => $this->id,
		));

		if (count($routes) != 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (array_flip($GLOBALS['cache']['class']['route']['route']['loaded']['subfiles'][[$route->get('id_route_parent')] != null) // avoid circular reference
				{
					$route->loadSubFiles();
					$GLOBALS['cache']['class']['route']['loaded']['subfiles'][] = $result['id_route_parent'];
				}
			}
		}

		$Folder = $this->retrieveFolder();

		$count = 0;
		if (stream_resolve_include_path($Folder->getConfigFile()))
		{
			include($Folder->getConfigFile());
			$count += 1;
		}
		if (stream_resolve_include_path($Folder->getLocaleFile()))
		{
			include($Folder->getLocaleFile());
			$count += 1;
		}
		if (stream_resolve_include_path($Folder->getLog_messageFile()))
		{
			include($Folder->getLog_messageFile());
			$count += 1;
		}

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

		return $Folder;
	}
	/**
	 * Retrieve route parameter
	 *
	 * @return array
	 */
	public function retrieveParameters()
	{
		$LinkRouteRoute = new \route\LinkRouteRoute();
		$routes = $LinkRouteRoute->retrieveBy(array(
			'id_route_child' => $this->id,
		));

		$parameters = array();

		if (count($routes) != 0) // not root route
		{
			foreach ($routes as $route)
			{
				if (array_flip($GLOBALS['cache']['class']['route']['route']['loaded']['parameters'][[$route->get('id_route_parent')] != null) // avoid circular reference
				{
					$parameters = array_merge($parameters, $route->retrieveParameters());
					$GLOBALS['cache']['class']['route']['loaded']['parameters'][] = $result['id_route_parent'];
				}
			}
		}

		$LinkManager = \route\LinkRouteParameter;
		$parameters = array_merge($parameters, $LinkManager->RetrieveBy(array(
			'id_route' => $this->id,
		)));
	}
}

?>
