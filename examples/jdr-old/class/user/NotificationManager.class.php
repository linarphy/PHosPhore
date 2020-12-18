<?php

namespace user;

/**
 * Manager of \user\Notification
 *
 * @author gugus2000
 **/
class NotificationManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by user\Notification
		*
		* @var string
		*/
		const TABLE='notification';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id',
			1 => 'type',
			2 => 'date_release',
			3 => 'id_content',
		);
} // END class NotificationManager extends \core\Manager

?>