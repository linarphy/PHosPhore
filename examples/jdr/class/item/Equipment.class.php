<?php

namespace item;

/**
 * Equipment of JDG
 *
 * @author gugus2000
 **/
class Equipment extends \item\Enchanted
{
	/* constant */

		/**
		* Type of equipment
		*
		* @var int
		*/
		const TYPE=1;
		/**
		* Available slot
		*
		* @var array
		*/
		const AV_SLOt=array('1H', 'head', 'body', 'hands', 'legs', 'feet');

	/* attribute */

		/**
		* slot for the equipment
		* 
		* @var string
		*/
		protected $slot;
		/**
		* weight of the equipment
		* 
		* @var bool
		*/
		protected $weight;
		/**
		* armor of the equipment
		* 
		* @var int
		*/
		protected $armor;

	/* method */

		/* getter */

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
			* weight getter
			* 
			* @return bool
			*/
			public function getWeight()
			{
				return $this->weight;
			}
			/**
			* armor getter
			* 
			* @return int
			*/
			public function getArmor()
			{
				return $this->armor;
			}

		/* setter */

			/**
			* slot setter
			*
			* @param string slot Slot for the equipment
			* 
			* @return void
			*/
			protected function setSlot($slot)
			{
				if (in_array($slot, $this::AV_SLOt))
				{
					$this->slot=(string)$slot;
				}
				else
				{
					throw new \Exception($GLOBALS['lang']['class_item_equipment_error_slot']);
				}
			}
			/**
			* weight setter
			*
			* @param bool weight Weight of the equipment
			* 
			* @return void
			*/
			protected function setWeight($weight)
			{
				$this->weight=(bool)$weight;
			}
			/**
			* armor setter
			*
			* @param int armor Armor of the equipment
			* 
			* @return void
			*/
			protected function setArmor($armor)
			{
				$this->armor=(int)$armor;
			}

		/* display */

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
			* weight display
			* 
			* @return string
			*/
			public function displayWeight()
			{
				return htmlspecialchars((string)$this->weight);
			}
			/**
			* armor display
			* 
			* @return string
			*/
			public function displayArmor()
			{
				return htmlspecialchars((string)$this->armor);
			}
} // END class Equipment extends \item\Enchanted

?>