<?php

namespace user;

/**
 * Page viewed by the user
 */
class Page extends \core\Managed
{
	/**
	 * id of the page (aka the route)
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * name of the page
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * content element of the page
	 *
	 * @var \content\pageelement\PageElement
	 */
	protected ?\content\pageelement\PageElement $page_element = null;
	/**
	 * parameters of the page
	 *
	 * @var array
	 */
	protected ?array $parameters = null;
	/**
	 * route associated to this page
	 *
	 * @var \route\Route
	 */
	protected ?\route\Route $route = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id'   => 'int',
		'name' => 'string',
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
	 * constructor
	 *
	 * @param array $attributes Attributes of the page
	 *
	 * @return bool
	 */
	public function __construct(array $attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['start']);
		$GLOBALS['Hook']->load(['class', 'user', 'Page', '__construct', 'start'], [$this, $attributes]);

		if ($this->hydrate($attributes) <= 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['__construct']['no_attributes']);

			return False;
		}
		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['__construct']['no_route']);

			return False;
		}

		$this->retrieve();
		$Route = $this->retrieveRoute();

		$GLOBALS['Hook']->load(['class', 'user', 'Page', '__construct', 'end'], [$this, $attributes]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['end']);
		return True;
	}
	/**
	 * Add a custom temporal parameter to the page
	 *
	 * @param string|int $key Parameter name
	 *
	 * @param mixed $value Parameter value
	 *
	 * @return bool
	 */
	public function addParameter(string|int $key, mixed $value) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['addParameter']['start'], ['key' => $key, 'value' => $value]);

		if (\count($this->get('parameters')) === 0)
		{
			$this->set('parameters', [$key => $value]);

			return True;
		}
		else
		{
			if ($this->get('parameters')[$key] != null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Page']['addParameter']['already'], ['key' => $key, 'value' => $value, 'old' => $this->get('parameters')[$key]]);

				return False;
			}

			$this->set('parameters')[$key] = $value;

			return True;
		}
	}
	/**
	 * Display the page
	 *
	 * @return string
	 */
	public function display() : string
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['display']);

		return $this->displayer('page_element');
	}
	/**
	 * Load the php file associated to the page
	 *
	 * @return bool
	 */
	public function load() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['start']);
		$GLOBALS['Hook']->load(['class', 'user', 'Page', 'load', 'start'], $this);

		$PageElement = new \content\pageelement\PageElement([]); // I need configuration of this class to load after this point, it's dumb but it's the simple way for now

		$no_notification = False; // the page can display notifications
		foreach ($this->get('parameters') as $Parameter)
		{
			if ($Parameter->get('key') === 'preset' && $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$Parameter->get('value')])
			{
				$preset = $Parameter->get('value'); // there is a preset associated to this page
			}
			if ($Parameter->get('key') === 'no_notification')
			{
				$no_notification = True; // this page cannot display notification
			}
		}
		if (isset($preset))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['preset'], ['preset' => $preset]);

			$page_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$preset]['page_element']([]);
			$notification_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$preset]['notification_element']([]);
		}
		else
		{
			$page_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['page_element']([]);
			$notification_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['notification_element']([]);
		}

		if (!$no_notification)
		{
			$Notifications = \user\Notification::getNotifications($notification_element);
			$page_element->setElement($GLOBALS['config']['class']['content']['pageelement']['preset']['notification_element_name'], $Notifications, False);
			$number = \user\Notification::deleteNotifications();

			if ($number !== count($Notifications)) // cannot happens
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['load']['different_number'], ['number_fetch' => count($Notifications), 'number_delete' => $number]);
				throw new \Exception($GLOBALS['locale']['core']['error']['internal']);
			}

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['notifications'], ['number' => \count($Notifications)]);
		}

		$this->set('page_element', $page_element);
		$Route = $this->retrieveRoute();

		$Folder = $Route->retrieveFolder();

		$file = $GLOBALS['config']['core']['path']['page'] . $Folder->getPath() . $GLOBALS['config']['class']['user']['Page']['filename'];

		if (!\is_file($file))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Page']['load']['no_file'], ['file' => $file]);

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['subfiles']);

		$Route->loadSubFiles();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['include'], ['file' => $file]);

		$GLOBALS['Hook']->load(['class', 'user', 'Page', 'load', 'end'], $this);
		return include($file);
	}
	/**
	 * Retrieve parameters of the page in the database
	 *
	 * @param int $level Level of the stack
	 *
	 * @return array
	 */
	public function retrieveParameters(int $level = 0) : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['start']);

		if (\phosphore_count($this->get('parameters')) !== 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['already_defined']);

			return $this->get('parameters');
		}
		$LinkPageParameters = new \user\LinkPageParameter();
		$LinkRouteRoute = new \route\LinkRouteRoute();

		$routes = $LinkRouteRoute->retrieveBy([
			'id_route_child' => $this->get('id'),
		], class_name: '\route\Route', attributes_conversion: ['id_route_parent' => 'id']);

		$parameters = [];

		if ($level === 0)
		{
			$GLOBALS['cache']['class']['user']['Page']['loaded']['parameters'] = [];
		}

		if (\count($routes) !== 0)
		{
			foreach ($routes as $route)
			{
				if (!isset(\array_flip($GLOBALS['cache']['class']['user']['Page']['loaded']['parameters'])[$route->get('id')])) // avoid circular references
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['loading_parameters']);

					$page = new \user\Page([
						'id' => $route->get('id'),
					]);

					$parameters = \array_merge($parameters, $page->retrieveParameters($level + 1));
					$GLOBALS['cache']['class']['user']['Page']['loaded']['parameters'][] = $route->get('id');
				}
				else
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['already_loaded'], ['route' => $route->get('name')]);
				}
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['root_parameters']);
		}

		$parameters = \array_merge($parameters, $LinkPageParameters->retrieveBy([
			'id_page' => $this->get('id'),
		], class_name: '\user\Parameter', attributes_conversion: [
			'id_parameter' => 'id',
		]));

		$this->set('parameters', $parameters);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['loaded'], ['number' => \count($parameters)]);

		return $this->get('parameters');
	}
	/**
	 * Retrieve route of the page
	 *
	 * @return \route\Route|null
	 */
	public function retrieveRoute() : ?\route\Route
	{
		$routeManager = new \route\RouteManager();
		if (!$routeManager->exist(['id' => $this->get('id')]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['retrieveRoute']['no_exist']);

			return null;
		}

		if ($this->get('route') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Page']['retrieveRoute']['already_defined']);

			return $this->get('route');
		}

		$this->set('route', $routeManager->retrieveBy([
			'id' => $this->get('id'),
		])[0]);

		return $this->get('route');
	}
}

?>
