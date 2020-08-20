<?php

namespace core;

/**
 * Object managed by a Manager
 *
 * @author gugus2000
 **/
class Managed
{
	/* Constant */

		/**
		* Criteria (attributes) for checking similarity
		*
		* @var array
		*/
		const SIMILAR_CRITERION=array('id');
		/**
		* Index
		*
		* @var mixed
		*/
		const INDEX='id';

	/* Method */

		/**
		* Gives the name of the accessor function of an attribute
		*
		* @param string $attribute Attribute to be accessed
		* 
		* @return string
		*/
		public function getGet($attribute)
		{
			return 'get'.ucfirst($attribute);
		}
		/**
		* Gives the name of the function that defines an attribute
		*
		* @param string $attribut Attribute for which we want the definitor
		* 
		* @return string
		*/
		public function getSet($attribute)
		{
			return 'set'.ucfirst($attribute);
		}
		/**
		* Gives the name of the function displaying an attribute
		*
		* @param string $attribute Attribute whose display is wanted
		* 
		* @return string
		*/
		public function getDisp($attribute)
		{
			return 'display'.ucfirst($attribute);
		}
		/**
		* Define the display of an attribute
		*
		* @param string $attribute Name of the attribute
		* 
		* @return string
		*/
		public function setDisplay($attribute)
		{
			return htmlspecialchars((string)$this->$attribute);
		}
		/**
		* Hydrates the object
		*
		* @param array $attributes Array containing the name and value of each attribute of the object
		*
		* @return void
		*/
		protected function hydrate($attributes)
		{
			if (empty($attributes))
			{
				new \exception\Error($GLOBALS['lang']['class']['core']['managed']['no_attributes'], 'managed');
			}
			foreach ($attributes as $key => $value)
			{
				$method=$this->getSet($key);
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}
		/**
		* Creates an instance of the Manager class of the managed object
		*
		* @return \core\Manager
		*/
		public function Manager()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['manager'].' '.get_class($this), 'managed');
			$object=get_class($this).'Manager';
			return new $object(\core\DBFactory::MysqlConnection());
		}
		/**
		* Fill the managed object
		*
		* @param mixed $index Index of the managed object
		*
		* @return void
		*/
		public function get($index)
		{
			$this->hydrate($this->Manager()->get($index));
		}
		/**
		* Checks whether two managed objects are identical
		*
		* @param \core\Managed $object The object that checks for similarity
		* 
		* @return bool
		*/
		public function identical($object)
		{
			foreach ($this::SIMILAR_CRITERION as $critere)
			{
				$accessor=$this->getGet($critere);
				if (!$this->$accessor()==$object->$accessor())
				{
					new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['not_identical'].' '.$critere, 'managed');
					return false;
				}
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['is_identical'], 'managed');
			return true;
		}
		/**
		* Returns an array representing the managed object.
		* 
		* @return array
		*/
		public function table()
		{
			$array=array();
			foreach ($this->Manager()::ATTRIBUTES as $attribute)
			{
				$accessor=$this->getGet($attribute);
				if (method_exists($this, $accessor))
				{
					if ($this->$accessor()!==null)
					{
						$array[$attribute]=$this->$accessor();
					}
				}
			}
			return $array;
		}
		/**
		* Retrieve an object in the database
		* 
		* @return void
		*/
		public function retrieve()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['retrieve'].' '.get_class($this), 'managed');
			$getter=$this->getGet($this::INDEX);
			$this->get($this->$getter());
		}
		/**
		* Insert the object in the database
		* 
		* @return void
		*/
		public function create()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['create'].' '.get_class($this), 'managed');
			$id=$this->Manager()->add($this->table());
			$method=$this->getSet($this::INDEX);
			if (method_exists($this, $method))
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['create_set_id'], 'managed');
				$this->$method($id);
			}
		}
		/**
		* Change th object in the database
		* 
		* @return void
		*/
		public function change()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['change'].' '.get_class($this), 'managed');
			$getter=$this->getGet($this::INDEX);
			$this->Manager()->update($this->table(), $this->$getter());
		}
		/**
		* Delete the object in the database
		* 
		* @return void
		*/
		public function delete()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['delete'].' '.get_class($this), 'managed');
			$getter=$this->getGet($this::INDEX);
			$this->Manager()->delete($this->$getter());
		}
		/**
		* Clone a managed object
		* 
		* @return core\Managed
		*/
		public function clone()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['clone'].' '.get_class($this), 'managed');
			$class=get_class($this);
			return new $class($this->table());
		}
		/**
		* Create a \core\Managed instance
		*
		* @param array $attributes Object attributes
		*
		* @return void
		*/
		public function __construct($attributes=array())
		{
			$this->hydrate($attributes);
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['construct'].' '.get_class($this), 'managed');
		}
		/**
		* Object to array
		*
		* @param bool rec Recursive mode?
		* 
		* @return array
		*/
		public function obj2arr($rec=False)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['obj2arr'].' '.get_class($this), 'managed');
			$arr = get_object_vars($this);
			if ($rec)
			{
				return $this->obj2arrRec($arr);
			}
			return $arr;
		}
		/**
		* Array of obj to arr
		*
		* @param array arr Array (of object?)
		* 
		* @return array
		*/
		public function obj2arrRec($arr)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['managed']['obj2arrrec'].' '.get_class($this), 'managed');
			foreach ($arr as $key => $val)
			{
				if (is_object($val))
				{
					if (method_exists($val, 'obj2arr'))
					{
						$arr[$key] = $val->obj2arr();
					}
					else
					{
						$arr[$key] = (array) $val;
					}
				}
				if (is_array($val))
				{
					$arr[$key] = $this->obj2arrRec($val);
				}
			}
			return $arr;
		}
} // END class Manager

?>