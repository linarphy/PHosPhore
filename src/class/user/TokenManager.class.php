<?php

namespace user;

/**
 * Manager of \user\Token
 */
class TokenManager extends \core\TokenManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_login_token';
}

?>
