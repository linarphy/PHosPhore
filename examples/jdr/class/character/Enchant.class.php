<?php

namespace character;

/**
 * An item enchantment
 *
 * @package jdr
 * @author gugus2000
 **/
class Enchant extends \core\Managed
{
	/* Constant */

		/**
		 * Bleeding type
		 *
		 * @var string
		 **/
		const TYPE_BLEEDING='bleeding';
		/**
		 * On fire type
		 *
		 * @var string
		 **/
		const TYPE_ON_FIRE='firing';
		/**
		 * On ice type
		 *
		 * @var sting
		 **/
		const TYPE_ON_ICE='icing';
		/**
		 * Money type
		 *
		 * @var string
		 **/
		const TYPE_MONEY='money';
		/**
		 * Stun type
		 *
		 * @var string
		 **/
		const TYPE_STUN='stun';
		/**
		 * Poison type
		 *
		 * @var string
		 **/
		const TYPE_POISON='poison';
		/**
		 * Critical type
		 *
		 * @var string
		 **/
		const TYPE_CRITICAL='critical';
		/**
		 * Fire resistance type
		 *
		 * @var string
		 **/
		const TYPE_FIRE_RESISTANCE='fire_resistance';
		/**
		 * Ice resistance type
		 *
		 * @var string
		 **/
		const TYPE_ICE_RESISTANCE='ice_resistance';
		/**
		 * Earth resistance
		 *
		 * @var string
		 **/
		const TYPE_EARTH_RESISTANCE='earth_resistance';
		/**
		 * Water resistance
		 *
		 * @var string
		 **/
		const TYPE_WATER_RESISTANCE='water_resistance';
		/**
		 * Lava resistance
		 *
		 * @var string
		 **/
		const TYPE_LAVA_RESISTANCE='lava_resistance';
		/**
		 * Shadow resistance
		 *
		 * @var string
		 **/
		const TYPE_SHADOW_RESISTANCE='shadow_resistance';
		/**
		 * Light resistance
		 *
		 * @var string
		 **/
		const TYPE_LIGHT_RESISTANCE='light_resistance';
		/**
		 * Poison resistance
		 *
		 * @var string
		 **/
		const TYPE_POISON_RESISTANCE='poison_resistance';
		/**
		 * Strength type
		 *
		 * @var string
		 **/
		const TYPE_STRENGTH='strength';
		/**
		 * Dexerity type
		 *
		 * @var string
		 **/
		const TYPE_DEXERITY='dexerity';
		/**
		 * Constitution type
		 *
		 * @var string
		 **/
		const TYPE_CONSTITUTION='constitution';
		/**
		 * Intelligence type
		 *
		 * @var string
		 **/
		const TYPE_INTELLIGENCE='intelligence';
		/**
		 * Charisma type
		 *
		 * @var string
		 **/
		const TYPE_CHARISMA='charisma';
		/**
		 * Agility type
		 *
		 * @var string
		 **/
		const TYPE_AGILITY='agility';
		/**
		 * Magical type
		 *
		 * @var string
		 **/
		const TYPE_MAGICAL='magical';
		/**
		 * Acuity type
		 *
		 * @var string
		 **/
		const TYPE_ACUITY='acuity';
		/**
		 * Speed type
		 *
		 * @var string
		 **/
		const TYPE_SPEED='speed';
		/**
		 * Health type
		 *
		 * @var string
		 **/
		const TYPE_HEALTH='health';
		/**
		 * Mana type
		 *
		 * @var string
		 **/
		const TYPE_MANA='mana';
		/**
		 * Of the sea type
		 *
		 * @var string
		 **/
		const TYPE_OF_THE_SEA='of_the_sea';
		/**
		 * Fire type
		 *
		 * @var string
		 **/
		const TYPE_FIRE='fire';
		/**
		 * Ice type
		 *
		 * @var string
		 **/
		const TYPE_ICE='ice';
		/**
		 * Earth type
		 *
		 * @var string
		 **/
		const TYPE_EARTH='earth';
		/**
		 * Water type
		 *
		 * @var string
		 **/
		const TYPE_WATER='water';
		/**
		 * Lava type
		 *
		 * @var string
		 **/
		const TYPE_LAVA='lava';
		/**
		 * Shadow type
		 *
		 * @var string
		 **/
		const TYPE_SHADOW='shadow';
		/**
		 * Light type
		 *
		 * @var string
		 **/
		const TYPE_LIGHT='light';
		/**
		 * Heal type
		 *
		 * @var string
		 **/
		const TYPE_HEAL='heal';
		/**
		 * Seller type
		 *
		 * @var string
		 **/
		const TYPE_SELLER='seller';
		/**
		 * Health regen type
		 *
		 * @var string
		 **/
		const TYPE_HEALING='healing';
		/**
		 * Mana regen type
		 *
		 * @var string
		 **/
		const TYPE_MANING='maning';
		/**
		 * Focus type
		 *
		 * @var string
		 **/
		const TYPE_FOCUS='focus';

	/* Attribute */

		/**
		 * Id of the enchant
		 *
		 * @var int
		 **/
		protected $id;
		/**
		 * Id of the enchanted item
		 *
		 * @var int
		 **/
		protected $id_item;
		/**
		 * Type of effect the enchantment has
		 *
		 * @var string
		 **/
		protected $type_effect;
		/**
		 * Id of the content of the name of the enchantment
		 *
		 * @var int
		 **/
		protected $id_name;
		/**
		 * Id of the content of the description of the enchantment
		 *
		 * @var int
		 **/
		protected $id_description;

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
			 * id_item getter
			 *
			 * @return int
			 **/
			public function getId_item()
			{
				return $this->id_item;
			}
			/**
			 * type_effect getter
			 *
			 * @return string
			 **/
			public function getType_effect()
			{
				return $this->type_effect;
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

		/* Setter */

			/**
			 * id setter
			 *
			 * @param int $id Id of the enchantment
			 *
			 * @return void
			 **/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			 * id_item setter
			 *
			 * @param int $id_item Id of the enchanted item
			 *
			 * @return void
			 **/
			protected function setId_item($id_item)
			{
				$this->id_item=(int)$id_item;
			}
			}
			/**
			 * type_effect setter
			 *
			 * @param string $type_effect Type of the effect of the enchantment
			 *
			 * @return void
			 **/
			protected function setType_effect($type_effect)
			{
				$this->type_effect=(string)$type_effect;
			}
			/**
			 * id_name setter
			 *
			 * @param int $id_name Id of the name of the enchantment
			 *
			 * @return void
			 **/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/**
			 * id_description setter
			 *
			 * @param int $id_description Id of the description of the enchantment
			 *
			 * @return void
			 **/
			protected function setId_description($id_description)
			{
				$this->id_description=(int)$id_description;
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
			 * id_item display
			 *
			 * @return string
			 **/
			public function displayId_item()
			{
				return htmlspecialchars((string)$this->id_item);
			}
			/**
			 * type_effect display
			 *
			 * @return string
			 **/
			public function displayType_effect()
			{
				return htmlspecialchars((string)$this->type_effect);
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
		 * Display the enchantment name
		 *
		 * @return string
		 **/
		public function displayName()
		{
			global $Visitor;
			$Content=new \content\Content(array(
				'id_content' => $this->id_name,
			));
			$Content->retrieveLang($Visitor->getConfiguration('lang'));
			return $Content->display();
		}
		/**
		 * Display the enchantment description
		 *
		 * @return string
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
		 * Display the Enchantment
		 *
		 * @return string
		 **/
		public function display()
		{
			return $this->displayName().' '.$this->displayDescription();
		}
		/**
		 * Retrieve the modifiers for this enchantment
		 *
		 * @return array
		 **/
		public function retrieveModifiers()
		{
			$ModifierManager=new \character\ModifierManager(\core\DBFactory::MysqlConnection());
			return $ModifierManager->getBy(array(
				'id_enchantment' => $this->id,
			));
		}
		/**
		 * Get the CAC damage
		 *
		 * @return int
		 **/
		public function getCACDamage()
		{
			switch ($this->type_effect)
			{
				default:
					return 0;
			}
		}
		/**
		 * Get the DIS damage
		 *
		 * @return int
		 **/
		public function getDISDamage()
		{
			switch ($this->type_effect)
			{
				default:
					return 0;
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
			switch ($this->type_effect)
			{
				case $this::TYPE_FIRE:
					if ($type==\character\Item::DAMAGE_FIRE)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_ICE:
					if ($type==\character\Item::DAMAGE_ICE)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_EARTH:
					if ($type==\character\Item::DAMAGE_EARTH)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_LAVA:
					if ($type==\character\Item::DAMAGE_LAVA)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_SHADOW:
					if ($type==\character\Item::DAMAGE_SHADOW)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_LIGHT:
					if ($type==\character\Item::DAMAGE_LIGHT)
					{
						$modifiers=$this->retrieveModifiers();
						return $modifiers[0];
					}
				case $this::TYPE_HEAL:
					if ($type==\character\Item::DAMAGE_HEAL)
					{
						$modifiers=$this->retrieveModifiers();
						return -$modifiers[0];
					}
				default:
					return 0;
			}
		}
		/**
		 * Get effects for enemy
		 *
		 * @return array
		 **/
		public function getEnemyEffects()
		{
			$effects=[];
			switch ($this->type_effect)
			{
				case $this::TYPE_BLEEDING:
					$modifiers=$this->retrieveModifiers();
					$roll=\jdr_utils\Dice::roll(1, 100);
					if (\jdr_utils\Roll::ifPercent($modifiers[2]))
					{
						$Item=new \character\Item(array(
							'id' => $this->id_item,
						));
						$Item->retrieve();
						$Effect=new \character\Effect(array(
							'type'  => \character\Effect::TYPE_BLEEDING,
							'turns' => \jdr_utils\Dice::roll(2, $modifiers[0]),
							'value' => $Item->getDamage()/$modifiers[1],
						));
						$Effect->create();
						$effects[]$Effect;
					}
					break;
				case $this::TYPE_ON_FIRE::
					$modifiers=$this->retrieveModifiers();
					if (\jdr_utils\Roll::ifPercent($modifiers[2]))
					{
						$Effect=new \character\Effect(array(
							'type'  => \character\Effect::TYPE_ON_FIRE,
							'turns' => \jdr_utils\Dice::roll(2, $modifiers[0]),
							'value' => \jdr_utils\Dice::roll(1, $modifiers[1]),
						));
						$Effect->create();
						$effects[]$Effect;
					}
					break;
				case $this::TYPE_ON_ICE:
					$modifiers=$this->retrieveModifiers();
					if (\jdr_utils\Roll::ifPercent($modifiers[2]))
					{
						$Effect=new \character\Effect(array(
							'type'  => \character\Effect::TYPE_ON_ICE,
							'turns' => \jdr_utils\Dice::roll(2, $modifiers[0]),
							'value' => \jdr_utils\Dice::roll(1, $modifiers[1]),
						));
						$Effect->create();
						$effects[]$Effect;
					}
					break;
				case $this::TYPE_STUN:
					$modifiers=$this->retrieveModifiers();
					if (\jdr_utils\Roll::ifPercent($modifiers[1]))
					{
						$Effect=new \character\Effect(array(
							'type'  => \character\Effect::TYPE_STUN,
							'turns' => \jdr_utils\Dice::roll(2, $modifiers[0]),
						));
						$Effect->create();
						$effects[]$Effect;
					}
					break;
				case $this::TYPE_POISON:
					$modifiers=$this->retrieveModifiers();
					if (\jdr_utils\Dice::ifPercent($modifiers[2]))
					{
						$Effect=new \character\Effect(array(
							'type' => \character\Effect::TYPE_POISON,
							'turns' => \jdr_utils\Dice::roll(2, $modifiers[0]),
							'value' => \jdr_utils\Dice::roll(1, $modifiers[1]),
						));
						$Effect->create();
						$effects[]$Effect;
					}
					break;
			}
			return $effects;
		}
		/**
		 * Get CAC effects for enemy
		 *
		 * @return array
		 **/
		public function getCACEffects()
		{
			$effects=$this->getEnemyEffects();
			return $effects;
		}
		/**
		 * Get DIS effects for enemy
		 *
		 * @return array
		 **/
		public function getDISEffects()
		{
			$effects=$this->getEnemyEffects();
			return $effects;
		}
		/**
		 * Get MAG effects for enemy
		 *
		 * @return array
		 **/
		public function getMAGEffects()
		{
			$effects=$this->getEnemyEffects();
			return $effects;
		}
}

?>
