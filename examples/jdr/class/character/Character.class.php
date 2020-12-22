<?php

namespace character;

/**
 * A character which can be played with
 *
 * @package jdr
 * @author gugus2000
 **/
class Character extends \core\Managed
{
	/* Attribute */

	/**
	 * Id of the character
	 *
	 * @var int
	 **/
	protected $id;
	/**
	 * Name of the character
	 *
	 * @var string
	 **/
	protected $name;
	/**
	 * Bio of the character
	 *
	 * @var string
	 **/
	protected $bio;
	/**
	 * Experience of the character
	 *
	 * @var int
	 **/
	protected $experience;
	/**
	 * Class of the character
	 *
	 * @var string
	 **/
	protected $_class;
	/**
	 * Race of the character
	 *
	 * @var string
	 **/
	protected $race;
	/**
	 * State of the character
	 *
	 * @var string
	 **/
	protected $state;
	/**
	 * Registration date of the character
	 *
	 * @var string
	 **/
	protected $registration_date;
	/**
	 * Last login data of the character
	 *
	 * @var string
	 **/
	protected $last_login_date;
	/**
	 * Id of the author of the character
	 *
	 * @return int
	 **/
	protected $id_author;
	/**
	 * Id of the party the character is
	 *
	 * @return int
	 **/
	protected $id_party;
	/**
	 * Id of the inventory of the character
	 *
	 * @var int
	 **/
	protected $id_inventory;
	/**
	 * Id of the attributes of the character
	 *
	 * @var int
	 **/
	protected $id_attributes;
	/**
	 * Id of the effects the character has (attributes already modified by them)
	 *
	 * @var int
	 **/
	protected $id_effects;
	/**
	 * Id of the spells the character has
	 *
	 * @var int
	 **/
	protected $id_spells;

	/* Method */

		/* Getter */

			/**
			 * id accessor
			 *
			 * @return int
			 **/
			public function getId()
			{
				return $this->id;
			}
			/**
			 * name accessor
			 *
			 * @return string
			 **/
			public function getName()
			{
				return $this->name;
			}
			/**
			 * bio accessor
			 *
			 * @return string
			 **/
			public function getBio()
			{
				return $this->bio;
			}
			/**
			 * experience accessor
			 *
			 * @return int
			 **/
			public function getExperience()
			{
				return $this->experience;
			}
			/**
			 * _class accessor
			 *
			 * @return string
			 **/
			public function get_class()
			{
				return $this->_class;
			}
			/**
			 * race accessor
			 *
			 * @return string
			 **/
			public function getRace()
			{
				return $this->race;
			}
			/**
			 * state accessor
			 *
			 * @return string
			 **/
			public function getState()
			{
				return $this->state;
			}
			/**
			 * registration_date accessor
			 *
			 * @return string
			 **/
			public function getRegistration_date()
			{
				return $this->registration_date;
			}
			/**
			 * last_login_date accessor
			 *
			 * @return string
			 **/
			public function getLast_login_date()
			{
				return $this->last_login_date;
			}
			/**
			 * id_author accessor
			 *
			 * @return int
			 **/
			public function getId_author()
			{
				return $this->id_author;
			}
			/**
			 * id_party accessor
			 *
			 * @return int
			 **/
			public function getId_party()
			{
				return $this->id_party;
			}
			/**
			 * id_inventory accessor
			 *
			 * @return int
			 **/
			public function getId_inventory()
			{
				return $this->id_inventory;
			}
			/**
			 * id_attributes accessor
			 *
			 * @return int
			 **/
			public function getId_attributes()
			{
				return $this->id_attributes;
			}
			/**
			 * id_effects accessor
			 *
			 * @return int
			 **/
			public function getId_effects()
			{
				return $this->id_effects;
			}
			/**
			 * id_spells accessor
			 *
			 * @return int
			 **/
			public function getId_spells()
			{
				return $this->id_spells;
			}

		/* Setter */

			/**
			 * id setter
			 *
			 * @param int $id Id of the character
			 *
			 * @return void
			 **/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			 * name setter
			 *
			 * @param string $name Name of the character
			 *
			 * @return void
			 **/
			protected function setName($name)
			{
				$this->name=(string)$name;
			}
			/**
			 * bio setter
			 *
			 * @param string $bio Bio of the character
			 *
			 * @return void
			 **/
			protected function setBio($bio)
			{
				$this->bio=(string)$bio;
			}
			/**
			 * experience setter
			 *
			 * @param int $experience Experience of the character
			 *
			 * @return void
			 **/
			protected function setExperience($experience)
			{
				$this->experience=(int)$experience;
			}
			/**
			 * _class setter
			 *
			 * @param string $_class Class of the character
			 *
			 * @return void
			 **/
			protected function set_class($_class)
			{
				$this->_class=(string)$_class;
			}
			/**
			 * race setter
			 *
			 * @param string $race Race of the character
			 *
			 * @return void
			 **/
			protected function setRace($race)
			{
				$this->race=(string)$race;
			}
			/**
			 * state setter
			 *
			 * @param string $state State of the character
			 *
			 * @return void
			 **/
			protected function setState($state)
			{
				$this->state=(string)$state;
			}
			/**
			 * registration_date setter
			 *
			 * @param string $registration_date Registration date of the character
			 *
			 * @return void
			 **/
			protected function setRegistration_date($registration_date)
			{
				$this->registration_date=(string)$registration_date;
			}
			/**
			 * last_login_date setter
			 *
			 * @param string $last_login_date Last login date for the character
			 *
			 * @return void
			 **/
			protected function setLast_login_date($last_login_date)
			{
				$this->last_login_date=(string)$last_login_date;
			}
			/**
			 * id_author setter
			 *
			 * @param int $id_author Id of the author of the character
			 *
			 * @return void
			 **/
			protected function setId_author($id_author)
			{
				$this->id_author=(int)$id_author;
			}
			/**
			 * id_party setter
			 *
			 * @param int $id_party Id of the party the character is
			 *
			 * @return void
			 **/
			protected function setId_party($id_party)
			{
				$this->id_party=(int)$id_party;
			}
			/**
			 * id_inventory setter
			 *
			 * @param int $id_inventory Id of the inventory of the character
			 *
			 * @return void
			 **/
			protected function setId_inventory($id_inventory)
			{
				$this->id_inventory=(int)$id_inventory;
			}
			/**
			 * id_attributes setter
			 *
			 * @param int $id_attributes Id of the attributes of the character
			 *
			 * @return void
			 **/
			protected function setId_attributes($id_attributes)
			{
				$this->id_attributes=(int)$id_attributes;
			}
			/**
			 * id_effects setter
			 *
			 * @param int $id_effects Id of the effects the character has
			 *
			 * @return void
			 **/
			protected function setId_effects($id_effects)
			{
				$this->id_effects=(int)$id_effects;
			}
			/**
			 * id_spells
			 *
			 * @param int $id_spells Id of the spells the character has
			 *
			 * @return void
			 **/
			protected function setId_spells($id_spells)
			{
				$this->id_spells=(int)$id_spells;
			}

		/* Display */

			/**
			 * id display
			 *
			 * @return string
			 **/
			public function displayId()
			{
				return htmlspecialchars((string)$this->id);
			}
			/**
			 * name display
			 *
			 * @return string
			 **/
			public function displayName()
			{
				return htmlspecialchars((string)$this->name);
			}
			/**
			 * bio display
			 *
			 * @return string
			 **/
			public function displayBio()
			{
				return htmlspecialchars((string)$this->bio);
			}
			/**
			 * experience display
			 *
			 * @return string
			 **/
			public function displayExperience()
			{
				return htmlspecialchars((string)$this->experience);
			}
			/** _class display
			 *
			 * @return string
			 **/
			public function display_class()
			{
				return htmlspecialchars((string)$this->_class);
			}
			/**
			 * race display
			 *
			 * @return string
			 **/
			public function displayRace()
			{
				return htmlspecialchars((string)$this->race);
			}
			/**
			 * state display
			 *
			 * @return string
			 **/
			public function displayState()
			{
				return htmlspecialchars((string)$this->state)
			}
			/**
			 * registration_date display
			 *
			 * @return string
			 **/
			public function displayRegistration_date()
			{
				return htmlspecialchars((string)$this->registration_date);
			}
			/**
			 * last_login_date display
			 *
			 * @return string
			 **/
			public function displayLast_login_date()
			{
				return htmlspecialchars((string)$this->last_login_date);
			}
			/**
			 * id_author display
			 *
			 * @return string
			 **/
			public function displayId_author()
			{
				return htmlspecialchars((string)$this->id_author);
			}
			/**
			 * id_party display
			 *
			 * @return string
			 **/
			public function displayId_party()
			{
				return htmlspecialchars((string)$this->id_party);
			}
			/**
			 * id_inventory display
			 *
			 * @return string
			 **/
			public function displayId_inventory()
			{
				return htmlspecialchars((string)$this->id_inventory);
			}
			/**
			 * id_effects display
			 *
			 * @return string
			 **/
			public function displayId_effects()
			{
				return htmlspecialchars((string)$this->id_effects);
			}
			/**
			 * id_spells display
			 *
			 * @return string
			 **/
			public function displayId_effects()
			{
				return htmlspecialchars((string)$this->id_spells);
			}

		/**
		 * Return the author \user\User instance of the character or false if id_author not defined
		 *
		 * @return \user\User | bool
		 **/
		public function retrieveAuthor()
		{
			if ($this->id_author!==null)
			{
				$Author=new \user\User(array(
					'id' => $this->id_author,
				));
				$Author->retrieve()
				return $Author;
			}
			return false;
		}
		/**
		 * Return the author display or false if id_author not defined
		 *
		 * @return string | bool
		 **/
		public function displayAuthor()
		{
			if ($this->id_author!==null)
			{
				return $this->retrieveAuthor()->display();
			}
			return false;
		}
		/**
		 * Return the party \character\Party instance of the character or false if id_party not defined
		 *
		 * @return \character\Party | bool
		 **/
		public function retrieveParty()
		{
			if ($this->id_party!==null)
			{
				$Party=new \character\Party(array(
					'id' => $this->id_party,
				));
				$Party->retrieve()
				return $Party;
			}
			return false;
		}
		/**
		 * Return the party display or false if id_party not defined
		 *
		 * @return string | bool
		 **/
		public function displayParty()
		{
			if ($this->id_party!==null)
			{
				return $this->retrieveParty()->display();
			}
			return false;
		}
		/**
		 * Return the \character\Inventory instance of the character or false if id_inventory not defined
		 *
		 * @return \character\Inventory | bool
		 **/
		public function retrieveInventory()
		{
			if ($this->id_inventory!==null)
			{
				$Inventory=new \character\Inventory(array(
					'id' => $this->id_inventory,
				));
				$Inventory->retrieve();
				return $Inventory;
			}
			return false;
		}
		/**
		 * Return the inventory display or false if id_inventory not defined
		 *
		 * @return string | bool
		 **/
		public function displayInventoy()
		{
			if ($this->id_inventory!==null)
			{
				return $this->retrieveInventory()->display();
			}
			return false;
		}
		/**
		 * Return the \character\Attributes instance of the character or false if id_attributes not defined
		 *
		 * @return \character\Attributes | bool
		 **/
		public function retrieveAttributes()
		{
			if ($this->id_attributes!==null)
			{
				$Attributes=new \character\Attributes(array(
					'id' => $this->id_attributes,
				));
				$Attributes->retrieve();
				return $Attributes;
			}
			return false;
		}
		/**
		 * Return the attributes display or false if id_attributes is not defined
		 *
		 * @return string | bool
		 **/
		public function displayAttributes()
		{
			if ($this->id_attributes!==null)
			{
				return $this->retrieveAttributes()->display();
			}
			return false;
		}
		/**
		 * Return the \character\Effects instance of the character or false if id_effects not defined
		 *
		 * @return \character\Effects | bool
		 **/
		public function retrieveEffects()
		{
			if ($this->id_effects!==null)
			{
				$Effects=new \character\Effects(array(
					'id' => $this->id_effects,
				));
				$Effects->retrieve();
				return $Effects;
			}
			return false;
		}
		/**
		 * Return the effects display or false if id_effects is not defined
		 *
		 * @return string | bool
		 **/
		public function displayEffects()
		{
			if ($this->id_effects!==null)
			{
				return $this->retrieveEffects()->display();
			}
			return false;
		}
		/**
		 * Return the \character\Spells instance of the character or false if id_spells not defined
		 *
		 * @return \character\Spells | bool
		 **/
		public function retrieveSpells()
		{
			if ($this->spells!==null)
			{
				$Spells=new \character\Spells(array(
					'id' => $this->id_spells,
				));
				$Spells->retrieve();
				return $Spells;
			}
			return false;
		}
		/**
		 * Return the spells display or false if id_spells not defined
		 *
		 * @return string | bool
		 **/
		public function displaySpells()
		{
			if ($this->spells!==null)
			{
				return $this->retrieveSpells()->display();
			}
			return false;
		}
		/**
		 * Take an amount of pure damage
		 *
		 * @param int $damage Damage to take
		 *
		 * @return void
		 **/
		public function takeDamage($damage)
		{
			if ($this->retrieveAttributes()->canTake('PV', $damage))
			{
				$Attributes->changeAttr('PV', $Attributes->getAttr('PV')-$damage);
			}
			else
			{
				$Attributes->changeAttr('PV', 0);
				if ($this->state!==$this::STATE_DEAD)
				{
					$this->setState($this::STATE_DEAD);
				}
			}
		}
		/**
		 * Test if the character know a spell which can protect him to magic damage
		 *
		 * @return bool
		 **/
		public function canProtectMag()
		{
			$SpellManager=new \character\SpellManager(\core\DBFactory::MysqlConnection());
			return (bool)$SpellManager->getBy(array(
				'id_spells' => $this->getId_spells(),
				'type'      => 'magic protection',
				'cost'      => $this->retrieveAttributes()->getAttr('MANA'),
			), array(
				'id_spells' => '=',
				'type'      => '=',
				'cost'      => '<',
			);
		}
		/**
		 * End this turn for this character
		 *
		 * @return void
		 **/
		public function endTurn()
		{
			$Attributes=$this->retrieveAttributes();
			if ($Attributes->getAttr('PA')>0)
			{
				while ($Attributes->getAttr('PA')>0)
				{
					$Attributes->changeAttr('PV', $Attributes->getAttr('PV')+($Attributes->getMax('PV')/10)/$Attributes->getMax('PA'));
					$Attributes->changeAttr('MANA', $Attributes->getAttr('MANA')+($Attributes->getMax('MANA')/10)/$Attributes->getMax('PA'));
					$Attributes->changeAttr('PA', $Attributes->getAttr('PA')-1);
				}
			}
			else
			{
				$Attributes->change('PA', 0);
			}
			$this->setState('finish');
			$this->retrieveParty()->checkTurn();
		}
		/**
		 * Begin the turn for this character
		 *
		 * @return void
		 **/
		public function beginTurn()
		{
			$Attributes=$this->retrieveAttributes();
			if ($this->getState()==='ready')
			{
				$this->endTurn();
			}
			if ($this->getState()!=='dead')
			{
				if ($this->getState()==='finish')
				{
					$this->setState('ready');
					$Attributes->changeAttr('PA', $Attributes->getMax('PA'));
				}
				$this->retrieveEffects()->applyTurn();
			}
		}
	}
}

?>
