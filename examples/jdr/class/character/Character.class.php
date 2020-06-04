<?php

namespace character;

/**
 * A character of the RPG
 *
 * @author gugus2000
 **/
class Character extends \core\Managed
{
	/* attribute */

		/**
		* Id of the character
		* 
		* @var int
		*/
		protected $id;
		/**
		* Name of the character
		* 
		* @var string
		*/
		protected $name;
		/**
		* Id_race of the character
		* 
		* @var int
		*/
		protected $id_race;
		/**
		* Id_class of the character
		* 
		* @var int
		*/
		protected $id_class;
		/**
		* Hp of the character
		* 
		* @var int
		*/
		protected $hp;
		/**
		* Maximum hp of the character
		* 
		* @var int
		*/
		protected $max_hp;
		/**
		* Mana of the character
		* 
		* @var int
		*/
		protected $mana;
		/**
		* Maximum mana of the character
		* 
		* @var int
		*/
		protected $max_mana;
		/**
		* AP of the character
		* 
		* @var int
		*/
		protected $ap;
		/**
		* Maximum ap of the character
		* 
		* @var int
		*/
		protected $max_ap;
		/**
		* Level of the character
		* 
		* @var int
		*/
		protected $level;
		/**
		* Xp of the character
		* 
		* @var int
		*/
		protected $xp;
		/**
		* Id of the inventory of the character
		* 
		* @var int
		*/
		protected $id_inventory;
		/**
		* Attributes of the character
		* 
		* @var int
		*/
		protected $id_attributes;
		/**
		* Max attributes of the character
		* 
		* @var int
		*/
		protected $id_maxattributes;
		/**
		* Id of the author of the character
		* 
		* @var int
		*/
		protected $id_author;

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
			* name getter
			* 
			* @return string
			*/
			public function getName()
			{
				return $this->name;
			}
			/**
			* id_race getter
			* 
			* @return int
			*/
			public function getId_race()
			{
				return $this->id_race;
			}
			/**
			* id_class getter
			* 
			* @return int
			*/
			public function getId_class()
			{
				return $this->id_class;
			}
			/**
			* hp getter
			* 
			* @return int
			*/
			public function getHp()
			{
				return $this->hp;
			}
			/**
			* max_hp getter
			* 
			* @return int
			*/
			public function getMax_hp()
			{
				return $this->max_hp;
			}
			/**
			* mana getter
			* 
			* @return int
			*/
			public function getMana()
			{
				return $this->mana;
			}
			/**
			* max_mana getter
			* 
			* @return int
			*/
			public function getMax_mana()
			{
				return $this->max_mana;
			}
			/**
			* ap getter
			* 
			* @return int
			*/
			public function getAp()
			{
				return $this->ap;
			}
			/**
			* max_ap getter
			* 
			* @return int
			*/
			public function getMax_ap()
			{
				return $this->max_ap;
			}
			/**
			* level getter
			* 
			* @return int
			*/
			public function getLevel()
			{
				return $this->level;
			}
			/**
			* xp getter
			* 
			* @return int
			*/
			public function getXp()
			{
				return $this->xp;
			}
			/**
			* id_inventory getter
			* 
			* @return int
			*/
			public function getId_inventory()
			{
				return $this->id_inventory;
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
			/**
			* id_maxattributes getter
			* 
			* @return int
			*/
			public function getId_maxattributes()
			{
				return $this->id_maxattributes;
			}
			/**
			* id_author getter
			* 
			* @return int
			*/
			public function getId_author()
			{
				return $this->id_author;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the character
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* name setter
			*
			* @param string name Name of the character
			* 
			* @return void
			*/
			protected function setName($name)
			{
				$this->name=(string)$name;
			}
			/**
			* id_race setter
			*
			* @param int id_race Id_race of the character
			* 
			* @return void
			*/
			protected function setId_race($id_race)
			{
				$this->id_race=(int)$id_race;
			}
			/**
			* id_class setter
			*
			* @param int id_class Id_class of the character
			* 
			* @return void
			*/
			protected function setId_class($id_class)
			{
				$this->id_class=(int)$id_class;
			}
			/**
			* hp setter
			*
			* @param int hp Hp of the character
			* 
			* @return void
			*/
			protected function setHp($hp)
			{
				$this->hp=(int)$hp;
			}
			/**
			* max_hp setter
			*
			* @param int max_hp Maximum hp of the character
			* 
			* @return void
			*/
			protected function setMax_hp($max_hp)
			{
				$this->max_hp=(int)$max_hp;
			}
			/**
			* mana setter
			*
			* @param int mana Mana of the character
			* 
			* @return void
			*/
			protected function setMana($mana)
			{
				$this->mana=(int)$mana;
			}
			/**
			* max_mana setter
			*
			* @param int max_mana Maximum mana of the character
			* 
			* @return void
			*/
			protected function setMax_mana($max_mana)
			{
				$this->max_mana=(int)$max_mana;
			}
			/**
			* ap setter
			*
			* @param int ap AP of the character
			* 
			* @return void
			*/
			protected function setAp($ap)
			{
				$this->ap=(int)$ap;
			}
			/**
			* max_ap setter
			*
			* @param int max_ap Maximum ap of the character
			* 
			* @return void
			*/
			protected function setMax_ap($max_ap)
			{
				$this->max_ap=(int)$max_ap;
			}
			/**
			* level setter
			*
			* @param int level Level of the character
			* 
			* @return void
			*/
			protected function setLevel($level)
			{
				$this->level=(int)$level;
			}
			/**
			* xp setter
			*
			* @param int xp Xp of the character
			* 
			* @return void
			*/
			protected function setXp($xp)
			{
				$this->xp=(int)$xp;
			}
			/**
			* id_inventory setter
			*
			* @param int id_inventory Id of the inventory of the character
			* 
			* @return void
			*/
			protected function setId_inventory($id_inventory)
			{
				$this->id_inventory=(int)$id_inventory;
			}
			/**
			* id_attributes setter
			*
			* @param int id_attributes Attributes of the character
			* 
			* @return void
			*/
			protected function setId_attributes($id_attributes)
			{
				$this->id_attributes=$id_attributes;
			}
			/**
			* id_maxattributes setter
			*
			* @param int id_maxattributes Max of the attributes of the character
			* 
			* @return void
			*/
			protected function setId_maxattributes($id_maxattributes)
			{
				$this->id_maxattributes=(int)$id_maxattributes;
			}
			/**
			* id_author setter
			*
			* @param int id_author Id ot the author of the character
			* 
			* @return void
			*/
			protected function setId_author($id_author)
			{
				$this->id_author=(int)$id_author;
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
			* name display
			* 
			* @return string
			*/
			public function displayName()
			{
				return htmlspecialchars((string)$this->name);
			}
			/**
			* id_race display
			* 
			* @return string
			*/
			public function displayId_race()
			{
				return htmlspecialchars((string)$this->id_race);
			}
			/**
			* id_class display
			* 
			* @return string
			*/
			public function displayId_class()
			{
				return htmlspecialchars((string)$this->id_class);
			}
			/**
			* hp display
			* 
			* @return string
			*/
			public function displayHp()
			{
				return htmlspecialchars((string)$this->hp);
			}
			/**
			* max_hp display
			* 
			* @return string
			*/
			public function displayMax_hp()
			{
				return htmlspecialchars((string)$this->max_hp);
			}
			/**
			* mana display
			* 
			* @return string
			*/
			public function displayMana()
			{
				return htmlspecialchars((string)$this->mana);
			}
			/**
			* max_mana display
			* 
			* @return string
			*/
			public function displayMax_mana()
			{
				return htmlspecialchars((string)$this->max_mana);
			}
			/**
			* ap display
			* 
			* @return string
			*/
			public function displayAp()
			{
				return htmlspecialchars((string)$this->ap);
			}
			/**
			* max_ap display
			* 
			* @return string
			*/
			public function displayMax_ap()
			{
				return htmlspecialchars((string)$this->max_ap);
			}
			/**
			* level display
			* 
			* @return string
			*/
			public function displayLevel()
			{
				return htmlspecialchars((string)$this->level);
			}
			/**
			* xp display
			* 
			* @return string
			*/
			public function displayXp()
			{
				return htmlspecialchars((string)$this->xp);
			}
			/**
			* id_inventory display
			* 
			* @return string
			*/
			public function displayId_inventory()
			{
				return htmlspecialchars((string)$this->id_inventory);
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
			* id_maxattributes display
			* 
			* @return string
			*/
			public function displayId_maxattributes()
			{
				return htmlspecialchars((string)$this->id_maxattributes);
			}
			/**
			* id_author display
			* 
			* @return string
			*/
			public function displayId_author()
			{
				return htmlspecialchars((string)$this->id_author);
			}

		/**
		* Retrieve the race of the character
		* 
		* @return character\Race
		*/
		public function retrieveRace()
		{
			if ($this->getId_race()!==null)
			{
				$Race=new \character\Race(array(
					'id' => $this->getId_race(),
				));
				$Race->retrieve();
				return $Race;
			}
		}
		/**
		* Retrieve the class of the character
		* 
		* @return character\RpgClass
		*/
		public function retrieveClass()
		{
			if ($this->getId_class()!==null)
			{
				$Class=new \character\RpgClass(array(
					'id' => $this->getId_class(),
				));
				$Class->retrieve();
				return $Class;
			}
		}
		/**
		* Retrieve the inventory of the character
		* 
		* @return array
		*/
		public function retrieveInventory()
		{
			if ($this->getId_inventory()!==null)
			{
				$Inventory=new \character\Inventory(array(
					'id_inventory' => $this->getId_inventory(),
				));
				$Inventory->retrieve();
				return $Inventory;
			}
		}
		/**
		* Retrieve the attributes of the character
		* 
		* @return character\Attributes
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
		/**
		* Retrieve the maximum of the attributes of the character
		* 
		* @return character\Attribute
		*/
		public function retrieveMaxAttributes()
		{
			if ($this->getId_maxattributes()!==null)
			{
				$Attributes=new \character\Attributes(array(
					'id' => $this->getId_maxattributes(),
				));
				$Attributes->retrieve();
				return $Attributes;
			}
		}
		/**
		* Retrieve the author of the character
		* 
		* @return user\User
		*/
		public function retrieveAuthor()
		{
			if ($this->getId_author()!==null)
			{
				$Author=new \user\User(array(
					'id' => $this->getId_author(),
				));
				$Author->retrieve();
				return $Author;
			}
		}
		/**
		* Up the character level
		*
		* @param character\Attributes attributes Attributes to add
		* 
		* @return void
		*/
		public function upLevel($attributes)
		{
			$attributes_cha=$this->retrieveAttributes();
			$attributes_arr=array();
			foreach (\character\Attributes::AV_ATTR as $attribute)
			{
				$method=$this->getGet($attribute);
				$attributes_arr[$attribute]=(int)$attributes->$method()+$attributes_cha->$method();
			}
			$attributes_cha->delete();									// clean previous attributes
			$Attributes=new \character\Attributes($attributes_arr);
			$Attributes->create();
			$this->setId_attributes($Attributes->getId());
			$this->setLevel($this->getLevel()+1);						// level+1
		}
		/**
		* Calculate the level the character must have with his xp
		* 
		* @return int
		*/
		public function calcLevel()
		{
			return floor(0.18*sqrt($this->getXp()));
		}
		/**
		* Calculate the attributes of the character (attributes aready inserted are added)
		* 
		* @return \character\Attributes
		*/
		public function calcAttributes()
		{
			if ($this->getId_attributes()!==null)
			{
				$attributes_cha=$this->retrieveAttributes();
			}
			else
			{
				$attributes=array();
				foreach (\character\Attributes::AV_ATTR as $attribute)
				{
					$attributes[$attribute]=0;
				}
				$attributes_cha=new \character\Attributes($attributes);
			}
			$attributes_cla=$this->retrieveClass()->retrieveAttributes();
			$attributes_rac=$this->retrieveRace()->retrieveAttributes();
			$attributes_arr=array();
			foreach (\character\Attributes::AV_ATTR as $attribute)
			{
				$method=$this->getGet($attribute);
				$attributes_arr[$attribute]=$attributes_cha->$method()+$attributes_cla->$method()+$attributes_rac->$method();
			}
			return new \character\Attributes($attributes_arr);
		}
		/**
		* Initialize the character (default value already inserted are added to calculated one)
		* 
		* @return void
		*/
		public function init()
		{
			$Attributes=$this->calcAttributes();
			$Attributes->create();
			if ($this->getId_attributes()!==null)
			{
				$attributes_cha=new \character\Attributes(array(
					'id' => $this->getId_attributes(),
				));
				$attributes_cha->delete();										// clean previous attributes (taken as default one)
			}
			if ($this->getId_inventory()===null)
			{
				$this->setId_inventory(\character\Inventory::determineNewId());
			}
			$this->setId_attributes($Attributes->getId());
			$attributes=$Attributes->table();
			unset($attributes['id']);
			$MaxAttributes=new \character\Attributes($attributes);
			$MaxAttributes->create();
			$this->setId_maxattributes($MaxAttributes->getId());
			$this->setMax_Hp($this->getHp()+$Attributes->getCon());					// default HP + CON value
			$this->setMax_Mana($this->getMana()+$Attributes->getMag());				// default mana + MAG value
			$this->setMax_Ap($this->getAp()+2+floor($Attributes->getAgi()/10));		// 2+ default AP + floor(AGI value/10)
			$this->setHp($this->getMax_hp());
			$this->setMana($this->getMax_mana());
			$this->setAp($this->getMax_ap());
			$this->setXp(0);
			$this->setLevel(0);
		}
		/**
		* Add a stored item
		*
		* @param \item\StoredItem item Stored item to add to the inventory
		*
		* @param int number Number of item in the inventory
		* 
		* @return void
		*/
		public function addToInventory($item, int $number=1)
		{
			$Inventory=$this->retrieveInventory();
			$Inventory->retrieve();
			if (empty($Inventory->getItems()))
			{
				$this->setId_inventory(\character\Inventory::determineNewId());
			}
			foreach ($Inventory->getItems() as $Item)
			{
				if ($item->getId()===$Item['id_item'])
				{
					$Inventory=new \character(array(
						'id_inventory' => $this->getId_inventory(),
						'id_item'      => $Item['id_item'],
						'number'       => $Item['number']+$number,
					));
					$Inventory->//updateBy
				}
			}
			$Inventory=new \character\Inventory(array(
				'id_inventory' => $this->getId_inventory(),
				'id_item'      => $item->getId(),
				'number'       => $number,
			));
			$Inventory->create();
		}
} // END class Character extends \core\Managed

?>