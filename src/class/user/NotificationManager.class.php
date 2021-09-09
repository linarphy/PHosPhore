<?php

namespace user;

/**
 * Manager of \user\Notification
 */
class NotificationManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'notification';
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
		'date',
		'id',
		'id_content',
		'type',
	);
}

?>
