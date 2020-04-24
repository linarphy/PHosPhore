<?php

namespace user;

/**
 * LinkManager between \user\Notification and \user\User
 *
 * @author gugus2000
 **/
class LinkNotificationUser extends \core\LinkManager
{
	/* Constant */

		/**
		* Data table used by the link
		*
		* @var string
		*/
		const TABLE='linknotificationuser';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id_notification',
			1 => 'id_user',
		);
} // END class LinkNotificationUser extends \core\LinkManager

?>