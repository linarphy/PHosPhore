<?php

namespace user;

/**
 * Website visitor
 *
 * @author gugus2000
 **/
class Visitor extends \user\User
{
	/* Attribute */

		/**
		* Page viewed by the user
		*
		* @var Page
		*/
		protected $page;
		/**
		* User configurations
		* 
		* @var array
		*/
		protected $configurations;

	/* Method */

		/* Getter */

			/**
			* page accessor
			*
			* @return Page
			*/
			public function getPage()
			{
				return $this->page;
			}
			/**
			* configurations accessor
			* 
			* @return array
			*/
			public function getConfigurations()
			{
				return $this->configurations;
			}

		/* Setter */

			/**
			* page setter
			*
			* @param Page $page Page viewed by the user
			*
			* @return void
			*/
			protected function setPage($page)
			{
				$this->page=$page;
			}
			/**
			* configurations setter
			*
			* @param array $configurations User configurations
			* 
			* @return void
			*/
			protected function setConfigurations($configurations)
			{
				$this->configurations=$configurations;
			}

		/* Display */

			/**
			* page display
			*
			* @return string
			*/
			public function displayPage()
			{
				return htmlspecialchars((string)$this->page->display());
			}
			/**
			* configurations display
			* 
			* @return string
			*/
			public function displayConfigurations()
			{
				$display='';
				foreach ($this->configurations as $Configuration)
				{
					$display.=$Configuration->display().'<br />';
				}
				return $display;
			}

		/**
		* Adding an element to the configurations array
		*
		* @param string $index Index to insert
		*
		* @param mixed $value Value to be inserted
		* 
		* @return void
		*/
		public function setConfiguration($index, $value)
		{
			$this->configurations[$index]=$value;
		}
		/**
		* Accessor of a configuration value associated with an index
		*
		* @param string $index Value Index
		* 
		* @return mixed
		*/
		public function getConfiguration($index)
		{
			return $this->configurations[$index];
		}
		/**
		* Verifies that the user has permission to view the page
		*
		* @return bool
		*/
		public function verifPermission()
		{
			return $this->getRole()->existPermission(array('application' => $this->getPage()->getApplication(), 'action' => $this->getPage()->getAction()));
		}
		/**
		* Connects the visitor
		* 
		* @param string $password Visitor's password
		*
		* @return bool
		*/
		public function connection($password)
		{
			$this->retrieve();
			if ($this->getPassword()->verif($password))
			{
				$utilisateurManager=$this->Manager();
				$date=date($GLOBALS['config']['db_date_format']);
				$utilisateurManager->update(array(
					'date_login' => $date,
				), $this->getId());
				$this->setDate_login($date);
				$_SESSION['password']=$this->getPassword()->getPassword_clear();
				$_SESSION['nickname']=$this->getNickname();
				$_SESSION['id']=$this->getId();
				return True;
			}
			else
			{
				return False;
			}
		}
		/**
		* Disconnects the visitor
		*
		* @return void
		*/
		public function disconnection()
		{
			if ($this->getPassword()->verif($this->getPassword()->getPassword_clear()))
			{
				$utilisateurManager=$this->Manager();
				$date=date($GLOBALS['config']['db_date_format']);
				$utilisateurManager->update(array(
					'date_login' => $date,
				), $this->getId());
				unset($_SESSION['password']);
				unset($_SESSION['nickname']);
				unset($_SESSION['id']);
			}
		}
		/**
		* Visitor Registration
		*
		* @param string $password Visitor's password
		* 
		* @param string $role_name Name of the visitor's role
		*
		* @return void
		*/
		public function registration($password, $role_name)
		{
			$VisitorManager=$this->Manager();
			$VisitorManager->add(array(
				'nickname'          => $this->getNickname(),
				'avatar'            => $this->getAvatar(),
				'date_registration' => $this->getDate_registration(),
				'date_login'        => $this->getDate_login(),
				'banned'            => (int)$this->getBanned(),
				'email'             => $this->getEmail(),
			));
			$this->setId($VisitorManager->getIdBy(array(
				'nickname'          => $this->getNickname(),
				'avatar'            => $this->getAvatar(),
				'date_registration' => $this->getDate_registration(),
				'date_login'        => $this->getDate_login(),
				'banned'            => (int)$this->getBanned(),
				'email'             => $this->getEmail(),
			)));
			$this->setPassword(new \user\Password(array(
				'id'             => $this->getId(),
				'password_clear' => $password,
			)));
			$this->setRole(new \user\Role(array(
				'id'        => $this->getId(),
				'role_name' => $role_name,
			)));
			$this->getRole()->retrievePermissions();
			$RoleManager=$this->getRole()->Manager();
			$RoleManager->update(array(
				'role_name' => $this->getRole()->getRole_name(),
			), $this->getId());
			$PasswordManager=$this->getPassword()->Manager();
			$this->getPassword()->hash();
			$PasswordManager->update(array(
				'password_hashed' => $this->getPassword()->getPassword_hashed(),
			), $this->getId());
		}
		/**
		* Updates the user
		*
		* @return void
		*/
		public function update()
		{
			$Manager=$this->Manager();
			$Manager->update(array(
				'avatar' => $this->getAvatar(),
				'banned' => (int)$this->getBanned(),
				'email'  => $this->getEmail(),
			), $this->getId());
		}
		/**
		* Deletes the user /!\ USE WITH CAUTION
		*
		* @return void
		*/
		public function delete()
		{
			$Manager=$this->Manager();
			$Manager->delete($this->getId());
		}
		/**
		* Load page
		*
		* @param array $parameters Array page requested by the visitor
		* 
		* @return string
		*/
		public function loadPage($parameters)
		{
			global $Visitor, $Router;
			$this->setConfigurations($GLOBALS['config']['user_config']);
			$ConfigurationManager=new \user\ConfigurationManager(\core\DBFactory::MysqlConnection());
			if (isset($parameters[$GLOBALS['config']['route_parameter']]['lang']))
			{
				if (in_array($parameters[$GLOBALS['config']['route_parameter']]['lang'],array_keys($GLOBALS['config']['general_langs'])))
				{
					if ($this->getId()==$GLOBALS['config']['guest_id'])
					{
						$_SESSION['lang']=$parameters[$GLOBALS['config']['route_parameter']]['lang'];
					}
					else
					{
						if ($ConfigurationManager->existBy(array(
							'id_user' => $this->getId(),
							'name'    => 'lang',
						)))
						{
							$id=$ConfigurationManager->getIdBy(array(
								'id_user' => $this->getId(),
								'name'    => 'lang',
							));
							$ConfigurationManager->update(array(
								'value' => $parameters[$GLOBALS['config']['route_parameter']]['lang'],
							), $id);
						}
						else
						{
							$ConfigurationManager->add(array(
								'id_user' => $this->getId(),
								'name'    => 'lang',
								'value'   => $parameters[$GLOBALS['config']['route_parameter']]['lang'],
							));
						}
					}
				}
			}
			if ($this->getId()==$GLOBALS['config']['guest_id'])
			{
				foreach (array_keys($this->getConfigurations()) as $configuration_name)
				{
					if (isset($_SESSION[$configuration_name]))
					{
						$this->setConfiguration($configuration_name, $_SESSION[$configuration_name]);
					}
				}
			}
			else
			{
				$configurations=$ConfigurationManager->getBy(array(
					'id_user' => $this->getId(),
				), array(
					'id_user' => '=',
				));
				foreach ($configurations as $configuration)
				{
					$Configuration=new \user\Configuration($configuration);
					$this->setConfiguration($Configuration->getName(), $Configuration->getValue());
				}
			}
			require $GLOBALS['config']['path_lang'].$this->getConfiguration('lang').'.lang.php';
			if($this->getRole()->existPermission($parameters))	// Permission accordée
			{
				$this->setPage(new \user\Page($parameters));
				if (stream_resolve_include_path($this->getPage()->getPath()))
				{
					include($this->getPage()->getPath());
					return $this->getPage()->display();
				}
				else
				{
					throw new \Exception($GLOBALS['lang']['class_user_visitor_no_file']);
				}
			}
			else
			{
				throw new \Exception($GLOBALS['lang']['class_user_visitor_no_perm']);
			}
		}
		/**
		 * Checks if at least one link in the list is open for access by the visitor
		 *
		 * @param array $links Links to check
		 *
		 * @return bool
		 *
		 **/
		function verifLinks($links)
		{
			foreach ($links as $index => $link)
			{
				if ($this->getRole()->existPermission($link))
				{
					return True;
				}
			}
			return False;
		}
		/**
		* Create a \user\Visitor instance
		*
		* @param array $attributes Object attributes
		* 
		* @return mixed
		*/
		public function __construct($attributes)
		{
			parent::__construct($attributes);
			if ($this->getId()!==null)
			{
				$this->retrieve();
			}
		}
} // END class Visitor extends \user\User

?>