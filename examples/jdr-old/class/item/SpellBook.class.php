<?php

namespace item;

/**
 * A spell book
 *
 * @author gugus2000
 **/
class SpellBook extends \item\Item
{
	/* constant */

		/**
		* TYPE of an Jewelry
		*
		* @var int
		*/
		const TYPE=5;
		/**
		* id_element neutral
		*
		* @var int
		*/
		const ID_NEUT=292;
		/**
		* id_element fire
		*
		* @var int
		*/
		const ID_FIRE=293;
		/**
		* id_element ice
		*
		* @var int
		*/
		const ID_ICE=294;
		/**
		* id_element earth
		*
		* @var int
		*/
		const ID_EART=295;
		/**
		* id_element water
		*
		* @var int
		*/
		const ID_WATE=296;
		/**
		* id_element magma
		*
		* @var int
		*/
		const ID_MAGM=297;
		/**
		* id_element shadow
		*
		* @var int
		*/
		const ID_SHAD=298;
		/**
		* id_element light
		*
		* @var int
		*/
		const ID_LIGH=299;
		/**
		* id_element heal
		*
		* @var int
		*/
		const ID_HEAL=300;

	/* attribute */

		/**
		* Element of the spell
		* 
		* @var int
		*/
		protected $id_element;
		/**
		* Damage of the spell
		* 
		* @var int
		*/
		protected $damage;
		/**
		* Mana cost of the spell
		* 
		* @var int
		*/
		protected $cost;
		/**
		* Base_range maximum between the caster and the the central point of the spell (meter)
		* 
		* @var int
		*/
		protected $base_range;
		/**
		* Area of the spell (radius in meter)
		* 
		* @var int
		*/
		protected $area;

	/* method */

		/* getter */

			/**
			* id_element getter
			* 
			* @return int
			*/
			public function getId_element()
			{
				return $this->id_element;
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
			/**
			* cost getter
			* 
			* @return int
			*/
			public function getCost()
			{
				return $this->cost;
			}
			/**
			* base_range getter
			* 
			* @return int
			*/
			public function getBase_range()
			{
				return $this->base_range;
			}
			/**
			* area getter
			* 
			* @return int
			*/
			public function getArea()
			{
				return $this->area;
			}

		/* setter */

			/**
			* id_element setter
			*
			* @param int id_element Element of the spell
			* 
			* @return void
			*/
			protected function setId_element($id_element)
			{
				$this->id_element=(int)$id_element;
			}
			/**
			* damage setter
			*
			* @param int damage Damage of the spell
			* 
			* @return void
			*/
			protected function setDamage($damage)
			{
				$this->damage=(int)$damage;
			}
			/**
			* cost setter
			*
			* @param int cost Mana cost of the spell
			* 
			* @return void
			*/
			protected function setCost($cost)
			{
				$this->cost=(int)$cost;
			}
			/**
			* base_range setter
			*
			* @param int base_range Base_range maximum between the caster and the the central point of the spell (meter)
			* 
			* @return void
			*/
			protected function setBase_range($base_range)
			{
				$this->base_range=(int)$base_range;
			}
			/**
			* area setter
			*
			* @param int area Area of the spell (radius in meter)
			* 
			* @return void
			*/
			protected function setArea($area)
			{
				$this->area=(int)$area;
			}

		/* display */

			/**
			* id_element display
			* 
			* @return string
			*/
			public function displayId_element()
			{
				return htmlspecialchars((string)$this->id_element);
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
			/**
			* cost display
			* 
			* @return string
			*/
			public function displayCost()
			{
				return htmlspecialchars((string)$this->cost);
			}
			/**
			* base_range display
			* 
			* @return string
			*/
			public function displayBase_range()
			{
				return htmlspecialchars((string)$this->base_range);
			}
			/**
			* area display
			* 
			* @return string
			*/
			public function displayArea()
			{
				return htmlspecialchars((string)$this->area);
			}

		/**
		* Display the element
		* 
		* @return string
		*/
		public function displayElement()
		{
			global $Visitor;
			$Element=new \content\Content(array(
				'id_content' => $this->getId_element(),
			));
			$Element->retrieveLang($Visitor->getConfiguration('lang'));
			return $Element->display();
		}
		/**
		* Display a spell book
		* 
		* @return string
		*/
		public function display()
		{
			return $GLOBALS['lang']['class_item_spellbook_suffix'].$this->displayName().' ('.$this->displayElement().')';
		}
} // END class SpellBook extends \item\Item

?>