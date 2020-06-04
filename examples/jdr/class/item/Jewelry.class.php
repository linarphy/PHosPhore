<?php

namespace item;

/**
 * Jewelry of JDG
 *
 * @author gugus2000
 **/
class Jewelry extends \item\Enchanted
{
	/* constant */

		/**
		* TYPE of a Jewelry
		*
		* @var int
		*/
		const TYPE=3;
		/**
		* List of available slot for jewelry
		*
		* @var array
		*/
		const AV_SLOT=array('ring', 'necklace');

	/* attribute */

		/**
		* Slot of the jewelry
		* 
		* @var string
		*/
		protected $slot;

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

		/* setter */

			/**
			* slot setter
			*
			* @param string slot Slot of the jewelry
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
					throw new \Exception($GLOBALS['lang']['class_item_jewelry_error_unknown_slot']);
				}
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
} // END class Jewelry extends \item\Enchanted

?>