<?php

namespace user;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
class Role extends \core\Managed
{
	/* Attribute */

		/**
		* Role name
		*
		* @var string
		*/
		protected $role_name;
		/**
		* Id of the user with the role
		*
		* @var int
		*/
		protected $id;
		/**
		* Permissions granted to the role
		*
		* @var array
		*/
		protected $permissions;

	/* Method */

		/* Getter */

			/**
			* role_name accessor
			*
			* @return string
			*/
			public function getRole_name()
			{
				return $this->role_name;
			}
			/**
			* id accessor
			*
			* @return int
			*/
			public function getId()
			{
				return $this->id;
			}
			/**
			* permissions accessor
			*
			* @return array
			*/
			public function getPermissions()
			{
				return $this->permissions;
			}

		/* Setter */

			/**
			* role_name setter
			*
			* @param string $role_name Role name
			*
			* @return void
			*/
			protected function setRole_name($role_name)
			{
				$this->role_name=(string)$role_name;
			}
			/**
			* id setter
			*
			* @param int $id Id of the user with the role
			*
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* premissions setter
			*
			* @param array $permissions Permissions granted to the roll
			*
			* @return void
			*/
			protected function setPermissions($permissions)
			{
				$this->permissions=$permissions;
			}

		/* Display */

			/**
			* role_name display
			*
			* @return string
			*/
			public function displayRole_name()
			{
				return htmlspecialchars((string)$this->nom_role);
			}
			/**
			* id display
			*
			* @return string
			*/
			public function displayId()
			{
				return htmlspecialchars((string)$this->id);
			}
			/**
			* permissions display
			*
			* @return string
			*/
			public function displayPermissions()
			{
				$display=array();
				foreach ($this->permissions as $permission)
				{
					array_push($display, $permission->display());
				}
				return htmlspecialchars((string)implode(', ', $affichage));
			}

		/**
		* Accessor of a permission
		*
		* @param int $index Permission index in permissions
		*
		* @return \user\Permission
		*/
		public function getPermission($index)
		{
			return $this->permissions[$index];
		}
		/**
		* Permission setter
		*
		* @param int $index Permission index in permissions
		*
		* @param \user\Permission $permission Permission to be defined
		* 
		* @return void
		*/
		public function setPermission($index, $permission)
		{
			$this->permissions[$index]=$permission;
		}
		/**
		* Permission display
		*
		* @param int $index Permission index in permissions
		*
		* @return string
		*/
		public function displayPermission($index)
		{
			return htmlspecialchars((string)$this->permissions[$index]->display());
		}
		/**
		* Role display
		*
		* @return string
		*/
		public function display()
		{
			return $this->displayRole_name();
		}
		/**
		* Gets the permissions of the role with the already known role_name
		*
		* @return void
		*/
		public function retrievePermissions()
		{
			new \exception\Notice($GLOBALS['lang']['class']['user']['role']['retrievespermissions'], 'role');
			if ($this->getRole_name())
			{
				$PermissionManager=new \user\PermissionManager(\core\DBFactory::MysqlConnection());
				$permissions=$PermissionManager->getBy(array(
					'role_name' => $this->getRole_name(),
				), array(
					'role_name' => '=',
				));
				$Permissions=array();
				foreach ($permissions as $key => $permission)
				{
					$Permission=new \user\Permission($permission);
					$Permissions[]=$Permission;
				}
				$this->setPermissions($Permissions);
				new \exception\Notice($GLOBALS['lang']['class']['user']['role']['retrievespermissions_end'], 'role');
			}
			else
			{
				new \exception\FatalError($GLOBALS['lang']['class']['user']['role']['error_retrievespermissions'], 'role');
			}
		}
		/**
		* Verifies the existence of permission for the role
		*
		* @param array $link Table containing the different parameters of an internal link
		* 
		* @return bool
		*/
		public function existPermission($link)
		{
			new \exception\Notice($GLOBALS['lang']['class']['user']['role']['existpermission'], 'role');
			global $Router;
			$link=$Router->fill($link);
			$PermissionManager=new \user\PermissionManager(\core\DBFactory::MysqlConnection());
			return $PermissionManager->getBy(array(
				'role_name'   => $this->getRole_name(),
				'application' => $link['application'],
				'action'      => $link['action'],
			), array(
				'role_name'   => '=',
				'application' => '=',
				'action'      => '=',
			));
			new \exception\Notice($GLOBALS['lang']['class']['user']['role']['existpermission_end'], 'role');
		}
		/**
		* Retrieves the role from its id
		*
		* @return void
		*/
		public function retrieve()
		{
			if ($this->getId())
			{
				parent::retrieve();
				$this->retrievePermissions();
			}
		}
} // END class Role extends \core\managed

?>