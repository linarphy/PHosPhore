<?php

namespace user;

/**
 * Link between a role and an user
 */
class LinkRoleUser extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_link_role_user';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'name_role',
		'id_user',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'name_role',
		'id_user',
	);
}

?>
