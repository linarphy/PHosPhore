<?php

namespace character;

/**
 * An effect for a character
 *
 * @package jdr
 * @author gugus
 **/
class Effect extends \core\Managed
{
	/* Constant */

		/**
		 * Bleeding type
		 *
		 * @var string
		 **/
		const TYPE_BLEEDING='bleeding';
		/**
		 * On fire type
		 *
		 * @var string
		 **/
		const TYPE_ON_FIRE='on fire';
		/**
		 * On ice type
		 *
		 * @var string
		 **/
		const TYPE_ON_ICE='on ice';
		/**
		 * Money type
		 *
		 * @var string
		 **/
		const TYPE_MONEY='money';
		/**
		 * Stun type
		 *
		 * @var string
		 **/
		const TYPE_STUN='stun';
		/**
		 * Poison type
		 *
		 * @var string
		 **/
		const TYPE_POISON='poison';
		/**
		 * Critical type
		 *
		 * @var string
		 **/
		const TYPE_CRITICAL='critical';
		/**
		 * Fire resistance type
		 *
		 * @var string
		 **/
		const TYPE_FIRE_RESISTANCE='fire resistance';
		/**
		 * Ice resistance type
		 *
		 * @var string
		 **/
		const TYPE_ICE_RESISTANCE='ice resistance';
		/**
		 * Earth resistance type
		 *
		 * @var string
		 **/
		const TYPE_EARTH_RESISTANCE='earth resistance';
		/**
		 * Water resistance type
		 *
		 * @var string
		 **/
		const TYPE_WATER_RESISTANCE='water resistance';
		/**
		 * Lava resistance type
		 *
		 * @var string
		 **/
		const TYPE_LAVA_RESISTANCE='lava resistance';
		/**
		 * Shadow resistance type
		 *
		 * @var string
		 **/
		const TYPE_SHADOW_RESISTANCE='shadow resistance';
		/**
		 * Light resistance type
		 *
		 * @var string
		 **/
		const TYPE_LIGHT_RESISTANCE='light resistance';

	/* Attribute */

		/**
		 * Id of the effect for the character
		 *
		 * @var int
		 **/
		protected $id;
		/**
		 * Id of the character which has the effect
		 *
		 * @var int
		 **/
		protected $id_character;
		/**
		 * Type of the effect for the character
		 *
		 * @var string
		 **/
		protected $type;
		/**
		 * Turns for effect wich has a duration
		 *
		 * @var int
		 **/
		protected $turns;
		/**
		 * Value of the effect (parameter)
		 *
		 * @var mixed
		 **/
		protected $value;

	/* Method */

		/* Getter */

			/**
			 * id getter
			 *
			 * @return int
			 **/
			public function getId()
			{
				return $this->id;
			}
			/**
			 * id_character getter
			 *
			 * @return int
			 **/
			public function getId_character()
			{
				return $this->id_character;
			}
			/**
			 * type getter
			 *
			 * @return string
			 **/
			public function getType()
			{
				return $this->type;
			}
			/**
			 * turns getter
			 *
			 * @return int
			 **/
			public function getTurns()
			{
				return $this->turns;
			}
			/**
			 * value getter
			 *
			 * @return mixed
			 **/
			public function getValue()
			{
				return $this->value;
			}

		/* Setter */

			/**
			 * id setter
			 *
			 * @param int $id Id of the effect
			 *
			 * @return void
			 **/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			 * id_character setter
			 *
			 * @param int $id_character Id of the character which has the effect
			 *
			 * @return void
			 **/
			protected function setId_character($id_character)
			{
				$this->id_character=(int)$id_character;
			}
			/**
			 * type setter
			 *
			 * @param string $type Type of the effect
			 *
			 * @return void
			 **/
			protected function setType($type)
			{
				$this->type=(string)$type;
			}
			/**
			 * turns setter
			 *
			 * @param int $turns Turns for effect wich has a duration
			 *
			 * @return void
			 **/
			protected function setTurns($turns)
			{
				$this->turns=(int)$turns;
			}
			/**
			 * value setter
			 *
			 * @param mixed $value Value of the effect
			 *
			 * @return void
			 **/
			protected function setValue($value)
			{
				$this->value=$value;
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
			 * id_character display
			 *
			 * @return string
			 **/
			public function displayId_character()
			{
				return htmlspecialchars((string)$this->id_character);
			}
			/**
			 * type display
			 *
			 * @return string
			 **/
			public function displayType()
			{
				return htmlspecialchars((string)$this->type);
			}
			/**
			 * turns display
			 *
			 * @return string
			 **/
			public function displayTurns()
			{
				return htmlspecialchars((string)$this->turns);
			}
			/**
			 * value display
			 *
			 * @return string
			 **/
			public function displayValue()
			{
				return htmlspecialchars((string)$this->value);
			}

		/**
		 * Effect display
		 *
		 * @return string
		 **/
		public function display()
		{
			return $this->displayType();
		}
		/**
		 * Execute the effect
		 *
		 * @return void
		 **/
		public function execute()
		{
			switch ($this->type)
			{
				case $this::TYPE_BLEEDING:
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					$Character->takeDamage($this->value);
					break;
				case $this::TYPE_ON_FIRE:
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					$Character->takeDamage($value);
					break;
				case $this::TYPE_ON_ICE():
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					$Character->takeDamage($value);
					break;
				case $this::TYPE_MONEY():
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					$Character->getInventory()->addItem($this->value, new \item\misc\IST);
					break;
				case $this::TYPE_STUN:
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					break;
				case $this::TYPE_POISON:
					$Character=new \character\Character(array(
						'id' => $this->id_character,
					));
					$Character->retrieve();
					$Character->takeDamage($value);
					break;
				case default:
					break;
			}
			$this->passTurn();
		}
}

?>
