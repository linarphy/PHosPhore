<?php

namespace item;

/**
 * Weapon of JDG
 *
 * @author gugus2000
 **/
class Weapon extends \item\Enchanted
{
	/* constant */

		/**
		* Type of the Weapon
		*
		* @var int
		*/
		const TYPE=2;
		/**
		* Available attack_type of a weapon
		*
		* @var array
		*/
		const AV_ATK_TYPE=array('HTH', 'D', 'M');
		/**
		* Available slot of a weapon
		*
		* @var array
		*/
		const AV_SLOT=array('1H', '2H');

	/* attribute */

		/**
		* attack type of the weapon
		* 
		* @var string
		*/
		protected $attack_type;
		/**
		* Slot of the weapon
		* 
		* @var string
		*/
		protected $slot;
		/**
		* Damage of the weapon
		* 
		* @var int
		*/
		protected $damage;

	/* method */

		/* getter */

			/**
			* attack_type getter
			* 
			* @return string
			*/
			public function getAttack_type()
			{
				return $this->attack_type;
			}
			/**
			* slot getter
			* 
			* @return string
			*/
			public function getSlot()
			{
				return $this->slot;
			}
			/**
			* damage getter
			* 
			* @return int
			*/
			public function getDamage()
			{
				return $this->damage;
			}

		/* setter */

			/**
			* attack_type setter
			*
			* @param string attack_type Attack type of the weapon
			* 
			* @return void
			*/
			protected function setAttack_type($attack_type)
			{
				if (in_array($attack_type, $this::AV_ATK_TYPE))
				{
					$this->attack_type=(string)$attack_type;
				}
				else
				{
					throw new \Exception($GLOBALS['lang']['class_item_weapon_error_unknown_attack_type']);
				}
			}
			/**
			* slot setter
			*
			* @param string slot Slot of the weapon
			* 
			* @return void
			*/
			protected function setSlot($slot)
			{
				if (in_array($slot, $this::AV_SLOT))
				{
					$this->slot=(string)$slot;
				}
				else
				{
					throw new \Exception($GLOBALS['lang']['class_item_weapon_error_unknown_slot']);
				}
			}
			/**
			* damage setter
			*
			* @param int damage Damage of the weapon
			* 
			* @return void
			*/
			protected function setDamage($damage)
			{
				$this->damage=(int)$damage;
			}

		/* display */

			/**
			* attack_type display
			* 
			* @return string
			*/
			public function displayAttack_type()
			{
				return htmlspecialchars((string)$this->attack_type);
			}
			/**
			* slot display
			* 
			* @return string
			*/
			public function displaySlot()
			{
				return htmlspecialchars((string)$this->slot);
			}
			/**
			* damage display
			* 
			* @return string
			*/
			public function displayDamage()
			{
				return htmlspecialchars((string)$this->damage);
			}
} // END class Weapon extends \item\Enchanted

?>