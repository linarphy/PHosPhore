<?php

namespace user;

/**
 * Manager of \user\User
 */
class UserManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'user';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id',
		'date_registration',
		'date_login',
		'nickname',
	);
}

?>
