<?php

namespace user;

/**
 * Website permission
 *
 * @author gugus2000
 **/
class Permission extends \core\Managed
{
	/* Attribute */

		/**
		* Permission index
		*
		* @var int
		*/
		protected $id;
		/**
		* Name of role with permission
		*
		* @var string
		*/
		protected $role_name;
		/**
		* Application in which permission operates
		*
		* @var string
		*/
		protected $application;
		/**
		* Action for which permission is requested
		*
		* @var string
		*/
		protected $action;

	/* Method */

		/* Getter */

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
			* role_name accessor
			*
			* @return string
			*/
			public function getRole_name()
			{
				return $this->role_name;
			}
			/**
			* application accessor
			*
			* @return string
			*/
			public function getApplication()
			{
				return $this->application;
			}
			/**
			* action accessor
			*
			* @return string
			*/
			public function getAction()
			{
				return $this->action;
			}

		/* Setter */

			/**
			* id setter
			*
			* @param int $id Permission index
			*
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* role_name setter
			*
			* @param string $role_name Name of role with permission
			*
			* @return void
			*/
			protected function setRole_name($role_name)
			{
				$this->role_name=(string)$role_name;
			}
			/**
			* application setter
			*
			* @param string $application Application in which permission operates
			*
			* @return void
			*/
			protected function setApplication($application)
			{
				$this->application=(string)$application;
			}
			/**
			* action setter
			*
			* @param string $action Action for which permission is requested
			*
			* @return void
			*/
			protected function setAction($action)
			{
				$this->action=(string)$action;
			}

		/* Display */

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
			* role_name display
			*
			* @return string
			*/
			public function displayRole_name()
			{
				return htmlspecialchars((string)$this->role_name);
			}
			/**
			* application display
			*
			* @return string
			*/
			public function displayApplication()
			{
				return htmlspecialchars((string)$this->application);
			}
			/**
			* action display
			*
			* @return string
			*/
			public function displayAction()
			{
				return htmlspecialchars((string)$this->action);
			}

		/**
		* Permission display
		*
		* @return string
		*/
		public function display()
		{
			htmlspecialchars($this->displayApplication().'-'.$this->displayAction());
		}
} // END class Permission extends \core\Manager

?>