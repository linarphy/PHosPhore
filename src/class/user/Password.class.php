<?php

namespace user;

/**
 * User's password
 */
class Password extends \core\Managed
{
	/**
	 * Index of the password in the database
	 *
	 * @var int
	 */
	protected int $id;
	/**
	 * Clear password of the user /!\ warning
	 *
	 * @var string
	 */
	protected ?string $password_clear = null;
	/**
	 * Hashed password of the user
	 *
	 * @var string
	 */
	protected ?string $password_hashed = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id'              => 'int',
		'password_clear'  => 'string',
		'password_hashed' => 'string',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * Check the validity of the clear password in relation to the one hashed stored in the database
	 *
	 * @return bool
	 */
	public function check() : bool
	{
		if ($this->get('password_clear') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Password']['check']['no_clear']);

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Password']['check']['loading_hashed']);

		if ($this->retrieve()->get('password_hashed') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Password']['check']['cannot_retrieve_hashed']);

			return False;
		}

		if (\password_verify($this->get('password_clear'), $this->get('password_hashed')))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Password']['check']['verified']);

			if (\password_needs_rehash($this->get('password_hashed'), $GLOBALS['config']['class']['user']['Password']['algorithm'], $GLOBALS['config']['class']['user']['Password']['options']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Password']['check']['need_rehash']);

				$this->set('password_hashed', \password_hash($this->get('password_clear'), $GLOBALS['config']['class']['user']['Password']['algorithm'], $GLOBALS['config']['class']['user']['Password']['options']));

				$this->manager()->update([
					'password_hashed' => $this->get('password_hashed'),
				], $this->get('id'));
			}

			return True;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Password']['check']['bad_credential']);

		return False;
	}
	/**
	 * Display the password a safe way
	 *
	 * @param ?string $attribue Attribute to display (entire object if null).
	 *                          Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		if ($attribute === null)
		{
			return $this->display('password_hashed');
		}
		return parent::display($attribute);
	}
	/**
	 * Display the clear password
	 *
	 * @return string
	 */
	protected function displayPassword_clear() : string
	{
		return \htmlspecialchars($this->get('password_clear'));
	}
	/**
	 * Return the clear password
	 *
	 * @return string
	 */
	protected function getPassword_clear() : string
	{
		return $this->password_clear;
	}
	/**
	 * Hash password_clear and affect it to password_hashed
	 */
	public function hash()
	{
		$this->set('password_hashed', \password_hash($this->get('password_clear'), $GLOBALS['config']['class']['user']['Password']['algorithm'], $GLOBALS['config']['class']['user']['Password']['options']));
	}
}

?>
