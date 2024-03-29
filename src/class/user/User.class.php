<?php

namespace user;

/**
 * User of the site
 */
class User extends \core\Managed
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
	/**
	 * index of the used in the database
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * configurations of the user
	 *
	 * @var array
	 */
	protected ?array $configurations = null;
	/**
	 * date of the registration of the user
	 *
	 * @var string
	 */
	protected ?string $date_registration = null;
	/**
	 * date of the last login of the user
	 *
	 * @var string
	 */
	protected ?string $date_login = null;
	/**
	 * nickname of the user
	 *
	 * @var string
	 */
	protected ?string $nickname = null;
	/**
	 * notifications of the user
	 *
	 * @var array
	 */
	protected ?array $notifications = null;
	/**
	 * password of the used
	 *
	 * @var \user\Password
	 */
	protected ?\user\Password $password = null;
	/**
	 * roles of the user
	 *
	 * @var array
	 */
	protected ?array $roles = null;
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * check if the user can access a page
	 *
	 * @param \user\Page $page
	 *
	 * @return bool
	 */
	public function checkPermission(\user\Page $page) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['start'], ['user' => $this->get('id'), 'page' => $page->get('id')]);
		foreach ($this->roles as $Role)
		{
			foreach ($Role->getPermissions() as $Permission)
			{
				if ($Permission->get('id_route') === $page->get('id'))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['found'], ['user' => $this->get('id'), 'page' => $page->get('id')]);
					return True;
				}
			}
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['not_found'], ['user' => $this->get('id'), 'page' => $page->get('id')]);
		return False;
	}
	/**
	 * delete definitely the user
	 *
	 * be cautious when using this command, references to an undefined user must be cleaned or managed
	 */
	public function remove()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['User']['remove']['start'], ['user' => $this->get('id')]);
		$GLOBALS['Hook']::load(['class', 'user', 'User', 'remove', 'start'], $this);
		$this->delete();
		$GLOBALS['Hook']::load(['class', 'user', 'User', 'remove', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['remove']['deleting_user'], ['user' => $this->get('id')]);
	}
	/**
	 * display the user
	 *
	 * @param string $attribute Attribute to display (entire object if null).
	 *                          Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		if ($attribute === null)
		{
			return $this->display('nickname') . '#' . $this->display('id');
		}
		return $this->display_($attribute);
	}
	/**
	 * check if the user has made a request before a time delta
	 *
	 * @param \DateInterval $interval Time delta
	 *
	 * @return bool
	 */
	public function isConnected(\DateInterval $interval) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['isConnected']);

		$date = new \DateTime('now');
		$date->sub(new \DateInterval($interval));

		if ($this->get('date_login') !== null)
		{
			$this->retrieve();
		}

		return $date < new \DateTime($this->get('date_login'));
	}
	/**
	 * retrieves the user
	 *
	 * @return \user\User
	 */
	public function retrieve() : self
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieve']);
		$GLOBALS['Hook']::load(['class', 'user', 'User', 'retrieve', 'start'], $this);

		parent::retrieve();
		$this->retrieveConfigurations();
		$this->retrieveNotifications();
		$this->retrievePassword();
		$this->retrieveRoles();

		$GLOBALS['Hook']::load(['class', 'user', 'User', 'retrieve', 'end'], $this);
		return $this;
	}
	/**
	 * retrieves the configurations of this user
	 *
	 * @return array
	 */
	public function retrieveConfigurations() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveConfigurations']);

		if ($this->get('configurations') === null)
		{
			$configurations = [];
		}
		else
		{
			$configurations = $this->get('configurations');
		}

		$ConfigurationManager = new \user\ConfigurationManager();
		$this->set('configurations', \array_merge($configurations, $ConfigurationManager->retrieveBy([
			'id_user' => $this->get('id'),
		])));

		return $this->get('configurations');
	}
	/**
	 * retrieves the notifications of this user
	 *
	 * @return array
	 */
	public function retrieveNotifications() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveNotifications']);

		if ($this->get('notifications') === null)
		{
			$notifications = [];
		}
		else
		{
			$notifications = $this->get('notifications');
		}

		$LinkNotificationUser = new \user\LinkNotificationUser();
		$this->set('notifications', \array_merge($notifications, $LinkNotificationUser->retrieveBy([
			'id_user' => $this->get('id'),
		], class_name: '\user\Notification', attributes_conversion: [
			'id_notification' => 'id',
		])));

		return $this->get('notifications');
	}
	/**
	 * retrieves the password of this user
	 *
	 * @return \user\Password
	 */
	public function retrievePassword() : \user\Password
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrievePassword']);

		$PasswordManager = new \user\PasswordManager();
		$results = $PasswordManager->retrieveBy([
			'id' => $this->get('id'),
		]);
		$Password = $results[0];

		if ($this->get('password') !== null)
		{
			$Password->set('password_clear', $this->get('password')->get('password_clear'));
		}

		$this->set('password', $Password);

		return $this->get('password');
	}
	/**
	 * retrieves the roles of this user
	 *
	 * @return array
	 */
	public function retrieveRoles() : array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveRoles']);

		if ($this->get('roles') === null)
		{
			$roles = [];
		}
		else
		{
			$roles = $this->get('roles');
		}

		$LinkRoleUser = new \user\LinkRoleUser();
		$results = $LinkRoleUser->getBy([
			'id_user' => $this->get('id'),
		]);

		$Roles = [];
		foreach ($results as $result)
		{
			$Roles[] = new \user\Role([
				'name_role' => $result['name_role'],
			]);
		}
		$this->set('roles', \array_merge($roles, $Roles));

		return $this->get('roles');
	}
	/**
	 * Add a value to user configuration definitively (can replace)
	 *
	 * @param string $key New value key
	 *
	 * @param mixed $value New value
	 *
	 * @return True
	 */
	public function setConfiguration(string $key, mixed $value) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['setConfiguration']['start']);

		$this->retrieveConfigurations();

		$configurations = $this->get('configurations');
		$ConfigurationManager = new \user\ConfigurationManager();

		foreach ($configurations as $configuration)
		{
			if ($configuration->get('name' === $key))
			{
				$configuration = $configurations[$key];

				if ($value !== $configuration->get('value'))
				{
					$configuration->set('value', $value);
					$ConfigurationManager->update($configuration, [
						'id' => $configuration->get('id'),
					]);
					$this->set('configurations', $configurations);
				}

				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['setConfiguration']['end_replace']);

				return True;
			}
		}
		$Configuration = new \user\Configuration([
			'id_user' => $this->get('id'),
			'name'    => $key,
			'value'   => $value,
		]);
		$Configuration->set('id', $ConfigurationManager->add($Configuration->table()));
		$configurations[] = $Configuration;
		$this->set('configurations', $configurations);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['setConfiguration']['end_add']);

		return True;
	}
}

?>
