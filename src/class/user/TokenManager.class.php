<?php

namespace user;

/**
 * Manager of \user\Token
 */
class TokenManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_login_token';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'selector',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'date_expiration',
		'id_user',
		'selector',
		'validator_hashed',
	);
}

?>
