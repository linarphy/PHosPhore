<?php

namespace item\enchant;

/**
 * A stored enchantment which has all his value static
 *
 * @author gugus2000
 **/
class StoredEnchantment extends \core\Managed
{
	/* attribute */

		/**
		* Id of the stored enchantment
		* 
		* @var int
		*/
		protected $id;
		/**
		* Type of the stored enchantment
		* 
		* @var int
		*/
		protected $type;
		/**
		* Id of the name of the stored enchantment
		* 
		* @var int
		*/
		protected $id_name;
		/**
		* Id of the description of the stored enchantment
		* 
		* @var int
		*/
		protected $id_description;
		/**
		* Id correponding to the dynamic version (classical) of the enchantment
		* 
		* @var int
		*/
		protected $id_dynamic;
		/**
		* Stored modifiers of the stored enchantment
		* 
		* @var array
		*/
		protected $modifiers;

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
			* type getter
			* 
			* @return int
			*/
			public function getType()
			{
				return $this->type;
			}
			/**
			* id_name getter
			* 
			* @return int
			*/
			public function getId_name()
			{
				return $this->id_name;
			}
			/**
			* id_description getter
			* 
			* @return int
			*/
			public function getId_description()
			{
				return $this->id_description;
			}
			/**
			* id_dynamic getter
			* 
			* @return int
			*/
			public function getId_dynamic()
			{
				return $this->id_dynamic;
			}
			/**
			* modifiers getter
			* 
			* @return array
			*/
			public function getModifiers()
			{
				return $this->modifiers;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the stored enchantment
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* type setter
			*
			* @param int type Type of the stored enchantment
			* 
			* @return void
			*/
			protected function setType($type)
			{
				$this->type=(int)$type;
			}
			/**
			* id_name setter
			*
			* @param int id_name Id of the name of the stored enchantment
			* 
			* @return void
			*/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/**
			* id_description setter
			*
			* @param int id_description Id of the description of the enchantment
			* 
			* @return void
			*/
			protected function setId_description($id_description)
			{
				$this->id_description=(int)$id_description;
			}
			/**
			* id_dynamic setter
			*
			* @param int id_dynamic Id correponding to the dynamic version (classical) of the enchantment
			* 
			* @return void
			*/
			protected function setId_dynamic($id_dynamic)
			{
				$this->id_dynamic=(int)$id_dynamic;
			}
			/**
			* modifiers setter
			*
			* @param array modifiers Stored mofiers of the stored enchantment
			* 
			* @return void
			*/
			protected function setModifiers($modifiers)
			{
				$this->modifiers=$modifiers;
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
			* type display
			* 
			* @return string
			*/
			public function displayType()
			{
				return htmlspecialchars((string)$this->type);
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
			* id_description display
			* 
			* @return string
			*/
			public function displayId_description()
			{
				return htmlspecialchars((string)$this->id_description);
			}
			/**
			* id_dynamic display
			* 
			* @return string
			*/
			public function displayId_dynamic()
			{
				return htmlspecialchars((string)$this->id_dynamic);
			}
			/**
			* modifiers display
			* 
			* @return string
			*/
			public function displayModifiers()
			{
				$display='';
				foreach ($this->modifiers as $modifier)
				{
					$display.=$modifier->display();
				}
				return $display;
			}


		/**
		* Retrieve an enchantment
		* 
		* @return void
		*/
		public function retrieve()
		{
			parent::retrieve();
			$this->retrieveModifiers();
		}
		/**
		* Display a stored Enchantment
		* 
		* @return string
		*/
		public function display()
		{
			$description=$this->displayDescription();
			if (!empty($this->modifiers))
			{
				foreach ($this->modifiers as $modifier)
				{
					$description=str_replace('|'.$modifier->getReplacer().'|', (string)($modifier->getUpgrade()), $description);
				}
			}
			return $this->displayName().' | '.$description;
		}
		/**
		* Display the name of the enchantment
		* 
		* @return string
		*/
		public function displayName()
		{
			global $Visitor;
			$Name=new \content\Content(array(
				'id_content' => $this->getId_name(),
			));
			$Name->retrieveLang($Visitor->getConfiguration('lang'));
			return $Name->display();
		}/**
		* Display the description of the enchantment
		* 
		* @return string
		*/
		public function displayDescription()
		{
			global $Visitor;
			$Description=new \content\Content(array(
				'id_content' => $this->getId_description(),
			));
			$Description->retrieveLang($Visitor->getConfiguration('lang'));
			return $Description->display();
		}
		/**
		* Retrieve Modifiers
		* 
		* @return void
		*/
		public function retrieveModifiers()
		{
			$Manager=new \item\enchant\StoredModifierManager(\core\DBFactory::MysqlConnection());
			$this->setModifiers($Manager->retrieveBy(array(
				'id_enchant' => $this->getId(),
			), array(
				'id_enchant' => '=',
			)));
		}
} // END class StoredEnchantment extends \core\Managed

?>