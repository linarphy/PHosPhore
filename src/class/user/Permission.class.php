<?php

namespace user;

/**
 * Permission associated to a page
 */
class Permission extends \core\Managed
{
	/**
	 * index of the permission in the database
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * index of the route in the database
	 *
	 * @var int
	 */
	protected $id_route;
	/**
	 * name of the role in the database
	 *
	 * @var string
	 */
	protected $name_role;
	/**
	 * retrieves the route
	 *
	 * @return \route\Route
	 */
	public function retrieveRoute()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Permission']['retrieveRoute']);
		$Route = new \route\Route(array(
			'id' => $this->get('id_route'),
		));
		$Route->retrieve();

		return $Route;
	}
}

?>
