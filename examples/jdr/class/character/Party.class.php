<?php

namespace character;

class Party extends \core\Managed
{
	/* Attribute */

		/**
		 * Id of the party
		 *
		 * @var int
		 **/
		protected $id;
		/**
		 * Name of the party
		 *
		 * @var string
		 **/
		protected $name;
		/**
		 * Characters in the party
		 *
		 * @var array
		 **/
		protected $characters;

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
			 * characters accessor
			 *
			 * @return array
			 **/
			public function getCharacters()
			{
				return $this->characters;
			}

		/* Setter */

			/**
			 * id setter
			 *
			 * @param int $id Id of the party
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
			 * @param string $name Name of the party
			 *
			 * @return void
			 **/
			protected function setName($name)
			{
				$this->name=(string)$name;
			}
			/**
			 * characters setter
			 *
			 * @param array $characters Characters in the party
			 *
			 * @return void
			 **/
			protected function setCharacters($characters)
			{
				$this->$characters=$characters;
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
			 * characters display
			 *
			 * @return string
			 **/
			public function displayCharacters()
			{
				$display='';
				for ($characters as $character)
				{
					$display.=$character->display();
				}
				return $display;
			}

		/**
		 * Retrieve a party
		 *
		 * @param array $data Data to hydrate
		 *
		 * @return void
		 **/
		public function retrieve($data)
		{
			parent->retrieve($data);
			$this->retrieveCharacters();
		}
		/**
		 * Retrieve Characters
		 *
		 * @return void
		 **/
		public function retrieveCharacters()
		{
			$CharacterManager=new \character\CharacterManager(\core\DBFactory::MysqlConnection());
			return $results=$CharacterManager->retrieveBy(array(
				'id_party' => $this->getId(),
			));
		}
		/**
		 * Check if all characters are in a non-ready state and start a new turn if true
		 *
		 * @return bool
		 **/
		public function checkTurn()
		{
			for ($this->getCharacters() as $Character)
			{
				if ($Character->getState()==='ready')
				{
					return false;
				}
			}
			for ($this->getCharacters() as $Character)
			{
				$Character->beginTurn();
			}
			return true;
		}
}

?>
