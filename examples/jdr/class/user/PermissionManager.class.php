<?php

namespace user;

/**
 * Manager of \user\Permission
 *
 * @author gugus2000
 **/
class PermissionManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by user\Permission
		*
		* @var string
		*/
		const TABLE='permission';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'role_name',
			2 => 'application',
			3 => 'action',
		);
} // END class PermissionManager extends \core\Manager

?>