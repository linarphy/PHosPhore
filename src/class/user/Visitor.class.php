<?php

namespace user;

/**
 * Visitor of the website
 */
class Visitor extends \user\User
{
	/**
	 * if the user is authentifiate with a token
	 *
	 * @var bool
	 */
	protected bool $has_token = False;
	/**
	 * page of the user
	 *
	 * @var \user\Page
	 */
	protected ?\user\Page $page = null;
	/**
	 * connect the user (add $_SESSION, check password and $GLOBALS['Visitor'])
	 *
	 * @var bool
	 */
	public function connect() : bool
	{
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'connect', 'start'], $this);

		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['no_id']);
			return False;
		}
		if ($this->get('password') === null && $this->get('has_token') === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['no_password']);
			return False;
		}

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'connect', 'check'], $this);

		$UserManager = new \user\UserManager();
		if (!$UserManager->exist(['id' => $this->get('id')]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['invalid_id']);
			return False;
		}
		if ($this->get('token') === False)
		{
			if (!$this->get('password')->check())
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['bad_credential']);
				return False;
			}
		}

		$UserManager->update([ // update last time login in database
			'id' => $this->get('id'),
		], [
			'date_login' => \date($GLOBALS['config']['core']['format']['date']),
		]);
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'connect', 'update'], $this);

		/* Token auth */
		$Token = new \user\Token([
			'id_user' => $this->get('id'),
		]);
		$Token->create();
		$_SESSION['__login__']['selector'] = $Token->get('selector');
		$_SESSION['__login__']['validator'] = $Token->get('validator_clear');
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'connect', 'token'], $this);

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'connect', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['connect']['success']);
		return True;
	}
	/**
	 * disconnect the user
	 */
	public function disconnect()
	{
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'disconnect', 'start'], $this);
		unset($_SESSION);
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'disconnect', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['disconnect']);
	}
	/**
	 * load the page
	 *
	 * @param \route\Route $route Route to load
	 *
	 * @return \user\Page|null
	 */
	public function loadPage($route) : ?\user\Page
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['loadPage']['start']);
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'loadPage', 'start'], $this);

		if (!$this->checkPermission($this->get('page')))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Visitor']['loadPage']['no_permission']);

			throw new \Exception($GLOBALS['locale']['class']['user']['Visitor']['loadPage']['no_permission']);
		}

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'loadPage', 'load'], $this);
		$this->get('page')->load();

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'loadPage', 'end'], $this);
		return $this->get('page');
	}
	/** register a new user (need password and roles to be fullfilled, but not created)
	 *
	 * @return bool
	 */
	public function register() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['register']['start']);
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'register', 'start'], $this);
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

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'register', 'check'], $this);
		$this->add();

		$this->retrieve();

		$this->get('password')->set('id', $this->get('id'));
		$this->get('password')->hash();
		$this->get('password')->update();

		foreach ($this->get('roles') as $role)
		{
			$role->set('id_user', $this->get('id'));
			$role->add();
		}
		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'register', 'mysql'], $this);

		$GLOBALS['Hook']->load(['class', 'user', 'Visitor', 'register', 'end'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Visitor']['register']['end']);

		return True;
	}
}

?>
