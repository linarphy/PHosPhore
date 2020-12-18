<?php

namespace character;

/**
 * Inventory of a character
 *
 * @package jdr
 * @author gugus2000
 **/
class Inventory extends \core\Managed
{
	/* Attribute */

		/**
		 * Id of the inventory
		 *
		 * @var int
		 **/
		protected $id_inventory;
		/**
		 * Items in the inventory
		 *
		 * @var array
		 **/
		protected $items;

	/* Method */

		/* Getter */

			/**
			 * id accessor
			 *
			 * @return int
			 **/
			public function getId_inventory()
			{
				return $this->id_inventory;
			}
			/**
			 * items accessor
			 *
			 * @return array
			 **/

		/* Setter */

			/**
			 * id setter
			 *
			 * @param int $id_inventory Id of the inventory
			 *
			 * @return void
			 **/
			protected function setId_inventory($id_inventory)
			{
				$this->id_inventory=(int)$id_inventory;
			}
			/**
			 * items setter
			 *
			 * @param array $items Items in the inventory
			 *
			 * @return void
			 **/
			protected function setItems($items)
			{
				if (is_array($items))
				{
					$this->items=$items;
				}
			}

		/* Display */

			/**
			 * id display
			 *
			 * @return string
			 **/
			public function displayId_inventory()
			{
				return htmlspecialchars((string)$this->id_inventory);
			}
			/**
			 * items display
			 *
			 * @return string
			 **/
			public function displayItems()
			{
				$display='';
				for ($this->items as $Item)
				{
					$display.=$Item->display();
				}
				return display;
			}

	/**
	 * Return items which are equipped by the character
	 *
	 * @return array
	 **/
	public function equipped()
	{
		$Equipped=[];
		for ($this->items as $Item)
		{
			if ($Item->getIs_equipped())
			{
				$Equipped[$Item->getId()]=$Item;
				$Parts[$Item->getPart()]+=$Item->getPartCost();
				$ItemParts[$Item->getPart()][]=$Item;
			}
		}
		for ($Parts as $part => $cost)
		{
			if ($cost>$this::COST_PARTS[$part])
			{
				$i=0;
				while ($cost>$this->COST_PARTS[$part])
				{
					$ItemParts[$part][$i]->unEquip();
					$cost-=$ItemParts[$part]->getPartCost();
					delete($Equipped[$ItemParts[$part][$i]->getId()]);
				}
			}
		}
		return $Equipped;
	}
	/**
	 * Get the CAC additional damage (weapons and enchant)
	 *
	 * @return int
	 **/
	public function getCACDamage()
	{
		$damage=0;
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$damage+=$Item->getCACDamage();
		}
	}
	/**
	 * Get the DIS additional damage (weapons and enchant)
	 *
	 * @return int
	 **/
	public function getDISDamage()
	{
		$damage=0;
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$damage+=$Item->getDISDamage();
		}
	}
	/**
	 * Get the MAG additional damage (weapons and enchant)
	 *
	 * @param string $type Magical type of the damage
	 *
	 * @return int
	 **/
	public function getMAGDamage($type)
	{
		$damage=0;
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$damage+=$Item->getMAGDamage($type);
		}
		return $damage;
	}
	/**
	 * Get CAC effects for enemy
	 *
	 * @return array
	 **/
	public function getCACEffects()
	{
		$effects=[];
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$effects=array_merge($effects, $Item->getCACEffects());
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
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$effects=array_merge($effects, $Item->getDISEffects());

		}
		return $effects;
	}
	/**
	 * Get MAG effects for enemy
	 *
	 * @param string $type Magical type of the damage
	 *
	 * @return array
	 **/
	public function getMAGEffects($type)
	{
		$effects=[];
		$Equipped=$this->equipped();
		for ($Equipped as $Item)
		{
			$effects=array_merge($effects, $Item->getMAGEffects($type));

		}
		return $effects;
	}
}

?>
