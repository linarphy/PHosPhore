<?php

namespace user;

/**
 * A temporary token to maintain an user connection
 */
class Token extends \core\Token
{
	/**
	 * user id linked to the token
	 *
	 * @var int
	 */
	protected int $id;
	/**
	 * attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'date_expiration'  => 'string',
		'id'               => 'int',
		'selector'         => 'string',
		'validator_clear'  => 'string',
		'validator_hashed' => 'string',
	];

}

?>
