<?php

namespace item;

/**
 * Item of JDG
 *
 * @author gugus2000
 **/
abstract class Item extends \core\Managed
{
	/* constant */

		/**
		* Avaliable types (int)
		*
		* @var array
		*/
		const AV_TYPE_INT=array(0,1,2,3,4,5);
		/**
		* Available types (string)
		*
		* @var array
		*/
		const AV_TYPE_STR=array('random', 'equipment', 'weapon', 'jewelry', 'consumable', 'spellbook');
		/**
		* Available qualities (int)
		*
		* @var array
		*/
		const AV_QUAL_INT=array(0,1,2,3,4,5,6,7);
		/**
		* Available qualities (string)
		*
		* @var array
		*/
		const AV_QUAL_STR=array('random', 'bad', 'mediocre', 'medium', 'correct', 'good', 'excellent', 'legendary');
		/**
		* Type (int) of item which can be enchanted
		*
		* @var array
		*/
		const TYPE_ENCH=array(1, 2, 3);

	/* attributes */

		/**
		* Id of item
		* 
		* @var int
		*/
		protected $id;
		/**
		* id_name of item
		* 
		* @var int
		*/
		protected $id_name;
		/**
		* Type of item
		* 
		* @var int
		*/
		protected $type;
		/**
		* Quality of item
		* 
		* @var int
		*/
		protected $quality;
		/**
		* Value of item
		* 
		* @var int
		*/
		protected $value;

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
			* @return mixed
			*/
			public function getId_name()
			{
				return $this->id_name;
			}
			/**
			* type accessor
			* 
			* @return int
			*/
			public function getType()
			{
				return $this->type;
			}
			/**
			* quality accessor
			* 
			* @return int
			*/
			public function getQuality()
			{
				return $this->quality;
			}
			/**
			* value accessor
			* 
			* @return int
			*/
			public function getValue()
			{
				return $this->value;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of item
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
			* @param int id_name Id_name of item
			* 
			* @return void
			*/
			protected function setId_name($id_name)
			{
				$this->id_name=(int)$id_name;
			}
			/**
			* type setter
			*
			* @param int type Type of item
			* 
			* @return void
			*/
			protected function setType($type)
			{
				$this->type=(int)$type;
			}
			/**
			* quality setter
			*
			* @param int quality Quality of item
			* 
			* @return void
			*/
			protected function setQuality($quality)
			{
				$this->quality=(int)$quality;
			}
			/**
			* value setter
			*
			* @param int value Value of item
			* 
			* @return void
			*/
			protected function setValue($value)
			{
				$this->value=(int)$value;
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
			* type display
			* 
			* @return string
			*/
			public function displayType()
			{
				return htmlspecialchars((string)$this->type);
			}
			/**
			* quality display
			* 
			* @return string
			*/
			public function displayQuality()
			{
				return htmlspecialchars((string)$this->quality);
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

		/* converter */

			/**
			* Converter for type string => int
			*
			* @param string type Type to convert
			* 
			* @return int
			*/
			public static function converterTypeToInt($type)
			{
				if (in_array($type, self::AV_TYPE_STR))
				{
					return self::AV_TYPE_INT[array_search($type, self::AV_TYPE_STR)];
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_type']);
			}
			/**
			* Converter for type int => string
			*
			* @param int type Type to convert
			* 
			* @return string
			*/
			public static function converterTypeToString($type)
			{
				if (in_array($type, self::AV_TYPE_INT))
				{
					return self::AV_TYPE_STR[array_search($type, self::AV_TYPE_INT)];
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_type']);
			}
			/**
			* Converter for type
			*
			* @param mixed type Type to convert
			* 
			* @return mixed
			*/
			public static function converterType($type)
			{
				if (is_int($type))
				{
					return self::converterTypeToString($type);
				}
				else if (is_string($type))
				{
					return self::converterTypeToInt($type);
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_type']);
			}
			/**
			* Converter for quality string => int
			*
			* @param string quality Quality to convert
			* 
			* @return int
			*/
			public static function converterQualityToInt($quality)
			{
				if (in_array($quality, self::AV_QUAL_STR))
				{
					return self::AV_QUAL_INT[array_search($quality, self::AV_QUAL_STR)];
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_quality']);
			}
			/**
			* Converter for quality int => string
			*
			* @param int quality Quality to convert
			* 
			* @return string
			*/
			public static function converterQualityToString($quality)
			{
				if (in_array($quality, self::AV_QUAL_INT))
				{
					return self::AV_QUAL_STR[array_search($quality, self::AV_QUAL_INT)];
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_quality']);
			}
			/**
			* Converter for quality
			*
			* @param mixed quality Quality to convert
			* 
			* @return mixed
			*/
			public static function ConverterQuality($quality)
			{
				if (is_int($quality))
				{
					return self::ConverterQualityToString($quality);
				}
				else if (is_string($quality))
				{
					return self::ConverterQualityToInt($quality);
				}
				throw new \Exception($GLOBALS['lang']['class_item_unknown_quality']);
			}

		/**
		* Name display
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
		}
		/**
		* Display an item
		* 
		* @return string
		*/
		public function display()
		{
			return $this->displayName();
		}
		/**
		* Retrieve all names
		* 
		* @return array
		*/
		public function retrieveNames()
		{
			$ContentManager=new \content\ContentManager(\core\DBFactory::MysqlConnection());
			return $ContentManager->retrieveBy(array(
				'id_content' => $this->getId_content(),
			), array(
				'id_content' => '=',
			));
		}
		/**
		* Generate an item
		*
		* @param array parameters Parameters for the generation
		* 
		* @return \item\Item
		*/
		public static function generateItem($parameters)
		{
			if (!isset($parameters['quality']))
			{
				$parameters['quality']=0;
			}
			if (is_string($parameters['quality']))
			{
				$parameters['quality']=self::converterQualityToInt($parameters['quality']);
			}
			if ($parameters['quality']===0)
			{
				if (!isset($parameters['quality_weigth']))
				{
					$parameters['quality_weigth']=$GLOBALS['config']['class_item_item_default_quality_weigth'];
				}
				$parameters['quality']=getRandomWeightedElement($parameters['quality_weigth']);
			}
			if (!isset($parameters['type']))
			{
				$parameters['type']=0;		// random
			}
			if (is_string($parameters['type']))
			{
				$parameters['type']=self::converterTypeToInt($parameters['type']);
			}
			if ($parameters['type']===0)
			{
				if (!isset($parameters['type_weigth']))
				{
					$parameters['type_weigth']=$GLOBALS['config']['class_item_item_default_type_weigth'];
				}
				$parameters['type']=getRandomWeightedElement($parameters['type_weigth']);
			}
			$item=array(
				'type'    => $parameters['type'],
				'quality' => $parameters['quality'],
			);
			if (in_array($parameters['type'], self::TYPE_ENCH))
			{
				if (!isset($parameters['enchantment']))
				{
					$parameters['enchantment']=$GLOBALS['config']['class_item_item_default_enchantment'];
				}
				if (!isset($parameters['enchantment']['strict']))
				{
					$parameters['enchantment']['strict']=$GLOBALS['config']['class_item_item_default_enchantment_strict'];
				}
				if (!$parameters['enchantment']['strict'])
				{
					if (!isset($parameters['enchantment']['weigth']))
					{
						$parameters['enchantment']['weigth']=$GLOBALS['config']['class_item_item_default_enchantment_weigth'];
					}
					$parameters['enchantment']['strict']=(bool)getRandomWeightedElement($parameters['enchantment']['weigth']);
				}
				if ($parameters['enchantment']['strict'])
				{
					switch ($parameters['type'])
					{
						case 1:
						case 3:
							$Manager=new \item\enchant\OtherEnchantmentManager(\core\DBFactory::MysqlConnection());
							if ($Manager->count()>0)
							{
								$item['enchant']=new \item\enchant\OtherEnchantment($Manager->getBy()[random_int(0, $Manager->count()-1)]);
							}
							else
							{
								throw new \Exception($lang['class_item_item_no_enchantment_available']);
							}
							break;
						case 2:
							$Manager=new \item\enchant\WeaponEnchantmentManager(\core\DBFactory::MysqlConnection());
							if ($Manager->count()>0)
							{
								$item['enchant']=new \item\enchant\WeaponEnchantment($Manager->getBy()[random_int(0, $Manager->count()-1)]);
							}
							else
							{
								throw new \Exception($lang['class_item_item_no_enchantment_available']);
							}
							break;
						default:
							throw new \Exception($lang['class_item_item_unknown_enchantable_item']);
							break;
					}
					$item['enchant']->retrieve();
				}
			}
			switch (self::converterTypeToString($parameters['type']))
			{
				case 'equipment':
					$Item=new \item\Equipment($item);
					break;
				case 'weapon':
					$Item=new \item\Weapon($item);
					break;
				case 'jewelry':
					$Item=new \item\Jewelry($item);
					break;
				case 'consumable':
					$Item=new \item\Consumable($item);
					break;
				case 'spellbook':
					$Item=new \item\SpellBook($item);
					break;
				default:
					throw new \Exception($GLOBALS['lang']['class_item_unknown_type']);
					break;
			}
			$Manager=$Item->Manager();
			$max=$Manager->countBy(array(
				'quality' => $Item->getQuality(),
			), array(
				'quality' => '=',
			))-1;
			if ($max>0)
			{
				$array=$Manager->getBy(array(
					'quality' => $Item->getQuality(),
				), array(
					'quality' => '=',
				))[random_int(0, $max)];
				$Item->hydrate($array);
			}
			else
			{
				return self::generateItem($parameters);
			}
			$Item->calcValue();
			return $Item;
		}
		/**
		* Test if an item is enchanted
		* 
		* @return bool
		*/
		public function isEnchanted()
		{
			if (in_array('item\Enchanted', class_parents($this)))
			{
				return $this->getEnchant()!==null;
			}
			return False;
		}
		/**
		* Calculate the real value of an item
		* 
		* @return int
		*/
		public function calcValue()
		{
			return $this->getValue();
		}
		/**
		* Store an item with its enchantment (if it exists)
		* 
		* @return item\StoredItem
		*/
		public function store()
		{
			if (!$this->isEnchanted())
			{
				$id_enchantment=0;
			}
			else
			{
				$StoredEnchantment=$this->getEnchant()->store();
				$id_enchantment=$StoredEnchantment->getId();
			}
			$StoredItem=new \item\StoredItem(array(
				'type'           => $this->getType(),
				'id_name'        => $this->getId_name(),
				'id_dynamic'     => $this->getId(),
				'value'          => $this->getValue(),
				'quality'        => $this->getQuality(),
				'id_enchantment' => $id_enchantment,
			));
			$StoredItem->create();
			return $StoredItem;
		}
} // END abstract class Item extends \core\Manager

?>