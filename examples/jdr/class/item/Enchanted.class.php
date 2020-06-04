<?php

namespace item;

/**
 * Item which can be enchanted
 *
 * @author gugus2000
 **/
class Enchanted extends \item\Item
{
	/* attribute */

		/**
		* Enchantment
		* 
		* @var \item\Enchant
		*/
		protected $enchant;

	/* method */

		/* getter */

			/**
			* enchant getter
			* 
			* @return \item\Enchant
			*/
			public function getEnchant()
			{
				return $this->enchant;
			}

		/* setter */

			/**
			* enchant setter
			*
			* @param \item\Enchant enchant Enchantment
			* 
			* @return void
			*/
			protected function setEnchant($enchant)
			{
				$this->enchant=$enchant;
			}

		/* display */

			/**
			* enchant display
			* 
			* @return string
			*/
			public function displayEnchant()
			{
				return $this->enchant->display();
			}

		/**
		* Display an enchanted item
		* 
		* @return string
		*/
		public function display()
		{
			if ($this->getEnchant()===null)
			{
				return parent::display();
			}
			$this->calcValue();
			return $this->displayName().' '.$this->displayEnchant();
		}
		public function calcValue()
		{
			if ($this->getEnchant())
			{
				$this->setValue($this->getValue()+$this->getEnchant()->getValue());
			}
		}
} // END class Enchanted extends \item\Item

?>