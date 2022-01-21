<?php

namespace core;

/**
 * Manager of \core\Token
 */
class TokenManager extends \core\Manager
{
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'selector',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'date_expiration',
		'id',
		'selector',
		'validator_hashed',
	];
}

?>
