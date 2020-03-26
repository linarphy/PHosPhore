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
		public function setAffichage($attribute)
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
				throw new \Exception($GLOBALS['lang']['class_core_managed_no_attributes']);
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
			foreach ($this::CRITERES_SIMILAIRE as $critere)
			{
				$accessor=$this->getGet($critere);
				if (!$this->$accessor()==$objet->$accessor())
				{
					return false;
				}
			}
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
					if ($this->$accessor()!=null)
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
			$this->Manager()->add($this->table());
			$method=$this->getSet($this::INDEX);
			if (method_exists($this, $method))
			{
				$this->method($this->Manager()->getIdBy($this->table()));
			}
		}
		/**
		* Change th object in the database
		* 
		* @return void
		*/
		public function change()
		{
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
			$getter=$this->getGet($this::INDEX);
			$this->Manager()->delete($this->$getter());
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
		}
} // END class Manager

?>