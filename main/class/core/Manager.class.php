<?php

namespace core;

/**
 * Connection between a \core\Managed object and its characteristic database
 *
 * @author gugus2000
 **/
class Manager
{
	/* Attribute */

		/**
		* PDO database connection
		*
		* @var \PDO
		*/
		protected $bdd;

	/* Constant */

		/**
		* Name of the table linked to the object
		*
		* @var string
		*/
		const TABLE='';
		/**
		* List of all table attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array();
		/**
		* Index used (primary key)
		*
		* @var string
		*/
		const INDEX='id';

	/* Method */

		/* Getter */

			/**
			* bdd accessor
			*
			* @return \PDO
			*/
			public function getBdd()
			{
				return $this->bdd;
			}

		/* Setter */

			/**
			* bdd setter
			*
			* @param \PDO $bdd PDO database connection
			*
			* @return void
			*/
			protected function setBdd($bdd)
			{
				$this->bdd=$bdd;
			}

		/**
		* Checks the existence of each attribute in the list as an attribute of the selected table
		*
		* @param array $array Array to be checked with attributes as key
		* 
		* @return array
		*/
		public function testAttributes($array)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['test_attributes'], 'manager');
			return array_intersect_key($array, array_flip($this::ATTRIBUTES));
		}
		/**
		* Associations between values and operations
		*
		* @param array $values Array containing the name and value of each attribute
		*
		* @param mixed $operations Array containing the name and operation to be performed on each attribute or operation to be performed on each attribute
		* 
		* @return array
		*/
		public function conditionCreator($values, $operations)
		{
			$values=$this->testAttributes($values);
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['condition_creator_start'], 'manager');
			$attributesWithOperators=array();
			if (!empty($values) && $values!==null)
			{
				if (is_array($operations))	// Array containing the name and operation to be performed on each attribute
				{
					new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['operations_array'], 'manager');
					foreach ($values as $attribute => $value)
					{
						if (isset($operations[$attribute]))
						{
							switch (trim($operations[$attribute]))	// Operators whitelist
							{
								case 'IN':
									if (!isset($attributes))
									{
										$attributes=array_keys($values);
									}
									$attributesWithOperators[]=$attribute.' IN ('.str_repeat('?, ', count($value)-1).'?)';
									$array_search_result=array_search($attribute, $attributes);
									if (count($values)>1)
									{
										if ($array_search_result<=0)
										{
											$values=array_merge($value,array_slice($values, 1));
										}
										else if ($array_search_result>=count($values)-1)
										{
											$values=array_merge(array_slice($values, 0, count($values)-1), $value);
										}
										else
										{
											$values=array_merge(array_slice($values, 0, $array_search_result, true),$value,array_slice($values, $array_search_result+1, null, true));
										}
									}
									else
									{
										$values=$value;
									}
									break;
								case '=':
								case '!=':
								case '<>':
								case '>':
								case '<':
								case '>=':
								case '<=':
									$attributesWithOperators[]=$attribute.$operations[$attribute].'?';
									break;
								default:
									new \exception\Error($GLOBALS['lang']['class']['core']['manager']['unknown_operator'], 'manager');
									break;
							}
						}
						else
						{
							$attributesWithOperators[]=$attribute.'=?';
						}
					}
				}
				else if (is_string($operations))	// operation to be performed on each attribute
				{
					new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['operations_string'], 'manager');
					switch (strtolower(trim($operations)))
					{
						case 'IN':
							foreach ($values as $attribute => $value)
							{
								if (!isset($attributes))
								{
									$attributes=array_keys($values);
								}
								$attributesWithOperators[]=$attribute.' IN ('.str_repeat('?, ', count($value)-1).'?)';
								$array_search_result=array_search($attribute, $attributes);
								if (count($values)>1)
								{
									if ($array_search_result<=0)
									{
										$values=array_merge($value,array_slice($values, 1));
									}
									else if ($array_search_result>=count($values)-1)
									{
										$values=array_merge(array_slice($values, 0, count($values)-1), $value);
									}
									else
									{
										$values=array_merge(array_slice($values, 0, $array_search_result, true),$value,array_slice($values, $array_search_result+1, null, true));
									}
								}
								else
								{
									$values=$value;
								}
							}
							break;
						case '=':
						case '!=':
						case '<>':
						case '>':
						case '<':
						case '>=':
						case '<=':
							foreach ($values as $attribute => $value)
							{
								$attributesWithOperators[]=$attribute.$operations.'?';
							}
							break;
						default:
							new \exception\Error($GLOBALS['lang']['class']['core']['manager']['unknown_operator'], 'manager');
							break;
					}
				}
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['manager']['unknown_operations_type'], 'manager');
					foreach ($values as $attribute => $value)
					{
						$attributesWithOperators[]=$attribute.'=?';
					}
				}
			}
			return [$attributesWithOperators, $values];
		}
		/**
		* Allows to generate the limit clause from a complex array for a mysql query
		*
		* @param array $bounds Bounds
		* 
		* @return string
		*/
		public function boundaryInterpreter($bounds)
		{
			$order_by=$this::INDEX;
			$order='ASC';
			$offset=0;
			$limit=1;
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['boundary_interpreter_start'], 'manager');
			foreach ($bounds as $name => $value)
			{
				switch (strtolower(trim($name)))
				{
					case 'order by':
					case 'order':
					case 'order_by':
						new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['order_by'], 'manager');
						if (!in_array($value, $this::ATTRIBUTES))
						{
							new \exception\Error($GLOBALS['lang']['class']['core']['manager']['unknown_attribute'], 'manager');
						}
						else
						{
							$order_by=$value;
						}
						break;
					case 'end':
						new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['end'], 'manager');
						if (!is_numeric($value))
						{
							new \exception\Error($GLOBALS['lang']['error_not_numeric'], 'manager');
						}
						else
						{
							$offset=$value;
							$order='DESC';
						}
						break;
					case 'direction':
						new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['direction'], 'manager');
						if ($order==='ASC')	// end have priority
						{
							switch (strtolower(trim($value)))
							{
								case 'ASC':
								case 'DESC':
									$order=$value;
									break;
								default:
									new \exception\Error($GLOBALS['lang']['class']['core']['manager']['unknown_direction'], 'manager');
							}
						}
						else
						{
							new \exception\Warning($GLOBALS['lang']['class']['core']['manager']['already_end'], 'manager');
						}
						break;
					case 'offset':
					case 'position':
					case 'start':
						new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['offset'], 'manager');
						if (!is_numeric($value))
						{
							new \exception\Error($GLOBALS['lang']['error_not_numeric'], 'manager');
						}
						else
						{
							$offset=$value;
						}
						break;
					case 'limit':
					case 'number':
						new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['limit'], 'manager');
						if (!is_numeric($value))
						{
							new \exception\Error($GLOBALS['lang']['error_not_numeric'], 'manager');
						}
						else
						{
							$limit=$value;
						}
						break;
					default:
						new \exception\Error($GLOBALS['lang']['class']['core']['manager']['unknown_clause'].' '.$name, 'manager');
				}
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['boundary_interpreter_end'].' ['.'ORDER BY '.$order_by.' '.$order.' LIMIT '.(string)$limit.' OFFSET '.(string)$offset.']', 'manager');
			return 'ORDER BY '.$order_by.' '.$order.' LIMIT '.(string)$limit.' OFFSET '.(string)$offset;
		}
		/**
		* Retrieves the result of a Mysql query on an element
		*
		* @param mixed $index Index of the element
		*
		* @return array
		*/
		public function get($index)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['get'].' '.'SELECT '.implode(',', $this::ATTRIBUTES).' FROM '.$this::TABLE.' WHERE '.$this::INDEX.'='.$index, 'manager');
			$requete=$this->getBdd()->prepare('SELECT '.implode(',', $this::ATTRIBUTES).' FROM '.$this::TABLE.' WHERE '.$this::INDEX.'=?');
			$requete->execute(array($index));
			return $requete->fetch(\PDO::FETCH_ASSOC);
		}
		/**
		* Adds an element to the database
		*
		* @param array $values Array containing the name and value of each attribute
		*
		* @return int
		*/
		public function add($values)
		{
			$values=$this->testAttributes($values);
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['add'].' '.'INSERT INTO '.$this::TABLE.'('.implode(',', array_keys($values)).') VALUES ('.implode(',', $values).')', 'manager');
			$requete=$this->getBdd()->prepare('INSERT INTO '.$this::TABLE.'('.implode(',', array_keys($values)).') VALUES ('.implode(',', array_fill(0, count($values), '?')).')');
			$requete->execute(array_values($values));
			return $this->getBdd()->lastInsertId();
		}
		/**
		* Updates an element in the database
		*
		* @param array $values Array containing the name and value of each attribute
		* 
		* @param mixed $index Index of the element to be modified
		*
		* @return void
		*/
		public function update($values, $index)
		{
			$attributesWithOperators=array();
			$values=$this->testAttributes($values);
			foreach ($values as $attribute => $value)
			{
				$attributesWithOperators[]=$attribute.'=?';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['update'].' '.'UPDATE '.$this::TABLE.' SET '.implode(',', $attributesWithOperators).' WHERE '.$this::INDEX.'='.$index, 'manager');
			$requete=$this->getBdd()->prepare('UPDATE '.$this::TABLE.' SET '.implode(',', $attributesWithOperators).' WHERE '.$this::INDEX.'=?');
			$values[]=$index;
			$requete->execute(array_values($values));
		}
		/**
		* Update an element from the database according to several parameters
		*
		* @param array values_get Attributes value to get the element
		*
		* @param array operations Attributes operations for values_get
		*
		* @param array values_update Attributes to update 
		* 
		* @return void
		*/
		public function updateBy($values_get, $operations, $values_update)
		{
			$valuesUpdateOperators=array();
			$values_update=$this->testAttributes($values_update);
			foreach ($values_update as $attribute => $value)
			{
				$valuesUpdateOperators[]=$attribute.'=?';
			}
			if (!empty($values_get) && $values_get!==null)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values_get, $operations);
				$valuesGetOperators=$conditionCreator[0];
				$values_get=$conditionCreator[1];
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $valuesGetOperators), 'manager');
				$where=' WHERE '.implode(' AND ', $valuesGetOperators);
			}
			else
			{
				$where='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['updateby'].' '.'UPDATE '.$this::TABLE.' SET '.implode(',', $valuesUpdateOperators).$where, 'manager');
			$requete=$this->getBdd()->prepare('UPDATE '.$this::TABLE.' SET '.implode(',', $valuesUpdateOperators).$where);
			$values[]=$index;
			$requete->execute(array_values($values));
		}
		/**
		* Deletes an element from the database
		*
		* @param mixed $index Index of the element to be deleted
		*
		* @return void
		*/
		public function delete($index)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['delete'].' '.'DELETE FROM '.$this::TABLE.' WHERE '.$this::INDEX.'='.$index, 'manager');
			$requete=$this->getBdd()->prepare('DELETE FROM '.$this::TABLE.' WHERE '.$this::INDEX.'=?');
			$requete->execute(array($index));
		}
		/**
		* Removes an element from the database according to several parameters
		*
		* @param array $values Attributes values
		*
		* @param array $operations Attributes operations
		* 
		* @return void
		*/
		public function deleteBy($values, $operations)
		{
			if (!empty($values) && $values!==null)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values, $operations);
				$attributesWithOperators=$conditionCreator[0];
				$values=$conditionCreator[1];
				$where=' WHERE '.implode(' AND ', $attributesWithOperators);
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $attributesWithOperators), 'manager');
			}
			else
			{
				$where='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['deleteby'].' '.'DELETE FROM '.$this::TABLE.$where, 'manager');
			$requete=$this->getBdd()->prepare('DELETE FROM '.$this::TABLE.$where);
			$requete->execute(array_values($values));
		}
		/**
		* Gets the index of the element
		*
		* @param array $values Array containing the name and value of each attribute to determine the index of the element
		*
		* @param array $operations Attributes operations
		*
		* @return string
		*/
		public function getIdBy($values, $operations='=')
		{
			if (!empty($values) && $values!==null)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values, $operations);
				$attributesWithOperators=$conditionCreator[0];
				$values=$conditionCreator[1];
				$where=' WHERE '.implode(' AND ', $attributesWithOperators);
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $attributesWithOperators), 'manager');
			}
			else
			{
				$where='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['getidby'].' '.'SELECT '.$this::INDEX.' FROM '.$this::TABLE.$where, 'manager');
			$requete=$this->getBdd()->prepare('SELECT '.$this::INDEX.' FROM '.$this::TABLE.$where);
			$requete->execute(array_values($values));
			$fetch_result=$requete->fetch(\PDO::FETCH_ASSOC);
			if (isset($fetch_result[$this::INDEX]))
			{
				return $fetch_result[$this::INDEX];
			}
			new \exception\Warning($GLOBALS['lang']['class']['core']['manager']['error_getidby']);
			return 'error';
		}
		/**
		* Gets the index of the element from its position relative to an attribute
		*
		* @param int $position Element position (0=first)
		*
		* @param string $attribute Attribute on which the element is positioned
		* 
		* @return mixed
		*/
		public function getIdByPos($position, $attribute)
		{
			if (is_int($position) && in_array($attribute, $this::ATTRIBUTES))
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['getidbypos'].' '.'SELECT '.$this::INDEX.' FROM '.$this::TABLE.' ORDER BY '.$attribute.' DESC LIMIT 1 OFFSET '.$position, 'manager');
				$requete=$this->getBdd()->prepare('SELECT '.$this::INDEX.' FROM '.$this::TABLE.' ORDER BY '.$attribute.' DESC LIMIT 1 OFFSET '.$position);
				$requete->execute();
				return $requete->fetch(\PDO::FETCH_ASSOC)[$this::INDEX];
			}
			else
			{
				new \exception\Error($GLOBALS['lang']['class']['core']['manager']['error_getidbypos'], 'manager');
			}
			return False;
		}
		/**
		* Retrieves the result of the MYSQL query created from the parameters
		*
		* @param array $values Array containing the name and value of each attribute
		* 
		* @param mixed $operations Array containing the name and operation to be performed on each attribute or operation to be performed on each attribute
		*
		* @param array $bounds Array containing the bounds in which to search
		*
		* @return array
		*/
		public function getBy($values=null, $operations=null, $bounds=null)
		{
			if (!empty($values) && $values!==null)
			{	
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values, $operations);
				$attributesWithOperators=$conditionCreator[0];
				$values=$conditionCreator[1];
				$where=' WHERE '.implode(' AND ', $attributesWithOperators).' ';
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $attributesWithOperators), 'manager');
			}
			else
			{
				$where=' ';
			}
			if ($bounds!==null)
			{
				$limit=$this->boundaryInterpreter($bounds);
			}
			else
			{
				$limit='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['getby'].' '.'SELECT '.implode(',', $this::ATTRIBUTES).' FROM '.$this::TABLE.$where.$limit, 'manager');
			$requete=$this->getBdd()->prepare('SELECT '.implode(',', $this::ATTRIBUTES).' FROM '.$this::TABLE.$where.$limit);
			if (!empty($values) && $values!==null)
			{
				$requete->execute(array_values($values));
			}
			else
			{
				new \exception\Warning($GLOBALS['lang']['class']['core']['manager']['getby_void'], 'manager');
				$requete->execute(array());
			}
			return $requete->fetchAll();
		}
		/**
		* Checks for the existence of an element with his id
		*
		* @param mixed $index Index of the element to be checked
		*
		* @return bool
		*/
		public function existId($index)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['existId'].' '.'SELECT '.$this::INDEX.' FROM '.$this::TABLE.' WHERE '.$this::INDEX.'='.$index, 'manager');
			$requete=$this->getBdd()->prepare('SELECT '.$this::INDEX.' FROM '.$this::TABLE.' WHERE '.$this::INDEX.'=?');
			$requete->execute(array($index));
			return (bool)$requete->fetch(\PDO::FETCH_ASSOC);
		}
		/**
		* Checks for the existence of an element
		*
		* @param array $values Array containing the name and value of each attribute
		*
		* @param mixed $operations Array containing the name and operation to be performed on each attribute or operation to be performed on each attribute
		*
		* @return bool
		*/
		public function existBy($values=null, $operations=null)
		{
			if (!empty($values) && $values!==null)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values, $operations);
				$attributesWithOperators=$conditionCreator[0];
				$values=$conditionCreator[1];
				$where=' WHERE '.implode(' AND ', $attributesWithOperators);
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $attributesWithOperators), 'manager');
			}
			else
			{
				$where='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['existBy'].' '.'SELECT '.$this::INDEX.' FROM '.$this::TABLE.$where, 'manager');
			$requete=$this->getBdd()->prepare('SELECT '.$this::INDEX.' FROM '.$this::TABLE.$where);
			$requete->execute(array_values($values));
			return (bool)$requete->fetch(\PDO::FETCH_ASSOC);
		}
		/**
		* Allows faster object retrieval
		*
		* @param array $values Array containing the name and value of each attribute
		* 
		* @param mixed $operations Array containing the name and operation to be performed on each attribute or operation to be performed on each attribute
		*
		* @param array $bounds Array containing the bounds in which to search
		*
		* @return array
		*/
		public function retrieveBy($values=null, $operations=null, $bounds=null)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['retrievBy'], 'manager');
			$results=$this->getBy($values, $operations, $bounds);
			$Objects=array();
			foreach ($results as $result)
			{
				$Objects[]=$this->Managed($result);
			}
			return $Objects;
		}
		/**
		* Counts the number of elements in the database that comply with a specific clause.
		*
		* @param array $values Array containing the name and value of each attribute
		* 
		* @param mixed $operations Array containing the name and operation to be performed on each attribute or operation to be performed on each attribute
		* 
		* @return int
		*/
		public function countBy($values=null, $operations=null)
		{
			if (!empty($values) && $values!==null)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['creating_where'], 'manager');
				$conditionCreator=$this->conditionCreator($values, $operations);
				$attributesWithOperators=$conditionCreator[0];
				$values=$conditionCreator[1];
				$where=' WHERE '.implode(' AND ', $attributesWithOperators);
				new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['where_clause'].' '.'WHERE '.implode(' AND ', $attributesWithOperators), 'manager');
			}
			else
			{
				$where='';
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['countBy'].' '.'SELECT count('.$this::INDEX.') AS nbr FROM '.$this::TABLE.$where, 'manager');
			$requete=$this->getBdd()->prepare('SELECT count('.$this::INDEX.') AS nbr FROM '.$this::TABLE.$where);
			$requete->execute(array_values($values));
			$donnees=$requete->fetch(\PDO::FETCH_ASSOC);
			return (int)$donnees['nbr'];
		}
		/**
		* Counts the number of items in the database
		*
		* @return int
		*/
		public function count()
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['count'].' '.'SELECT count('.$this::INDEX.') AS nbr FROM '.$this::TABLE, 'manager');
			$requete=$this->getBdd()->prepare('SELECT count('.$this::INDEX.') AS nbr FROM '.$this::TABLE);
			$requete->execute();
			$donnees=$requete->fetch(\PDO::FETCH_ASSOC);
			return (int)$donnees['nbr'];
		}
		/**
		* Creates an instance of the managed class of the selected object.
		*
		* @param array $table Table of attributes of the object to be hydrated
		* 
		* @return \core\Managed
		*/
		public function Managed($table)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['managed'].' '.get_class($this), 'manager');
			$object=substr(get_class($this),0,-7);
			return new $object($table);
		}
		/**
		* Creates a \core\Manager instance
		*
		* @param \PDO $bdd PDO database connection
		*
		* @return void
		*/
		public function __construct($bdd=null)
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['manager']['construct'].' '.get_class($this), 'manager');
			if ($bdd===null)
			{
				$bdd=\core\DBFactory::MysqlConnection();
			}
			$this->setBdd($bdd);
		}
} // END class Manager

?>
