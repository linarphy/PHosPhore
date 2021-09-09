<?php

namespace user;

/**
 * Page viewed by the user
 */
class Page extends \core\Manager
{
	/**
	 * id of the page (aka the route)
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * name of the page
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * content element of the page
	 *
	 * @var \content\pageelement\PageElement
	 */
	protected $page_element;
	/**
	 * parameters of the page
	 *
	 * @var array
	 */
	protected $parameters;
	/**
	 * route of the page
	 *
	 * @var array
	 */
	protected $route;
	/**
	 * constructor
	 *
	 * @param array $attributes Attributes of the page
	 *
	 * @return bool
	 */
	public function __construct($attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['start']);

		if ($this->hydrate($attributes) <= 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['__construct']['no_attributes']);

			return False;
		}
		if (!$this->get('id'))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['__construct']['no_route']);

			return False;
		}
		$Route = $this->retrieveRoute();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['loading_files']);
		$Route->loadSubFiles();

		$this->retrieveParamaters();

		if (isset($this->get('parameters')['preset']) && in_array($this->get('parameters')['preset'], $GLOBALS['config']['class']['content']['pageelement']['preset']['list']))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['preset']);

			$page_element = $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$this->get('parameters')['preset']['list']]['page_element']();
			$notification_element = $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$this->get('parameters')['preset']['list']]['notification_element']();
		}
		else
		{
			$page_element = $GLOBALS['config']['class']['content']['pageelement']['presets'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['page_element']();
			$notification_element = $GLOBALS['config']['class']['content']['pageelement']['preset'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['notification_element']();
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['notifications']);
		$page_element->set('notifications', \user\Notification::getNotifications($notification_element));

		$this->set('page_element', $page_element);
		return True;
	}
	/**
	 * Add a custom temporal parameter to the page
	 *
	 * @param string $key Parameter name
	 *
	 * @param mixed $value Parameter value
	 *
	 * @return bool
	 */
	public function addParameter($key, $value)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['addParameter']['start'], array('key' => $key, 'value' => $value));

		if (count($this->get('parameters')) == 0)
		{
			$this->set('parameters') = array($key => $value);

			return True;
		}
		else
		{
			if ($this->get('parameters')[$key] != null)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Page']['addParameter']['already'], array('key' => $key, 'value' => $value, 'old' => $this->get('parameters')[$key]));

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
	public function display()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['display']);

		return $this->displayer('page_element');
	}
	/**
	 * Load the php file associated to the page
	 *
	 * @return bool
	 */
	public function load()
	{
		$Route = $this->retrieveRoute();
		$Folder = $Route->retrieveFolder();

		$file = $Folder->getPath() . $GLOBALS['config']['class']['user']['Page']['filename'];

		if (!is_file($file))
		{
			return False;
		}

		return include($file);
	}
	/**
	 * Retrieve parameters of the page in the database
	 *
	 * @return bool
	 */
	public function retrieveParameters()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParamaters']['start']);

		$LinkPageParameters = new \user\LinkPageParameters();
		$parameters = $LinkPageParameters->retrieveBy(array(
			'id_page' => $this->get('id'),
		), '\user\Parameter');

		$this->set('parameters', $parameters);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParamaters']['loaded'], array('number' => count($parameters)));

		return count($parameters) != 0;
	}
	/**
	 * Retrieve route of the page
	 *
	 * @return \route\Route|False
	 */
	public function retrieveRoute()
	{
		$RouteManager = \route\RouteManager();
		if (!$routeManager->exist(array('id' => $this->get('id'))))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['retrieveRoute']['no_exist']);

			return False;
		}

		return $routeManager->retrieveBy(array(
			'id' => $this->get('id'),
		))[0];
	}
}

?>
