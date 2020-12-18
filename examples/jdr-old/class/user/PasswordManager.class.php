<?php

namespace user;

/**
 * Manager of \user\Password
 *
 * @author gugus2000
 **/
class PasswordManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by \user\Password
		*
		* @var string
		*/
		const TABLE='user';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'password_hashed',
		);
} // END class PasswordManaged extends \user\Manager

?>