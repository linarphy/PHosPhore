<?php

namespace item\enchant;

/**
 * Modifier for an enchantment
 *
 * @author gugus2000
 **/
class Modifier extends \core\Managed
{
	/* attribute */

		/**
		* Id of the enchantment
		* 
		* @var int
		*/
		protected $id_enchant;
		/**
		* Indicate where to use this modifier
		* 
		* @var int
		*/
		protected $replacer;
		/**
		* Base value of the modifier
		* 
		* @var int
		*/
		protected $base;
		/**
		* Maximum upgrade of this modifier
		* 
		* @var int
		*/
		protected $max;
		/**
		* Value per upgrade
		* 
		* @var int
		*/
		protected $value;
		/**
		* upgrade of this modifier
		* 
		* @var int
		*/
		protected $upgrade;
		/**
		* Luck (for defining weight probability to generate number of upgrade)
		* 
		* @var float
		*/
		protected $luck;
		/**
		* type of the enchantment
		* 
		* @var int
		*/
		protected $type;

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
			* replacer getter
			* 
			* @return int
			*/
			public function getReplacer()
			{
				return $this->replacer;
			}
			/**
			* base getter
			* 
			* @return int
			*/
			public function getBase()
			{
				return $this->base;
			}
			/**
			* max getter
			* 
			* @return int
			*/
			public function getMax()
			{
				return $this->max;
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
			* upgrade getter
			* 
			* @return int
			*/
			public function getUpgrade()
			{
				return $this->upgrade;
			}
			/**
			* luck getter
			* 
			* @return float
			*/
			public function getLuck()
			{
				return $this->luck;
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

		/* setter */

			/**
			* id_enchant setter
			*
			* @param int id_enchant Id of the enchantment
			* 
			* @return void
			*/
			protected function setId_enchant($id_enchant)
			{
				$this->id_enchant=(int)$id_enchant;
			}
			/**
			* replacer setter
			*
			* @param int replacer Indicate where to use this modifier
			* 
			* @return void
			*/
			protected function setReplacer($replacer)
			{
				$this->replacer=(int)$replacer;
			}
			/**
			* base setter
			*
			* @param int base Base value of the modifier
			* 
			* @return void
			*/
			protected function setBase($base)
			{
				$this->base=(int)$base;
			}
			/**
			* max setter
			*
			* @param int max Maximum upgrade of this modifier
			* 
			* @return void
			*/
			protected function setMax($max)
			{
				$this->max=(int)$max;
			}
			/**
			* value setter
			*
			* @param int value Value per upgrade
			* 
			* @return void
			*/
			protected function setValue($value)
			{
				$this->value=(int)$value;
			}
			/**
			* upgrade setter
			*
			* @param int upgrade Upgrade of this modifier
			* 
			* @return void
			*/
			protected function setUpgrade($upgrade)
			{
				$this->upgrade=(int)$upgrade;
			}
			/**
			* luck setter
			*
			* @param float luck Luck (for defining weight probability to generate number of upgrade)
			* 
			* @return void
			*/
			protected function setLuck($luck)
			{
				$this->luck=(float)$luck;
			}
			/**
			* type setter
			*
			* @param int type type of the enchantment
			* 
			* @return void
			*/
			protected function setType($type)
			{
				$this->type=(int)$type;
			}

		/* disp */

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
			* base display
			* 
			* @return string
			*/
			public function displayBase()
			{
				return htmlspecialchars((string)$this->base);
			}
			/**
			* max display
			* 
			* @return string
			*/
			public function displayMax()
			{
				return htmlspecialchars((string)$this->max);
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
			* upgrade display
			* 
			* @return string
			*/
			public function displayUpgrade()
			{
				return htmlspecialchars((string)$this->upgrade);
			}
			/**
			* luck display
			* 
			* @return string
			*/
			public function displayLuck()
			{
				return htmlspecialchars((string)$this->luck);
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
		* Store this modifier
		*
		* @param int id Id of the stored enchantment
		* 
		* @return item\enchant\StoredModifier
		*/
		public function store($id)
		{
			$StoredModifier=new \item\enchant\StoredModifier(array(
				'id_enchant' => $id,
				'replacer'   => $this->getReplacer(),
				'upgrade'    => $this->getBase()+$this->getUpgrade(),
			));
			$StoredModifier->create();
			return $StoredModifier;
		}
} // END class Modifier extends \core\Managed

?>