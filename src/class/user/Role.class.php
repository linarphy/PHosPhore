<?php

namespace user;

/**
 * Role of an user, possess a set of permission to access pages
 */
class Role extends \core\Managed
{
	/**
	 * id of the user
	 *
	 * @var int
	 */
	protected ?int $id_user;
	/**
	 * name of the role
	 *
	 * @var string
	 */
	protected ?string $name_role = null;
	/**
	 * attributes with type
	 *
	 * @var arry
	 */
	const ATTRIBUTES = [
		'id_user'   => 'int',
		'name_role' => 'string',
	];
	/**
	 * Insert the role in the database
	 *
	 * @return array
	 */
	public function add() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['add']['start'], ['role' => $this->get('name_role'), 'user' => $this->get('id_user')]);

		$LinkRoleUser = new \user\LinkRoleUser();
		return $LinkRoleUser->add($this->table());
	}
	/**
	 * Get the permissions of this role
	 *
	 * @var array
	 */
	public function getPermissions()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['getPermissions']);

		$PermissionManager = new \user\PermissionManager();

		$this->permissions = $PermissionManager->retrieveBy([
			'name_role' => $this->get('name_role'),
		]);

		return $this->permissions;

	}
}

?>
