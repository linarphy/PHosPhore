<?php

namespace character;

/**
 * An item in an inventory
 *
 * @package jdr
 * @author gugus2000
 **/
class Item extends \core\Managed
{
	/* Constant */

		/**
		 * Type of a magical weapon
		 *
		 * @var string
		 **/
		const TYPE_WEAPON='weapon';
		/**
		 * Type of a shield protection
		 *
		 * @var string
		 **/
		const TYPE_PROTECTION='protection';
		/**
		 * Type of consumable item
		 *
		 * @var string
		 **/
		const TYPE_CONSUMABLE='consumable';
		/**
		 * Type of spell tome
		 *
		 * @var string
		 **/
		const TYPE_SPELL_TOME='spell';
		/**
		 * Type of quest item
		 *
		 * @var string
		 **/
		const TYPE_QUEST_ITEM='quest';
		/**
		 * Type of a tool
		 *
		 * @var string
		 **/
		const TYPE_TOOL='tool';
		/**
		 * Type of a misc stuff
		 *
		 * @var string
		 **/
		const TYPE_MISC='misc';
		/**
		 * Part on the head
		 *
		 * @var string
		 **/
		const PART_HEAD='head';
		/**
		 * Part on the body
		 *
		 * @var sring
		 **/
		const PART_BODY='body';
		/**
		 * Part on the hand
		 *
		 * @var string
		 **/
		const PART_HAND='hand';
		/**
		 * Part on the leg
		 *
		 * @var string
		 **/
		const PART_LEG='leg';
		/**
		 * Part on the feet
		 *
		 * @var string
		 **/
		const PART_FEET='feet';
		/**
		 * Part on the hand
		 *
		 * @var string
		 **/
		const PART_HAND='hand';
		/**
		 * Part on the finger
		 *
		 * @var string
		 **/
		const PART_FINGER='finger';
		/**
		 * Part on the neck
		 *
		 * @var string
		 **/
		const PART_NECK='neck';
		/**
		 * Part on the inventory
		 *
		 * @var string
		 **/
		const PART_INVENTORY='inventory';
		/**
		 * Damage type for physical damage
		 *
		 * @var string
		 **/
		const DAMAGE_PHYSICAL='physical';
		/**
		 * Damage type for CAC damage
		 *
		 * @var string
		 **/
		const DAMAGE_CAC='CAC';
		/**
		 * Damage type for DIS damage
		 *
		 * @var string
		 **/
		const DAMAGE_DIS='DIS';
		/**
		 * Damage type for magical damage
		 *
		 * @var string
		 **/
		const DAMAGE_MAGICAL='magical';
		/**
		 * Damage type for fire damage
		 *
		 * @var string
		 **/
		const DAMAGE_FIRE='fire';
		/**
		 * Damage type for ice damage
		 *
		 * @var string
		 **/
		const DAMAGE_ICE='ice';
		/**
		 * Damage type for earth damage
		 *
		 * @var string
		 **/
		const DAMAGE_EARTH='earth';
		/**
		 * Damage type for water damage
		 *
		 * @var string
		 **/
		const DAMAGE_WATER='water';
		/**
		 * Damage type for lava damage
		 *
		 * @var string
		 **/
		const DAMAGE_LAVA='lava';
		/**
		 * Damage type for shadow damage
		 *
		 * @var string
		 **/
		const DAMAGE_SHADOW='shadow';
		/**
		 * Damage type for light damage
		 *
		 * @var string
		 **/
		const DAMAGE_LIGHT='light';
		/**
		 * Damage type for heal damage
		 *
		 * @var string
		 **/
		const DAMAGE_HEAL='heal';
		/**
		 * Bad grade
		 *
		 * @var int
		 **/
		const BAD_GRADE=0;
		/**
		 * Mediocre grade
		 *
		 * @var int
		 **/
		const MEDIOCRE_GRADE=0;
		/**
		 * Middle grade
		 *
		 * @var int
		 **/
		const MIDDLE_GRADE=2;
		/**
		 * Correct grade
		 *
		 * @var int
		 **/
		const CORRECT_GRADE=3;
		/**
		 * Good grade
		 *
		 * @var int
		 **/
		const GOOD_GRADE=4;
		/**
		 * Excellent grade
		 *
		 * @var int
		 **/
		const EXCELLENT_GRADE=5;
		/**
		 * Legendary grade
		 *
		 * @var int
		 **/
		const LEGENDARY_GRADE=6;
		/**
		 * Light weigth
		 *
		 * @var int
		 **/
		const WEIGTH_LIGHT=1;
		/**
		 * Heavy weigth
		 *
		 * @var int
		 **/
		const WEIGTH_HEAVY=2;

	/* Attributes */

		/**
		 * Id of the item
		 *
		 * @var int
		 **/
		protected $id;
		/**
		 * Id of the inventory
		 *
		 * @var int
		 **/
		protected $id_inventory;
		/**
		 * If the item can be equipped
		 *
		 * @var bool
		 **/
		protected $equipable;
		/**
		 * If the item is equipped
		 *
		 * @var bool
		 **/
		protected $is_equipped;
		/**
		 * If the item can be enchanted
		 *
		 * @var bool
		 **/
		protected $enchantable;
		/**
		 * If the item is enchanted
		 *
		 * @var bool
		 **/
		protected $is_enchanted;
		/**
		 * Type of the item
		 *
		 * @var string
		 **/
		protected $type;
		/**
		 * Id of the content for the name of the item
		 *
		 * @var int
		 **/
		protected $id_name;
		/**
		 * Id of the content for the description of the item
		 *
		 * @var int
		 **/
		protected $id_description;
		/**
		 * Part where the item is
		 *
		 * @var string
		 **/
		protected $part;
		/**
		 * Cost of the item in the part
		 *
		 * @var int
		 **/
		protected $part_cost;
		/**
		 * Cost of the item (in money)
		 *
		 * @var int
		 **/
		protected $cost;
		/**
		 * Damage of the item for attack item or protection value for protection item
		 *
		 * @var int
		 **/
		protected $damage;
		/**
		 * Damage type of the item for attack item or protection type for protection one
		 *
		 * @var string
		 **/
		protected $damage_type;
		/**
		 * Grade of the item
		 *
		 * @var int
		 **/
		protected $grade;
		/**
		 * Spell id associated
		 *
		 * @var int
		 **/
		protected $id_spell;
		/**
		 * Weigth of the armor
		 *
		 * @var int
		 **/
		protected $weigth;

	/* Method */

		/* Getter */

			/**
			 * id getter
			 *
			 * @return int
			 **/
			public function getId()
			{
				return $this->id;
			}
			/**
			 * id_inventory getter
			 *
			 * @return int
			 **/
			public function getId_inventory()
			{
				return $this->id_inventory;
			}
			/**
			 * equipable getter
			 *
			 * @return bool
			 **/
			public function getEquipable()
			{
				return $this->equipable;
			}
			/**
			 * is_equipped getter
			 *
			 * @return bool
			 **/
			public function getIs_equipped()
			{
				return $this->is_equipped;
			}
			/**
			 * enchantable getter
			 *
			 * @return bool
			 **/
			public function getEnchantable()
			{
				return $this->enchantable;
			}
			/**
			 * is_enchanted getter
			 *
			 * @return bool
			 **/
			public function getIs_enchanted()
			{
				return $this->is_enchanted;
			}
			/**
			 * type getter
			 *
			 * @return string
			 **/
			public function getType()
			{
				return $this->type;
			}
			/**
			 * id_name getter
			 *
			 * @return int
			 **/
			public function getId_name()
			{
				return $this->id_name;
			}
			/**
			 * id_description getter
			 *
			 * @return int
			 **/
			public function getId_description()
			{
				return $this->id_description;
			}
			/**
			 * part getter
			 *
			 * @return string
			 **/
			public function getPart()
			{
				return $this->part;
			}
			/**
			 * part_cost getter
			 *
			 * @return int
			 **/
			public function getPart_cost()
			{
				return $this->part_cost;
			}
			/**
			 * cost getter
			 *
			 * @return int
			 **/
			public function getCost()
			{
				return $this->cost;
			}
			/**
			 * damage getter
			 *
			 * @return int
			 **/
			public function getDamage()
			{
				return $this->damage;
			}
			/**
			 * damage_type getter
			 *
			 * @return string
			 **/
			public function getDamage_type()
			{
				return $this->damage_type;
			}
			/**
			 * grade getter
			 *
			 * @return int
			 **/
			public function getGrade()
			{
				return $this->grade;
			}
			/**
			 * id_spell getter
			 *
			 * @return int
			 **/
			public function getId_spell()
			{
				return $this->id_spell;
			}
			/**
			 * weigth getter
			 *
			 * @return int
			 **/
			public function getWeigth()
			{
				return $this->weigth;
			}

		/* Setter */

			/** id setter
			 *
			 * @param int $id Id of the item
			 *
			 * @return void
			 **/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/** id_inventory setter
			 *
			 * @param int $id_inventory Id of the inventory
			 *
			 * @return void
			 **/
			protected function setId_inventory($id_inventory)
			{
				$this->id_inventory=(int)$id_inventory;
			}
			/** equipable setter
			 *
			 * @param bool $equipable If the item can be equipped
			 *
			 * @return void
			 **/
			protected function setEquipable($equipable)
			{
				$this->equipable=(bool)$equipable;
			}
			/** is_equipped setter
			 *
			 * @param bool $is_equipped If the item is equipped
			 *
			 * @return void
			 **/
			protected function setIs_equipped($is_equipped)
			{
				$this->is_equipped=(bool)$is_equipped;
			}
			/** enchantable setter
			 *
			 * @param bool $enchantable If the item can be enchanted
			 *
			 * @return void
			 **/
			protected function setEnchantable($enchantable)
			{
				$this->enchantable=(bool)$enchantable;
			}
			/** is_enchanted setter
			 *
			 * @param bool $is_enchanted If the item is enchanted
			 *
			 * @return void
			 **/
			protected function setIs_enchanted($is_enchanted)
			{
				$this->is_enchanted=(bool)$is_enchanted;
			}
			/** type setter
			 *
			 * @param string $type Type of the item
			 *
			 * @return void
			 **/
			protected function setType($type)
			{
				$this->type=(string)$type;
			}
			/** id_name setter
			 *
			 * @param int $id_name Id of the content for the name
			 *
			 * @return void
			 **/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/** id_description setter
			 *
			 * @param int $id_description Id of the  content for the description
			 *
			 * @return void
			 **/
			protected function setId_description($id_description)
			{
				$this->id_description=(int)$id_description;
			}
			/** part setter
			 *
			 * @param string $part Part where the item is
			 *
			 * @return void
			 **/
			protected function setPart($part)
			{
				$this->part=(string)$part;
			}
			/** part_cost setter
			 *
			 * @param int $part_cost Cost of the item for this part
			 *
			 * @return void
			 **/
			protected function setPart_cost($part_cost)
			{
				$this->part_cost=(int)$part_cost;
			}
			/** cost setter
			 *
			 * @param int $cost Cost of the item
			 *
			 * @return void
			 **/
			protected function setCost($cost)
			{
				$this->cost=(int)$cost;
			}
			/** damage setter
			 *
			 * @param int $damage Damage if the item is a weapon, protection value if is a protection one
			 *
			 * @return void
			 **/
			protected function setDamage($damage)
			{
				$this->damage=(int)$damage;
			}
			/** damage_type setter
			 *
			 * @param string $damage_type Type of damage the item does or protect
			 *
			 * @return void
			 **/
			protected function setDamage_type($damage_type)
			{
				$this->damage_type=(string)$damage_type;
			}
			/** grade setter
			 *
			 * @param int $grade Grade of the item
			 *
			 * @return void
			 **/
			protected function setGrade($grade)
			{
				$this->grade=(int)$grade;
			}
			/** id_spell setter
			 *
			 * @param int $id_spell Id of the spell
			 *
			 * @return void
			 **/
			protected function setId_spell($id_spell)
			{
				$this->id_spells=(int)$id_spells;
			}
			/** weigth setter
			 *
			 * @param int $weigth Weigth of the armor
			 *
			 * @return void
			 **/
			protected function setWeigth($weigth)
			{
				$this->weigth=(int)$weigth;
			}

		/* Display */

			/**
			 * id display
			 *
			 * @return string
			 **/
			public function displayId()
			{
				return htmlspecialchars((string)$this->id);
			}
			/**
			 * id_inventory display
			 *
			 * @return string
			 **/
			public function displayId_inventory()
			{
				return htmlspecialchars((string)$this->id_inventory);
			}
			/**
			 * type display
			 *
			 * @return string
			 **/
			public function displaytype()
			{
				return htmlspecialchars((string)$this->type);
			}
			/**
			 * id_name display
			 *
			 * @return string
			 **/
			public function displayId_name()
			{
				return htmlspecialchars((string)$this->id_name);
			}
			/**
			 * id_description display
			 *
			 * @return string
			 **/
			public function displayId_description()
			{
				return htmlspecialchars((string)$this->id_description);
			}
			/**
			 * part display
			 *
			 * @return string
			 **/
			public function displayPart()
			{
				return htmlspecialchars((string)$this->part);
			}
			/**
			 * part_cost display
			 *
			 * @return string
			 **/
			public function displayPart_cost()
			{
				return htmlspecialchars((string)$this->part_cost);
			}
			/**
			 * cost display
			 *
			 * @return string
			 **/
			public function displayCost()
			{
				return htmlspecialchars((string)$this->cost);
			}
			/**
			 * damage display
			 *
			 * @return string
			 **/
			public function displayDamage()
			{
				return htmlspecialchars((string)$this->damage);
			}
			/**
			 * damage_type display
			 *
			 * @return string
			 **/
			public function displayDamage_type()
			{
				return htmlspecialchars((string)$this->damage_type);
			}
			/**
			 * grade display
			 *
			 * @return string
			 **/
			public function displayGrade()
			{
				return htmlspecialchars((string)$this->grade);
			}
			/**
			 * id_spell display
			 *
			 * @return string
			 **/
			public function displayId_spell()
			{
				return htmlspecialchars((string)$this->id_spell);
			}
			/**
			 * weigth display
			 *
			 * @return string
			 **/
			public function displayWeigth()
			{
				return htmlspecialchars((string)$this->weigth);
			}

		/**
		 * Display the item name
		 *
		 * @var string
		 **/
		public function displayName()
		{
			global $Visitor;
			$Content=new \content\Content(array(
				'id_content' => $this->id_name;
			));
			$Content->retrieveLang($Visitor->getConfiguration('lang'));
			return $Content->display();
		}
		/**
		 * Display the item description
		 *
		 * @var string
		 **/
		public function displayDescription()
		{
			global $Visitor;
			$Content=new \content\Content(array(
				'id_content' => $this->id_description,
			));
			$Content->retrieveLang($Visitor->getConfiguration('lang'));
			return $Content->display();
		}
		/**
		 * \character\Item display
		 *
		 * @return string
		 **/
		public function display()
		{
			return $this->displayName().' '.$this->displayDescription();
		}
		/**
		 * Unequip this item
		 *
		 * @return void
		 **/
		public function unEquip()
		{
			if ($this->is_equipped)
			{
				$this->setIs_equipped(false);
			}
		}
		/**
		 * Equip this item (true if success, else false)
		 *
		 * @return bool
		 **/
		public function equip()
		{
			if ($this->equipable)
			{
				if (!$this->is_equipped)
				{
					$this->setIs_equipped(true);
					return true;
				}
			}
			return false;
		}
		/**
		 * Get the CAC damage
		 *
		 * @return int
		 **/
		public function getCACDamage()
		{
			$damage=0;
			if ($this->is_equipped)
			{
				if ($this->is_enchanted)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$damage+=$Enchant->getCACDamage();
					}
				}
				if ($this->type===$this::TYPE_WEAPON)
				{
					if ($this->damage_type===$this::DAMAGE_CAC)
					{
						$damage+=$this->damage;
					}
				}
			}
			return $damage;
		}
		/**
		 * Get the DIS damage
		 *
		 * @return int
		 **/
		public function getDISDamage()
		{
			$damage=0;
			if ($this->is_equipped)
			{
				if ($this->is_enchanted)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$damage+=$Enchant->getDISDamage();
					}
				}
				if ($this->type===$this::TYPE_WEAPON)
				{
					if ($this->damage_type===$this::DAMAGE_DIS)
					{
						$damage+=$this->damage;
					}
				}
			}
		}
		/**
		 * Get the MAG damage
		 *
		 * @param string $type Magical type
		 *
		 * @return int
		 **/
		public function getMAGDamage($type)
		{
			$damage=0;
			if ($this->is_equipped)
			{
				if ($this->is_enchanted)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$damage+=$Enchant->getMAGDamage($type);
					}
				}
				if ($this->type===$this::TYPE_WEAPON)
				{
					if ($this->damage_type===$this::DAMAGE_MAGICAL || $this->damage_type===$type)
					{
						$damage+=$this->damage;
					}
				}
			}
		}
		/**
		 * Get CAC effects for enemy
		 *
		 * @return array
		 **/
		public function getCACEffects()
		{
			$effects=[];
			if ($this->is_equipped)
			{
				if ($this->is_enchanted)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$effects=array_merge($effects, $Enchant->getCACEffects());
					}
				}
			}
			return $effects;
		}
		/**
		 * Get DIS effects for enemy
		 *
		 * @return array
		 **/
		public function getDISEffects()
		{
			$effects=[];
			if ($this->is_equipped)
			{
				if ($this->is_enchanted)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$effects=array_merge($effects, $Enchant->getDISEffects());
					}
				}
			}
			return $effects;
		}
		/**
		 * Get MAG effects for enemy
		 *
		 * @param string $type Magical type
		 *
		 * @return array
		 **/
		public function getMagEffects($type)
		{
			$effects=[];
			if ($this->is_equipped)
			{
				if ($this->is_equipped)
				{
					for ($this->getEnchants() as $Enchant)
					{
						$effects=array_merge($effects, $Enchant->getMAGEffects($type));
					}
					if ($this->type===$this::TYPE_WEAPON)
					{
						if ($this->damage_type===$type)
						{
							$roll=\jdr_utils\Dice::roll(1, 100);
							if ($roll>80)
							{
								switch ($type)
								{
									case $this::DAMAGE_FIRE:
										$Effect=new \character\Effect(array(
											'type'  => \character\Effect::TYPE_ON_FIRE,
											'turns' => \jdr_utils\Dice::roll(2, 2),
											'value' => \jdr_utils\Dice::roll(2, 2);
										));
										$Effect->create();
										$effects[]=$Effect;
										break;
									case $this::DAMAGE_ICE:
										$Effect=new \character\Effect(array(
											'type'  => \character\Effect::TYPE_ON_ICE,
											'turns' => \jdr_utils\Dice::roll(2, 3),
											'value' => \jdr_utils\Dice::rolle(1, 2),
										));
										$Effect->create();
										$effects[]=$Effect;
										break;
									case $this::DAMAGE_EARTH:
										$Effect=new \character\Effect(array(
											'type'  => \character\Effect::TYPE_STUN,
											'turns' => \jdr_utils\Dice::roll(2, 2),
											'value' => \jdr_utils\Dice::roll(10, 5),
										));
										$Effect->create();
										$effects[]=$Effect;
										break;
									case $this::DAMAGE_SHADOW:
										$Effect=new \character\Effect(array(
											'type'  => \character\Effect::TYPE_POISON,
											'turns' => \jdr_utils\Dice::roll(2, 3),
											'value' => \jdr_utils\Dice::roll(2, 2),
										));
										$Effect->create();
										$effects[]=$Effect;
										break;
									default:
										break;
								}
							}
						}
					}
				}
			}
			return $effects;
		}
		/**
		 * Get the enchants of this item if they exist
		 *
		 * @return array
		 **/
		public function getEnchants()
		{
			$Enchants=array();
			if ($this->is_enchanted)
			{
				$EnchantManager=new \character\EnchantManager(\core\DBFactory::MysqlConnection());
				$Enchants=$EnchantManager->retrieveBy(array(
					'id_item' => $this->id,
				));
			}
			return $Enchants;
		}
}

?>
