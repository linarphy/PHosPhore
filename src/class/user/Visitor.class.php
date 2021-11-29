<?php

namespace user;

/**
 * Visitor of the website
 */
class Visitor extends \user\User
{
	/**
	 * page of the user
	 *
	 * @var \user\Page
	 */
	protected $page;
	/**
	 * connect the user (add $_SESSION, check password and $GLOBALS['Visitor'])
	 *
	 * @var bool
	 */
	public function connect()
	{
		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['no_id']);
			return False;
		}
		if ($this->get('password') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['no_password']);
			return False;
		}
		$UserManager = new \user\UserManager();
		if (!$UserManager->exist(array('id' => $this->get('id'))))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['invalid_id']);
			return False;
		}
		if (!$this->get('password')->check())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['bad_credential']);
			return False;
		}

		$UserManager->update(array( // update last time login in database
			'id' => $this->get('id'),
		), array(
			'date_login' => date($GLOBALS['config']['core']['format']['date']),
		));

		/* see https://stackoverflow.com/questions/3128985/php-login-system-remember-me-persistent-cookie/ */
		$_SESSION['user']['id'] = $this->get('id');
		$_SESSION['user']['password'] = $this->get('password');

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['success']);
		return True;
	}
	/**
	 * disconnect the user
	 */
	public function disconnect()
	{
		unset($_SESSION);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['disconnect']);
	}
	/**
	 * load the page
	 *
	 * @param \route\Route $route Route to load
	 *
	 * @return \user\Page|False
	 */
	public function loadPage($route)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['loadPage']['start']);

		$Page = new \user\Page(array(
			'id' => $route->get('id'),
		));

		if (!$this->checkPermission($route))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Visitor']['loadPage']['no_permission']);
			return False;
		}

		$Page->retrieve();
		$this->set('page', $Page);
		$Page->load();

		return $Page;
	}
	/** register a new user (need password and roles to be fullfilled, but not created)
	 *
	 * @return bool
	 */
	public function register()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['register']['start']);
		if ($this->get('password') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['register']['no_password']);
			return False;
		}
		if ($this->get('roles') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['register']['no_roles']);
			return False;
		}

		$this->set('id', $UserManager->add($this->table())['id']);
		$PasswordManager = new \user\PasswordManager();

		$this->get('password')->set('id', $this->get('id'));
		$PasswordManager->add($this->get('password')->table());

		$RoleManager = new \user\RoleManager();
		foreach ($this->get('roles') as $role)
		{
			$role->set('id', $this->get('id'));
			$RoleManager->add($role->table());
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['register']['end']);

		return True;
	}
}

?>
