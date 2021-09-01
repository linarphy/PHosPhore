<?php

namespace user;

/**
 * manage link between permission and role
 */
class LinkPermissionRole extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'link_permission_role';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_permission',
		'id_role',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_permission',
		'id_role',
	);
}

?>
