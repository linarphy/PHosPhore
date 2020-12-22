<?php

namespace item;

/**
 * A stored item which has all his attribute static
 *
 * @author gugus2000,
 **/
class StoredItem extends \core\Managed
{
	/* attribute */

		/**
		* Id of the stored item
		* 
		* @var int
		*/
		protected $id;
		/**
		* Type of the stored item
		* 
		* @var int
		*/
		protected $type;
		/**
		* Id of the name of the item
		* 
		* @var int
		*/
		protected $id_name;
		/**
		* Id correponding to the dynamic version (classical) of the item
		* 
		* @var int
		*/
		protected $id_dynamic;
		/**
		* Value of the stored item
		* 
		* @var int
		*/
		protected $value;
		/**
		* Quality of the stored item
		* 
		* @var int
		*/
		protected $quality;
		/**
		* Id of the associated stored enchantment (0 if unenchanted)
		* 
		* @var int
		*/
		protected $id_enchantment;

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
			* id_dynamic getter
			* 
			* @return int
			*/
			public function getId_dynamic()
			{
				return $this->id_dynamic;
			}
			/**
			* value getter
			* 
			* @return int
			*/
			public function getValue()
			{
				return $this->value;
			}
			/**
			* quality getter
			* 
			* @return int
			*/
			public function getQuality()
			{
				return $this->quality;
			}
			/**
			* id_enchantment getter
			* 
			* @return int
			*/
			public function getId_enchantment()
			{
				return $this->id_enchantment;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the stored item
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
			* @param int type Type of the stored item
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
			* @param int id_name Od of the name of the stored item
			* 
			* @return void
			*/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/**
			* id_dynamic setter
			*
			* @param int id_dynamic Id correponding to the dynamic version (classical) of the item
			* 
			* @return void
			*/
			protected function setId_dynamic($id_dynamic)
			{
				$this->id_dynamic=(int)$id_dynamic;
			}
			/**
			* value setter
			*
			* @param int value Value of the stored item
			* 
			* @return void
			*/
			protected function setValue($value)
			{
				$this->value=(int)$value;
			}
			/**
			* quality setter
			*
			* @param int quality Quality of the stored item
			* 
			* @return void
			*/
			protected function setQuality($quality)
			{
				$this->quality=(int)$quality;
			}
			/**
			* id_enchantment setter
			*
			* @param int id_enchantment Id of the associated stored enchantment (0 if unenchanted)
			* 
			* @return void
			*/
			protected function setId_enchantment($id_enchantment)
			{
				$this->id_enchantment=(int)$id_enchantment;
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
			* id_dynamic display
			* 
			* @return string
			*/
			public function displayId_dynamic()
			{
				return htmlspecialchars((string)$this->id_dynamic);
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
			* quality display
			* 
			* @return string
			*/
			public function displayQuality()
			{
				return htmlspecialchars((string)$this->quality);
			}
			/**
			* id_enchantment display
			* 
			* @return string
			*/
			public function displayId_enchantment()
			{
				return htmlspecialchars((string)$this->id_enchantment);
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
		* Display the stored Item
		* 
		* @return string
		*/
		public function display()
		{
			if (!$this->isEnchanted())
			{
				return $this->displayName();
			}
			return $this->displayName().' '.$this->retrieveEnchantment()->display();
		}
		/**
		* Retrieve the dynamic version of this item (unenchanted only)
		* 
		* @return \item\Item
		*/
		public function retrieveDynamic()
		{
			if ($this->getId_dynamic()!==null)
			{
				$Dynamic=\item\Item::generateItem(array(
					'type' => $this->getType(),
					'strict_enchant' => False,
				));
				$Manager=$Dynamic->Manager();
				$Item=new \item\Item(array(
					'id' => $this->getId_dynamic(),
				));
				$Item->retrieve();
				return $Item;
			}
		}
		/**
		* Retrieve an enchantment
		* 
		* @return \item\echant\StoredEnchantment
		*/
		public function retrieveEnchantment()
		{
			if ($this->isEnchanted())
			{
				$Enchantment=new \item\enchant\StoredEnchantment(array(
					'id' => $this->getId_enchantment(),
				));
				$Enchantment->retrieve();
				return $Enchantment;
			}
		}
		/**
		* Check if the item is enchanted
		* 
		* @return bool
		*/
		public function isEnchanted()
		{
			return $this->getId_enchantment()!==null && $this->getId_enchantment()!==0;
		}
		
} // END class StoredItem extends \core\Managed

?>