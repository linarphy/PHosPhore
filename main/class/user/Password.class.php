<?php

namespace user;

/**
 * Password of an user
 *
 * @author gugus2000
 **/
class Password extends \core\Managed
{
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
			new \exception\Notice($GLOBALS['lang']['class']['user']['password']['verif'], 'password');
			if ($this->getPassword_hashed())
			{
				$hash=$this->getPassword_hashed();
				$options=array(
					'cost' => $GLOBALS['config']['hash_cost'],
				);
				if (password_verify($password, $hash))
				{
					new \exception\Notice($GLOBALS['lang']['class']['user']['password']['password_match'], 'password');
				    if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options))
				    {
				    	new \exception\Warning($GLOBALS['lang']['class']['user']['password']['need_rehash'], 'password');
				        $this->setPassword_hashed(password_hash($password, PASSWORD_DEFAULT, $options));
				        $PasswordManager=$this->Manager();
				        $PasswordManager->update(array(
				        	'password_hashed' => $this->getPassword_hashed(),
				        ), $this->getId());
				        new \exception\Notice($GLOBALS['lang']['class']['user']['password']['rehashed'], 'password');
				    }
				    $this->setPassword_clear($password);
				    return True;
				}
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['user']['password']['password_mismatch'], 'password');
				}
				return False;
			}
			else
			{
				new \exception\Error($GLOBALS['lang']['class']['user']['password']['no_hashed_password'], 'password');
			}
			return False;
		}
		/**
		 * Hash the clear password and set it as hashed password
		 *
		 * @return void
		 */
		public function hash()
		{
			$options=array(
				'cost' => $GLOBALS['config']['hash_cost'],
			);
			$this->setPassword_hashed(password_hash($this->getPassword_clear(), PASSWORD_DEFAULT, $options));
		}
} // END class Password extends \core\Managed

?>
