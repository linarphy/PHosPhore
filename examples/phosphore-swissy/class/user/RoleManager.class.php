<?php

namespace user;

/**
 * Manager of \user\Role
 *
 * @author gugus2000
 **/
class RoleManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by \user\Role
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
			1 => 'role_name',
		);
} // END class RoleManager extends \core\Manager

?>