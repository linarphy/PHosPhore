<?php

namespace core;

/**
 * A temporary token
 */
abstract class Token extends \core\Managed
{
	/**
	 * expiration date of the token
	 *
	 * @var string
	 */
	protected ?string $date_expiration;
	/** selector, which act like a temporary nickname (stored in session)
	 *
	 * @var string
	 */
	protected ?string $selector;
	/**
	 * validator, which act like a temporary password (stored in session)
	 *
	 * @var string
	 */
	protected ?string $validator_clear;
	/**
	 * hahsed validator, which act like a temporary hashed validator
	 *
	 * @var string
	 */
	protected ?string $validator_hashed;
	/**
	 * number of bytes to create the selector
	 *
	 * @var int
	 */
	const BYTES_NUMBER_SELECTOR = 16;
	/**
	 * number of bytes to create the validator
	 *
	 * @var int
	 */
	const BYTES_NUMBER_VALIDATOR = 16;
	/**
	 * algorithm used to hash validator
	 *
	 * @var int
	 */
	const HASH_ALGORITHM = PASSWORD_DEFAULT;
	/**
	 * options used to hash validator
	 *
	 * @var array
	 */
	const HASH_OPTIONS = [];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'selector',
	];
	/**
	 * time interval (https://www.php.net/manual/dateinterval.construct.php) before the token expiration
	 *
	 * @var string
	 */
	const TIME_EXPIRATION = 'PT10M';
	/**
	 * check if the selector and validator are correct
	 *
	 * @return bool|int
	 */
	public function check() : bool|int
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Token']['check']['start']);

		if ($this->get('selector') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Token']['check']['no_selector']);

			return False;
		}
		if ($this->get('validator_clear') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Token']['check']['no_validator_clear']);

			return False;
		}

		$data = $this->manager()->getBy([ // get possible token
			'date_expiration' => \date($GLOBALS['config']['core']['format']['date']),
			'selector'        => $this->get('selector'),
		], [
			'date_expiration' => '>',
			'selector'        => '=',
		]);

		if (\phosphore_count($data) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Token']['check']['no_result']);

			return False;
		}

		$this->hydrate($data[0]);

		if (!\password_verify($this->get('validator_clear'), $this->get('validator_hashed')))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Token']['check']['incorrect']);

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['core']['Token']['check']['correct']);

		$id = $this->get('id');
		$this->delete(); // a token work only one time

		return $id;
	}
	/**
	 * create a token
	 *
	 * @return bool|array
	 */
	public function create() : bool|array
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['Token']['create']['start']);

		if ($this->get('id') === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['Token']['create']['no_id']);

			return False;
		}

		$this->set('selector', \bin2hex(\random_bytes($this::BYTES_NUMBER_SELECTOR)));
		$this->set('validator_clear', \bin2hex(\random_bytes($this::BYTES_NUMBER_VALIDATOR)));
		$this->set('validator_hashed', \password_hash($this->get('validator_clear'), $this::HASH_ALGORITHM, $this::HASH_OPTIONS));

		$date_expiration = new \DateTime('now');
		$time_expiration = new \DateInterval($this::TIME_EXPIRATION);
		$date_expiration->add($time_expiration);

		$this->set('date_expiration', $date_expiration->format($GLOBALS['config']['core']['format']['date']));

		$this->manager()->deleteBy([
			'date_expiration' => \date($GLOBALS['config']['core']['format']['date']),
		], [
			'date_expiration' => '<',
		]);

		return $this->add();
	}
}

?>
