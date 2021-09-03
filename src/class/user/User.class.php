<?php

namespace user;

/**
 * User of the site
 */
class User extends \core\Managed
{
	/**
	 * index of the used in the database
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * configurations of the user
	 *
	 * @var array
	 */
	protected $configurations;
	/**
	 * date of the registration of the user
	 *
	 * @var string
	 */
	protected $date_registration;
	/**
	 * date of the last login of the user
	 *
	 * @var string
	 */
	protected $date_login;
	/**
	 * nickname of the user
	 *
	 * @var string
	 */
	protected $nickname;
	/**
	 * notifications of the user
	 *
	 * @var array
	 */
	protected $notifications;
	/**
	 * password of the used
	 *
	 * @var \user\Password
	 */
	protected $password;
	/**
	 * roles of the user
	 *
	 * @var array
	 */
	protected $roles;
	/**
	 * check if the user can access a page
	 *
	 * @param \user\Page $page
	 *
	 * @return bool
	 */
	public function checkPermission(\user\Page $page)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['start'], array('user' => $this->get('id'), 'page' => $page->get('id')));
		foreach ($this->roles as $Role)
		{
			foreach ($Role->permissions as $Permission)
			{
				if ($Permission->get('id_route') === $page->get('id'))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['found'], array('user' => $this->get('id'), 'page' => $page->get('id')));
					return True;
				}
			}
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['checkPermission']['not_found'], array('user' => $this->get('id'), 'page' => $page->get('id')));
		return False;
	}
	/**
	 * delete definitely the user
	 *
	 * be cautious when using this command, references to an undefined user must be cleaned or managed
	 */
	public function remove()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['User']['remove']['start'], array('user' => $this->get('id')));
		$this->delete();
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['remove']['deleting_user'], array('user' => $this->get('id')));
	}
	/**
	 * display the user
	 *
	 * @return string
	 */
	public function display()
	{
		return $this->displayer('nickname') . '#' . $this->displayer('id');
	}
	/**
	 * check if the user has made a request before a time delta
	 *
	 * @param \DateInterval $interval Time delta
	 *
	 * @return bool
	 */
	public function isConnected($interval)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['isConnected']);

		$date = new \DateTime('now');
		$date->sub(new \DateInterval($interval));

		if ($this->get('date_login') != null)
		{
			$this->retrieve();
		}

		return $date < new \DateTime($this->get('date_login'));
	}
	/**
	 * retrieves the user
	 */
	public function retrieve()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieve']);

		parent::retrieve();
		$this->retrieveNotifications();
		$this->retrievePassword();
		$this->retrieveRoles();
	}
	/**
	 * retrieves the configurations of this user
	 */
	public function retrieveConfigurations()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveConfigurations']);

		$ConfigurationManager = new \user\ConfigurationManager();
		$this->set('configurations', $ConfigurationManager->retrieveBy(array(
			'id_user' => $this->get('id'),
		)));
	}
	/**
	 * retrieves the notifications of this user
	 */
	public function retrieveNotifications()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveNotifications']);

		$LinkNotificationUser = new \user\LinkNotificationUser();
		$this->set('notifications', $LinkNotificationUser->retrieveBy(array(
			'id_user' => $this->get('id'),
		), name_class: '\user\Notification', attributes_conversion: array(
			'id_notification' => 'id',
		)));
	}
	/**
	 * retrieves the password of this user
	 */
	public function retrievePassword()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrievePassword']);

		$PasswordManager = new \user\Password();
		$this->set('password', $PasswordManager->retrieveBy(array(
			'id' => $this->get('id'),
		)));
	}
	/**
	 * retrieves the roles of this user
	 */
	public function retrieveRoles()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['User']['retrieveRoles']);

		$LinkRoleUser = new \user\LinkRoleUser();
		$this->set('roles', $LinkRoleUser->retrieveBy(array(
			'id_user' => $this->get('id'),
		), name_class: '\user\Roles', attributes_conversion: array(
			'id_role' => 'id',
		)));
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
	public function setConfiguration($key, $value)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['setConfiguration']['start']);

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
					$ConfigurationManager->update($configuration, array(
						'id' => $configuration->get('id'),
					));
					$this->set('configurations', $configurations);
				}

				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['setConfiguration']['end']);

				return True;
			}
		}
		$Configuration = new \user\Configuration(array(
			'id_user' => $this->get('id'),
			'name'    => $key,
			'value'   => $value,
		));
		$Configuration->set('id', $ConfigurationManager->add($Configuration->table()));
		$configurations[] = $Configuration;
		$this->set('configurations', $configurations);

		return True;
	}
}

?>
