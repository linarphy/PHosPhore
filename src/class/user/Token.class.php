<?php

namespace user;

/**
 * A temporary token to maintain an user connection
 */
class Token extends \core\Managed
{
	/**
	 * expiration date of the token
	 *
	 * @var string
	 */
	protected ?string $date_expiration = null;
	/**
	 * user id linked to the token
	 *
	 * @var int
	 */
	protected int $id_user;
	/**
	 * selector, which act like a temporary nickname (stored in session)
	 *
	 * @var string
	 */
	protected string $selector;
	/**
	 * validator, which act like a temporary password (stored in session)
	 *
	 * @var string
	 */
	protected ?string $validator_clear = null;
	/**
	 * hashed validator, which act like a temporary hashed validator
	 *
	 * @var string
	 */
	protected ?string $validator_hashed = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'date_expiration'  => 'string',
		'id_user'          => 'int',
		'selector'         => 'string',
		'validator_clear'  => 'string',
		'validator_hashed' => 'string',
	);
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = array('selector');
	/**
	 * check if the selector and validator are correct
	 *
	 * @return bool|int
	 */
	public function check() : bool|int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Token']['check']['start']);

		if ($this->get('selector') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Token']['ckeck']['no_selector']);

			return False;
		}
		if ($this->get('validator_clear') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Token']['ckeck']['no_validator_clear']);

			return False;
		}

		$data = $this->manager()->getBy(array(
			'date_expiration' => date($GLOBALS['config']['core']['format']['date']),
			'selector'        => $this->selector,
		), array(
			'date_expiration' => '>',
			'selector'        => '=',
		));

		if ($data === null || empty($data))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Token']['check']['do_not_exist']);

			return False;
		}

		$this->hydrate($data[0]);

		if (password_verify($this->get('validator_clear'), $this->get('validator_hashed')))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Token']['check']['correct']);

			$id_user = $this->get('id_user');
			$this->delete();

			return $id_user;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Token']['check']['incorrect']);

		return False;
	}
	/**
	 * create a token
	 *
	 * @return bool
	 */
	public function create() : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Token']['create']['start']);
		if ($this->get('id_user') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Token']['create']['no_id_user']);

			return False;
		}

		$this->set('selector', \bin2hex(\random_bytes($GLOBALS['config']['class']['user']['Token']['bytes_selector'])));
		$this->set('validator_clear', \bin2hex(\random_bytes($GLOBALS['config']['class']['user']['Token']['bytes_validator'])));
		$this->set('validator_hashed', \password_hash($this->get('validator_clear'), $GLOBALS['config']['class']['user']['Token']['algorithm'], $GLOBALS['config']['class']['user']['Token']['options']));
		$date_expiration = new \DateTime('now');
		$date_expiration->add(new \DateInterval($GLOBALS['config']['class']['user']['Token']['period_before_expiration']));
		$this->set('date_expiration', $date_expiration->format($GLOBALS['config']['core']['format']['date']));
		return $this->add();
	}
}

?>
