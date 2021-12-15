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
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id'   => 'int',
		'name' => 'string',
	);
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
		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['user']['Page']['__construct']['no_route']);

			return False;
		}
		$Route = $this->retrieveRoute();

		$this->retrieveParameters();

		$PageElement = new \content\pageelement\PageElement(array()); // I need configuration of this class to load after this point, it's dumb but it's the simple way for now

		if (isset($this->get('parameters')['preset']) && $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$this->get('parameters')['preset']])
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['preset'], array('preset' => $this->get('parameters')['preset']));

			$page_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$this->get('parameters')['preset']]['page_element'](array());
			$notification_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$this->get('parameters')['preset']]['notification_element'](array());
		}
		else
		{
			$page_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['page_element'](array());
			$notification_element = new $GLOBALS['config']['class']['content']['pageelement']['preset']['list'][$GLOBALS['config']['class']['content']['pageelement']['preset']['default']]['notification_element'](array());
		}

		$Notifications = \user\Notification::getNotifications($notification_element);
		$page_element->setElement($GLOBALS['config']['class']['content']['pageelement']['preset']['notification_element_name'], $Notifications);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['notifications'], array('number' => count($Notifications)));

		$this->set('page_element', $page_element);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['__construct']['end']);
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
			$this->set('parameters', array($key => $value));

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
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['start']);

		$Route = $this->retrieveRoute();
		$Folder = $Route->retrieveFolder();

		$file = $GLOBALS['config']['core']['path']['page'] . $Folder->getPath() . $GLOBALS['config']['class']['user']['Page']['filename'];

		if (!is_file($file))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Page']['load']['no_file'], array('file' => $file));

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['subfiles']);

		$Route->loadSubFiles();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['load']['include'], array('file' => $file));

		return include($file);
	}
	/**
	 * Retrieve parameters of the page in the database
	 *
	 * @return bool
	 */
	public function retrieveParameters()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['start']);

		$LinkPageParameters = new \user\LinkPageParameter();
		$parameters = $LinkPageParameters->retrieveBy(array(
			'id_page' => $this->get('id'),
		), class_name: '\user\Parameter');

		$this->set('parameters', $parameters);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['loaded'], array('number' => count($parameters)));

		return count($parameters) != 0;
	}
	/**
	 * Retrieve route of the page
	 *
	 * @return \route\Route|False
	 */
	public function retrieveRoute()
	{
		$routeManager = new \route\RouteManager();
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
