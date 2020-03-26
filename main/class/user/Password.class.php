<?php

namespace user;

/**
 * Password of an user
 *
 * @author gugus2000
 **/
class Password extends \core\Managed
{
	/* Constant */

		/**
		* Hash cost
		*
		* @var int
		*/
		const HASH_COST=6;

	/* Attribute */

		/**
		* Id of the user
		*
		* @var int
		*/
		protected $id;
		/**
		* Clear password
		*
		* @var string
		*/
		protected $password_clear;
		/**
		* Password hashed
		*
		* @var string
		*/
		protected $password_hashed;

	/* Method */

		/* Getter */

			/**
			* id accessor
			*
			* @return int
			*/
			public function getId()
			{
				return $this->id;
			}
			/**
			* password_clear accessor
			*
			* @return string
			*/
			public function getPassword_clear()
			{
				return $this->password_clear;
			}
			/**
			* password_hashed accessor
			*
			* @return string
			*/
			public function getPassword_hashed()
			{
				return $this->password_hashed;
			}

		/* Setter */

			/**
			* id setter
			*
			* @param int $id Id of the user
			*
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* password_clear setter
			*
			* @param string $password_clear Clear password
			*
			* @return void
			*/
			protected function setPassword_clear($password_clear)
			{
				$this->password_clear=(string)$password_clear;
			}
			/**
			* password_hashed setter
			*
			* @param string $password_hashed Password hashed
			*
			* @return void
			*/
			protected function setPassword_hashed($password_hashed)
			{
				$this->password_hashed=(string)$password_hashed;
			}

		/* Display */

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
			* password_clear display
			*
			* @return string
			*/
			public function displayPassword_clear()
			{
				return htmlspecialchars((string)$this->password_clear);
			}
			/**
			* password_hashed display
			*
			* @return string
			*/
			public function displayPassword_hashed()
			{
				return htmlspecialchars((string)$this->password_hashed);
			}

		/**
		* Display the Password
		* 
		* @return string
		*/
		public function display()
		{
			return $this->displayPassword_hashed();
		}
		/**
		* Checks if the password in plain text matches the hashed password
		* 
		* @param string $password Verify plain text password
		*
		* @return bool
		*/
		public function verif($password)
		{
			if ($this->getPassword_hashed())
			{
				$hash=$this->getPassword_hashed();
				$options=array(
					'cost' => $this::HASH_COST,
				);
				if (password_verify($password, $hash))
				{
				    if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options))
				    {
				        $this->setPassword_hashed(password_hash($password, PASSWORD_DEFAULT, $options));
				        $PasswordManager=$this->Manager();
				        $PasswordManager->update(array(
				        	'password_hashed' => $this->getPassword_hashed(),
				        ), $this->getId());
				    }
				    $this->setPassword_clear($password);
				    return True;
				}
				return False;
			}
			return False;
		}
} // END class Password extends \core\Managed

?>