<?php

namespace item\enchant;

/**
 * A stored Modifier which has all his value static
 *
 * @author gugus2000
 **/
class StoredModifier extends \core\Managed
{
	/* attribute */

		/**
		* Id of the stored enchantment
		* 
		* @var int
		*/
		protected $id_enchant;
		/**
		* Replacer of the stored modifier
		* 
		* @var int
		*/
		protected $replacer;
		/**
		* Upgrade of the stored modifier
		* 
		* @var int
		*/
		protected $upgrade;

	/* method */

		/* getter */

			/**
			* id_enchant getter
			* 
			* @return int
			*/
			public function getId_enchant()
			{
				return $this->id_enchant;
			}
			/**
			* recplacer getter
			* 
			* @return int
			*/
			public function getReplacer()
			{
				return $this->recplacer;
			}
			/**
			* upgrade getter
			* 
			* @return int
			*/
			public function getUpgrade()
			{
				return $this->upgrade;
			}

		/* setter */

			/**
			* id_enchant setter
			*
			* @param int id_enchant Id of the stored enchantment
			* 
			* @return void
			*/
			protected function setId_enchant($id_enchant)
			{
				$this->id_enchant=(int)$id_enchant;
			}
			/**
			* recplacer setter
			*
			* @param int recplacer Replacer of the stored modifier
			* 
			* @return void
			*/
			protected function setReplacer($recplacer)
			{
				$this->recplacer=(int)$recplacer;
			}
			/**
			* upgrade setter
			*
			* @param int upgrade Upgrade of the stored moddifier
			* 
			* @return void
			*/
			protected function setUpgrade($upgrade)
			{
				$this->upgrade=(int)$upgrade;
			}

		/* display */

			/**
			* id_enchant display
			* 
			* @return string
			*/
			public function displayId_enchant()
			{
				return htmlspecialchars((string)$this->id_enchant);
			}
			/**
			* replacer display
			* 
			* @return string
			*/
			public function displayReplacer()
			{
				return htmlspecialchars((string)$this->replacer);
			}
			/**
			* upgrade display
			* 
			* @return string
			*/
			public function displayUpgrade()
			{
				return htmlspecialchars((string)$this->upgrade);
			}
} // END class StoredModifier extends \core\Managed

?>