<?php

namespace user;

/**
 * Manage link between notification and user
 */
class LinkNotificationUser extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'link_notification_user';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_notification',
		'id_user',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_notification',
		'id_user',
	);
}

?>
