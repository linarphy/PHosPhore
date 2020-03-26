<?php

namespace user;

/**
* Manager of \user\User
*
* @author gugus2000
*/
class UserManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by user\User
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
			1 => 'nickname',
			2 => 'avatar',
			3 => 'date_registration',
			4 => 'date_login',
			5 => 'banned',
			6 => 'email',
		);
} // END class UserManager extends \core\Manager

?>