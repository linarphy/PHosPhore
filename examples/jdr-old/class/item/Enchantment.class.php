<?php

namespace item;

/**
 * Enchantment
 *
 * @author gugus2000
 **/
abstract class Enchantment extends \core\Managed
{
	/* attribute */

		/**
		* Id of the enchantment
		* 
		* @var int
		*/
		protected $id;
		/**
		* id of the content corresponding to the name of the enchantment
		* 
		* @var int
		*/
		protected $id_name;
		/**
		* Id of the content correponding to the description of the enchantment
		* 
		* @var int
		*/
		protected $id_description;
		/**
		* base value of the enchantment
		* 
		* @var int
		*/
		protected $base_value;
		/**
		* Real value of the enchantment
		* 
		* @var int
		*/
		protected $value;
		/**
		* Modifiers for this enchant
		* 
		* @var array
		*/
		protected $modifiers;

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
			* id_name getter
			* 
			* @return int
			*/
			public function getId_name()
			{
				return $this->id_name;
			}
			/**
			* id_description getter
			* 
			* @return int
			*/
			public function getId_description()
			{
				return $this->id_description;
			}
			/**
			* base_value getter
			* 
			* @return int
			*/
			public function getBase_value()
			{
				return $this->base_value;
			}
			/**
			* value getter
			* 
			* @return int
			*/
			public function getValue()
			{
				if (!$this->value===null)
				{
					$this->calcValue();
				}
				return $this->value;
			}
			/**
			* modifiers getter
			* 
			* @return array
			*/
			public function getModifiers()
			{
				return $this->modifiers;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the enchantment
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* id_name setter
			*
			* @param int id_name id of the content corresponding to the name of the enchantment
			* 
			* @return void
			*/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/**
			* id_description setter
			*
			* @param int id_description Id of the content correponding to the description of the enchantment
			* 
			* @return void
			*/
			protected function setId_description($id_description)
			{
				$this->id_description=(int)$id_description;
			}
			/**
			* base_value setter
			*
			* @param int base_value base value of the enchantment
			* 
			* @return void
			*/
			protected function setBase_value($base_value)
			{
				$this->base_value=(int)$base_value;
			}
			/**
			* value setter
			*
			* @param int value Real value of the enchantment
			* 
			* @return void
			*/
			protected function setValue($value)
			{
				$this->value=(int)$value;
			}
			/**
			* modifiers setter
			*
			* @param array modifiers Modifiers for the enchantment
			* 
			* @return void
			*/
			protected function setModifiers($modifiers)
			{
				$this->modifiers=(array)$modifiers;
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
			* id_name display
			* 
			* @return string
			*/
			public function displayId_name()
			{
				return htmlspecialchars((string)$this->id_name);
			}
			/**
			* id_description display
			* 
			* @return string
			*/
			public function displayId_description()
			{
				return htmlspecialchars((string)$this->id_description);
			}
			/**
			* base_value display
			* 
			* @return string
			*/
			public function displayBase_value()
			{
				return htmlspecialchars((string)$this->base_value);
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
			* modifiers display
			* 
			* @return string
			*/
			public function displayModifiers()
			{
				$display='';
				foreach ($this->modifiers as $modifier)
				{
					$display.=$modifier->display();
				}
				return $display;
			}

		/**
		* Display the name of the enchantment
		* 
		* @return string
		*/
		public function displayName()
		{
			global $Visitor;
			$Name=new \content\Content(array(
				'id_content' => $this->getId_name(),
			));
			$Name->retrieveLang($Visitor->getConfiguration('lang'));
			return $Name->display();
		}/**
		* Display the description of the enchantment
		* 
		* @return string
		*/
		public function displayDescription()
		{
			global $Visitor;
			$Description=new \content\Content(array(
				'id_content' => $this->getId_description(),
			));
			$Description->retrieveLang($Visitor->getConfiguration('lang'));
			return $Description->display();
		}
		/**
		* Display an enchantment
		* 
		* @return string
		*/
		public function display()
		{
			$description=$this->displayDescription();
			if (!empty($this->modifiers))
			{
				foreach ($this->modifiers as $modifier)
				{
					$description=str_replace('|'.$modifier->getReplacer().'|', (string)($modifier->getBase()+$modifier->getUpgrade()), $description);
				}
			}
			return $this->displayName().' | '.$description;
		}
		/**
		* Retrieve Modifiers
		* 
		* @return void
		*/
		public function retrieveModifiers()
		{
			$Manager=new \item\enchant\ModifierManager(\core\DBFactory::MysqlConnection());
			$modifiers=$Manager->getBy(array(
				'id_enchant' => $this->getId(),
				'type'       => $this::ENCHANT_TYPE,
			), array(
				'id_enchant' => '=',
				'type'       => '=',
			));
			$Modifiers=array();
			foreach ($modifiers as $modifier)
			{
				$weight=array(0 => 100);
				$summ=100;
				for ($i=1; $i < $modifier['max']-1; $i++)
				{
					$weight[$i]=round($weight[$i-1]-$modifier['luck']*$weight[$i-1]);
					$summ+=$weight[$i];
				}
				$rand=mt_rand(1, $summ);
				for ($i=0; $i < $modifier['max']; $i++)
				{
					$rand-=$weight[$i];
					if ($rand<=0)
					{
						$modifier['upgrade']=$i;
						break;
					}
				}
				$Modifiers[]=new \item\enchant\Modifier($modifier);
			}
			$this->setModifiers($Modifiers);
		}
		/**
		* Retrieve an enchantment
		* 
		* @return void
		*/
		public function retrieve()
		{
			parent::retrieve();
			$this->retrieveModifiers();
			$this->calcValue();
		}
		/**
		* Calc value
		* 
		* @return void
		*/
		public function calcValue()
		{
			if ($this->getValue()===null)
			{
				$this->setValue($this->getBase_value());
			}
			if (!empty($this->modifiers))
			{
				foreach ($this->modifiers as $modifier)
				{
					$add_value=$modifier->getUpgrade()*$modifier->getValue();
					$this->setValue($this->getValue()+$add_value);
				}
			}
		}
		/**
		* Store the enchantment with mofifiers (if they exist)
		* 
		* @return item\enchant\StoredEnchantment
		*/
		public function store()
		{
			$StoredEnchantment=new \item\enchant\StoredEnchantment(array(
				'type'           => $this::ENCHANT_TYPE,
				'id_name'        => $this->getId_name(),
				'id_description' => $this->getId_description(),
				'id_dynamic'     => $this->getId(),
			));
			$StoredEnchantment->create();
			$modifiers=array();
			if (!empty($this->modifiers))
			{
				foreach ($this->getModifiers() as $Modifier)
				{
					$modifiers[]=$Modifier->store($StoredEnchantment->getId());
				}
			}
			$StoredEnchantment->retrieveModifiers();
			return $StoredEnchantment;
		}
} // END abstract class Enchantment extends \core\Managed

?>