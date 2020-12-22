<?php

namespace character;

/**
 * Inventory
 *
 * @author gugus2000
 **/
class Inventory extends \core\Managed
{
	/* attribute */

		/**
		* Id of the inventory
		* 
		* @var int
		*/
		protected $id_inventory;
		/**
		* Id of the item which is in the inventory
		* 
		* @var int
		*/
		protected $id_item;
		/**
		* Number of item
		* 
		* @var int
		*/
		protected $number;
		/**
		* List of all the items with their number
		* 
		* @var array
		*/
		protected $items;

	/* method */

		/* getter */

			/**
			* id_inventory getter
			* 
			* @return int
			*/
			public function getId_inventory()
			{
				return $this->id_inventory;
			}
			/**
			* id_item getter
			* 
			* @return int
			*/
			public function getId_item()
			{
				return $this->id_item;
			}
			/**
			* number getter
			* 
			* @return int
			*/
			public function getNumber()
			{
				return $this->number;
			}
			/**
			* items getter
			* 
			* @return array
			*/
			public function getItems()
			{
				return $this->items;
			}

		/* setter */

			/**
			* id_inventory setter
			*
			* @param int id_inventory Id of the inventory
			* 
			* @return void
			*/
			protected function setId_inventory($id_inventory)
			{
				$this->id_inventory=(int)$id_inventory;
			}
			/**
			* id_item setter
			*
			* @param int id_item Id of the item which is in the inventory
			* 
			* @return void
			*/
			protected function setId_item($id_item)
			{
				$this->id_item=(int)$id_item;
			}
			/**
			* number setter
			*
			* @param int number Number of item
			* 
			* @return void
			*/
			protected function setNumber($number)
			{
				$this->number=(int)$number;
			}
			/**
			* items setter
			*
			* @param array items List of all the items with their number
			* 
			* @return void
			*/
			protected function setItems($items)
			{
				$this->items=$items;
			}

		/* display */

			/**
			* id_inventory display
			* 
			* @return string
			*/
			public function displayId_inventory()
			{
				return htmlspecialchars((string)$this->id_inventory);
			}
			/**
			* id_item display
			* 
			* @return string
			*/
			public function displayId_item()
			{
				return htmlspecialchars((string)$this->id_item);
			}
			/**
			* number display
			* 
			* @return string
			*/
			public function displayNumber()
			{
				return htmlspecialchars((string)$this->number);
			}
			/**
			* items display
			* 
			* @return string
			*/
			public function displayItems()
			{
				$display='';
				foreach ($this->items as $item)
				{
					$display.=htmlspecialchars((string)$item['number']).': '.$item['item']->display();
				}
				return $display;
			}

		/**
		* Retrieve an inventory
		* 
		* @return void
		*/
		public function retrieve()
		{
			$this->retrieveItems();
		}
		/**
		* Retrieve the items array
		* 
		* @return void
		*/
		public function retrieveItems()
		{
			$Manager=$this->Manager();
			$inventory=$Manager->getBy(array(
				'id_inventory' => $this->getId_inventory(),
			), array(
				'id_inventory' => '=',
			));
			$items=array();
			foreach ($inventory as $item)
			{
				$Item=new \item\StoredItem(array(
					'id' => $item['id_item'],
				));
				$Item->retrieve();
				$items[]=array(
					'number' => $item['number'],
					'item'   => $Item,
				);
			}
			$this->setItems($items);
		}
		/**
		* Determines the next inventory id not taken
		* 
		* @return int
		*/
		static public function determineNewId()
		{
			$Manager=new \character\InventoryManager(\core\DBFactory::MysqlConnection());
			if ((bool)$Manager->getBy(array(
				'id_inventory' => '-1',
			), array(
				'id_inventory' => '!=',
			), array(
				'order' => 'id_inventory',
				'end'   => 0,
			)))
			{
				return (int)$Manager->getBy(array(
					'id_inventory' => '-1',
				), array(
					'id_inventory' => '!=',
				), array(
					'order' => 'id_inventory',
					'end'   => 0,
				))[0]['id_inventory']+1;
			}
			return 1;
		}
} // END class Inventory extends \core\Managed

?>