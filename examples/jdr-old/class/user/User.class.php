<?php

namespace user;

/**
 * User of this website
 *
 * @author gugus2000
 **/
class User extends \core\Managed
{
	/* Attribute */

		/**
		* Id of the user
		*
		* @var int
		*/
		protected $id;
		/**
		* Nickname of the user
		*
		* @var string
		*/
		protected $nickname;
		/**
		* Password of the user
		*
		* @var \user\Password
		*/
		protected $password;
		/**
		* Name of the avatar file of the user
		*
		* @var string
		*/
		protected $avatar;
		/**
		* Date of user registration
		*
		* @var string
		*/
		protected $date_registration;
		/**
		* Date of last user login
		*
		* @var string
		*/
		protected $date_login;
		/**
		* User status
		*
		* @var bool
		*/
		protected $banned;
		/**
		* Role of the user
		*
		* @var \user\Role
		*/
		protected $role;
		/**
		* User's e-mail address
		*
		* @var string
		*/
		protected $email;

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
			* nickname accessor
			*
			* @return string
			*/
			public function getNickname()
			{
				return $this->nickname;
			}
			/**
			* password accessor
			*
			* @return \user\Password
			*/
			public function getPassword()
			{
				return $this->password;
			}
			/**
			* avatar accessor
			*
			* @return string
			*/
			public function getAvatar()
			{
				return $this->avatar;
			}
			/**
			* date_registration accessor
			*
			* @return string
			*/
			public function getDate_registration()
			{
				return $this->date_registration;
			}
			/**
			* date_login accessor
			*
			* @return string
			*/
			public function getDate_login()
			{
				return $this->date_login;
			}
			/**
			* Banned accessor
			*
			* @return bool
			*/
			public function getBanned()
			{
				return $this->banned;
			}
			/**
			* role accessor
			*
			* @return \user\Role
			*/
			public function getRole()
			{
				return $this->role;
			}
			/**
			* email accessor
			*
			* @return string
			*/
			public function getEmail()
			{
				return $this->email;
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
			* nickname setter
			*
			* @param string $nickname Nickname of the user
			*
			* @return void
			*/
			protected function setNickname($nickname)
			{
				$this->nickname=(string)$nickname;
			}
			/**
			* password setter
			*
			* @param \user\Password $password Password of the user
			*
			* @return void
			*/
			protected function setPassword($password)
			{
				$this->password=$password;
			}
			/**
			* avatar setter
			*
			* @param string $avatar Name of the avatar file of the user
			*
			* @return void
			*/
			protected function setAvatar($avatar)
			{
				$this->avatar=(string)$avatar;
			}
			/**
			* date_registration setter
			*
			* @param string $date_registration Date of user registration
			*
			* @return void
			*/
			protected function setDate_registration($date_registration)
			{
				$this->date_registration=(string)$date_registration;
			}
			/**
			* date_login setter
			*
			* @param string $date_login Date of last user login
			*
			* @return void
			*/
			protected function setDate_login($date_login)
			{
				$this->date_login=(string)$date_login;
			}
			/**
			* banned setter
			*
			* @param bool $vanned User status
			*
			* @return void
			*/
			protected function setBanned($banned)
			{
				$this->banned=(bool)$banned;
			}
			/**
			* role setter
			*
			* @param \user\Role $role Role of the user
			*
			* @return void
			*/
			protected function setRole($role)
			{
				$this->role=$role;
			}
			/**
			* email setter
			*
			* @param string $email User's e-mail address
			*
			* @return void
			*/
			protected function setEmail($email)
			{
				$this->email=$email;
			}

		/* Display */

			/**
			* Display of id
			*
			* @return string
			*/
			public function displayId()
			{
				return htmlspecialchars((string)$this->id);
			}
			/**
			* Display of nickname
			*
			* @return string
			*/
			public function displayNickname()
			{
				return htmlspecialchars((string)$this->nickname);
			}
			/**
			* Display of password
			*
			* @return string
			*/
			public function displayPassword()
			{
				return htmlspecialchars((string)$this->password->display());
			}
			/**
			* Display of avatar
			*
			* @return string
			*/
			public function displayAvatar()
			{
				return htmlspecialchars((string)$this->avatar);
			}
			/**
			* Display of date_registration
			*
			* @return string
			*/
			public function displayDate_registration()
			{
				return htmlspecialchars((string)$this->date_registration);
			}
			/**
			* Display of date_login
			*
			* @return string
			*/
			public function displayDate_login()
			{
				return htmlspecialchars((string)$this->date_login);
			}
			/**
			* Display of banned
			*
			* @return string
			*/
			public function displayBanned()
			{
				return htmlspecialchars((string)$this->banned);
			}
			/**
			* Display of role
			*
			* @return string
			*/
			public function displayRole()
			{
				return htmlspecialchars((string)$this->role->display());
			}
			/**
			* Display of email
			*
			* @return string
			*/
			public function displayEmail()
			{
				return htmlspecialchars((string)$this->email);
			}

		/**
		* Display date_registration with a particular format
		*
		* @param string $format Date display format
		*
		* @return string
		*/
		public function afficherDate_registrationFormat($format)
		{
			return date($format, strtotime($this->date_registration));
		}
		/**
		* Display date_login with a particular format
		*
		* @param string $format Date display format
		*
		* @return string
		*/
		public function afficherDate_loginFormat($format)
		{
			return date($format, strtotime($this->date_login));
		}
		/**
		* Converts the user object to a readable string
		*
		* @return string
		*/
		public function display()
		{
			return $this->displayNickname();
		}
		/**
		* Checks if the user is logged in
		*
		* @param string $interval Time interval defining whether a user is logged in (in the format of \DateInterval)
		* 
		* @return bool
		*/
		public function isConnected($interval='PT5M')
		{
			$Manager=$this->Manager();
			$date=new \DateTime(date($GLOBALS['config']['db_date_format']));
			$date->sub(new \DateInterval($interval));
			$data=$Manager->getBy(array(
				'date_login' => $date->format($GLOBALS['config']['db_date_format']),
				'id'         => $this->getId(),
			), array(
				'date_login' => '>=',
				'id'         => '=',
			));
			return (bool)$data;
		}
		/**
		* Retrieve the password of the user
		*
		* @return void
		*/
		public function retrievePassword()
		{
			if ($this->getId())
			{
				$Password=new \user\Password(array(
					'id' => $this->getId(),
				));
				$Password->retrieve();
				$this->setPassword($Password);
			}
		}
		/**
		* Retrieve the role of the user
		*
		* @return void
		*/
		public function retrieveRole()
		{
			if ($this->getId())
			{
				$Role=new \user\Role(array(
					'id' => $this->getId(),
				));
				$Role->retrieve();
				$this->setRole($Role);
			}
		}
		/**
		* Retrieve a user with his id or nickname
		*
		* @return void
		*/
		public function retrieve()
		{
			$UserManager=$this->Manager();
			if ($this->getId())
			{
				$this->get($this->getId());
			}
			else if ($this->getNickname())
			{
				$this->setId($UserManager->getIdBy(array(
					'nickname' => $this->getNickname(),
				)));
				$this->get($this->getId());
			}
			$this->retrieveRole();
			$this->retrievePassword();
		}
		/**
		* Retrieves notifications to be seen by the user
		*
		* @return array
		*/
		public function retrieveNotifications()
		{
			$Linked=new \user\LinkNotificationUser(\core\DBFactory::MysqlConnection());
			$results=$Linked->get('id_user', $this->getId());
			$notifications=array();
			foreach ($results as $key => $resultat)
			{
				$notification=new \user\Notification(array(
					'id' => $resultat['id_notification'],
				));
				$notification->retrieve();
				$notifications[]=$notification;
			}
			return $notifications;
		}
		/**
		* Checks if the user is the author or has permission to edit or delete an object.
		*
		* @param \core\Managed $Object Object to be checked for editability
		* 
		* @return bool
		*/
		public function authorizationModification($Object)
		{
			if (method_exists($Object, 'retrieveAuthor'))
			{
				return $this->identical($Object->retrieveAuthor()) || $this->isAdmin($Object);
			}
			return False;
		}
		/**
		* Checks if the user has permission to edit or delete an object
		*
		* @param \core\Managed Object Object to be checked
		* 
		* @return bool
		*/
		public function isAdmin($Object)
		{
			return $this->getRole()->existPermission(array('application' => $GLOBALS['config']['application_modification'], 'action' => get_class($Object)));
		}
} // END class User extends \core\Managed

?>