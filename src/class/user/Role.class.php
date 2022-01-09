<?php

namespace user;

/**
 * Role of an user, possess a set of permission to access pages
 */
class Role
{
	/**
	 * name of the role
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * permissions of the role
	 *
	 * @var array
	 */
	protected ?array $permissions = null;
	/**
	 * constructor
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['__construct']);

		foreach ($attributes as $attribute => $value)
		{
			if (\property_exists($this, $attribute))
			{
				$this->$attribute = $value;
			}
		}

		$this->retrievePermissions();
	}
	public function add() : void
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['add']['start']);

		$this->addPermissions();
	}
	/**
	 * add permissions to the role
	 */
	public function addPermissions() : void
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Role']['addPermissions'], ['permissions' => $id, 'role' => $this->name]);

		$LinkPermissionRole = new \user\LinkPermission\Role();

		$results = [];
		foreach ($this->get('permissions') as $permission)
		{
			$results[] = ['id_permission' => $permission->get('id')];
		}

		$LinkPermissionRole->addBy($results, [
			'name_role' => $this->name,
		]);
	}
	/**
	 * access to permissions property
	 *
	 * @return array
	 */
	public function getPermissions() : array
	{
		return $this->permissions;
	}
	/**
	 * retrieves permissions of the role
	 *
	 * @return array
	 */
	public function retrievePermissions() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['retrievePermissions']);

		$PermissionManager = new \user\PermissionManager();

		$this->permissions = $PermissionManager->retrieveBy([
			'name_role' => $this->name,
		]);

		return $this->permissions;
	}
}

?>
