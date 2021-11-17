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
	protected $name;
	/**
	 * permissions of the role
	 *
	 * @var array
	 */
	protected $permissions;
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
			if ($this->$attribute != null)
			{
				$this->$attribute = $value;
			}
		}

		$this->retrievePermissions();
	}
	/**
	 * add permissions to the role
	 *
	 * @param array $id list of indexes of the new permissions
	 */
	public function addPermissions($id)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Role']['addPermissions'], array('permissions' => $id, 'role' => $this->name));

		$LinkPermissionRole = new \user\LinkPermission\Role();

		$results = array();
		foreach ($id as $index)
		{
			$results[] = array('id_permission' => $index);
		}

		$LinkPermissionRole->addBy($results, array(
			'name_role' => $this->name,
		));
	}
	/**
	 * retrieves permissions of the role
	 */
	public function retrievePermissions()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Role']['retrievePermissions']);

		$LinkPermissionRole = new \user\LinkPermissionRole();

		$this->permissions = $LinkPermissionRole->retrieveBy(array(
			'name_role' => $this->name_role,
		), name_class: '\user\Permission', attributes_conversion: array('id_permission' => 'id'));
	}
}

?>
