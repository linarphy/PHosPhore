<?php

namespace user;

/**
 * User configuration
 *
 * @author gugus2000
 **/
class Configuration extends \core\Managed
{
	/* Attribute */

		/**
		* Configuration Id
		* 
		* @var int
		*/
		protected $id;
		/**
		* Configuration user id
		* 
		* @var int
		*/
		protected $id_user;
		/**
		* Configuration name
		* 
		* @var string
		*/
		protected $name;
		/**
		* Configuration value
		* 
		* @var mixed
		*/
		protected $value;

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
			* id_user accessor
			* 
			* @return int
			*/
			public function getId_user()
			{
				return $this->id_user;
			}
			/**
			* name accessor
			* 
			* @return string
			*/
			public function getName()
			{
				return $this->name;
			}
			/**
			* value accessor
			* 
			* @return mixed
			*/
			public function getValue()
			{
				return $this->value;
			}

		/* Setter */

			/**
			* id setter
			*
			* @param int $id Configuration id
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* id_user setter
			*
			* @param int $id_user Configuration user id
			* 
			* @return void
			*/
			protected function setId_user($id_user)
			{
				$this->id_user=(int)$id_user;
			}
			/**
			* name setter
			*
			* @param string $name Configuration name
			* 
			* @return void
			*/
			protected function setName($name)
			{
				$this->name=(string)$name;
			}
			/**
			* value setter
			*
			* @param mixed $value Configuration value
			* 
			* @return void
			*/
			protected function setValue($value)
			{
				$this->value=$value;
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
			* id_user display
			* 
			* @return string
			*/
			public function displayId_user()
			{
				return htmlspecialchars((string)$this->id_user);
			}
			/**
			* name display
			* 
			* @return string
			*/
			public function displayName()
			{
				return htmlspecialchars((string)$this->name);
			}
			/**
			* value display
			* 
			* @return string
			*/
			public function displayValue()
			{
				return htmlspecialchars((string)$this->value);
			}

		/**
		* \user\Configuration display
		* 
		* @return string
		*/
		public function display()
		{
			return $this->displayName().':'.$this->displayValue();
		}
} // END class Configuration extends \core\Managed

?>