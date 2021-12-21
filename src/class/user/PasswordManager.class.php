<?php

namespace user;

/**
 * Manager of \user\Password
 */
class PasswordManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_user';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id',
		'password_hashed',
	];
}

?>
