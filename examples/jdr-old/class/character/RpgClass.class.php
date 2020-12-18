<?php

namespace character;

/**
 * A class for the RPG
 *
 * @author gugus2000
 **/
class RpgClass extends \core\Managed
{
	/* attribute */

		/**
		* Id of the Class
		* 
		* @var int
		*/
		protected $id;
		/**
		* Id of the name of the class
		* 
		* @var string
		*/
		protected $id_name;
		/**
		* Id of the attributes of the class
		* 
		* @var int
		*/
		protected $id_attributes;

	/* method */

		/* getter */

			/**
			* id getter
			* 
			* @return int
			*/
			public function getId()
			{
				return $this->id;
			}
			/**
			* id_name getter
			* 
			* @return string
			*/
			public function getId_name()
			{
				return $this->id_name;
			}
			/**
			* id_attributes getter
			* 
			* @return int
			*/
			public function getId_attributes()
			{
				return $this->id_attributes;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the class
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* id_name setter
			*
			* @param string id_name Id of the name of the class
			* 
			* @return void
			*/
			protected function setId_name($id_name)
			{
				$this->id_name=(string)$id_name;
			}
			/**
			* id_attributes setter
			*
			* @param int id_attributes Id of the attributes of the class
			* 
			* @return void
			*/
			protected function setId_attributes($id_attributes)
			{
				$this->id_attributes=(int)$id_attributes;
			}

		/* display */

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
			* id_name display
			* 
			* @return string
			*/
			public function displayId_name()
			{
				return htmlspecialchars((string)$this->id_name);
			}
			/**
			* id_attributes display
			* 
			* @return string
			*/
			public function displayId_attributes()
			{
				return htmlspecialchars((string)$this->id_attributes);
			}

		/**
		* Display the name of the class
		* 
		* @return mixed
		*/
		public function displayName()
		{
			global $Visitor;
			$Name=new \content\Content(array(
				'id_content' => $this->getId_name(),
			));
			$Name->retrieveLang($Visitor->getConfiguration('lang'));
			return $Name->display();
		}
		/**
		* Retrieve the attributes of the character
		* 
		* @return character\Attribute
		*/
		public function retrieveAttributes()
		{
			if ($this->getId_attributes()!==null)
			{
				$Attributes=new \character\Attributes(array(
					'id' => $this->getId_attributes(),
				));
				$Attributes->retrieve();
				return $Attributes;
			}
		}
} // END class Class extends \core\Managed

?>