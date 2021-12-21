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
	protected ?int $id = null;
	/**
	 * index of the route in the database
	 *
	 * @var int
	 */
	protected ?int $id_route = null;
	/**
	 * name of the role in the database
	 *
	 * @var string
	 */
	protected ?string $name_role = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id'        => 'int',
		'id_route'  => 'int',
		'name_role' => 'string',
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
	 * retrieves the route
	 *
	 * @return \route\Route
	 */
	public function retrieveRoute() : \route\Route
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Permission']['retrieveRoute']);
		$Route = new \route\Route([
			'id' => $this->get('id_route'),
		]);
		$Route->retrieve();

		return $Route;
	}
}

?>
