<?php

namespace user;

/**
 * Manager of \user\Permission
 */
class PermissionManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_permission';
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
		'id_route',
		'name_role',
	);
}

?>
