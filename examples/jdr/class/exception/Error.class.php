<?php

namespace exception;

/**
 * Error exception
 *
 * @author gugus2000
 **/
class Error extends \exception\Warning
{
	/* constant */

		/**
		* Level of the exception
		*
		* @var int
		*/
		const LEVEL=2;
		/**
		* Type of the notification created with the error
		*
		* @var string
		*/
		const NOTIFICATION_TYPE=\user\Notification::TYPE_WARNING;

	/* method */

		/**
		* Constructor of an instance of \exception\Error
		*
		* @param string message Exception message
		* @param int code User defined exception code
		* @param \Exception previous Previous exception if nested exception
		* 
		* @return void
		*/
		public function __construct($message=null, $channel='CORE', $code=0, \Exception $previous=null)
		{
			parent::__construct($message, $channel, $code, $previous);
			\user\Page::addNotificationSession(new \user\Notification(array(
				'type'    => self::NOTIFICATION_TYPE,
				'content' => htmlspecialchars($this->getMessage()),
			)));
		}
} // END class Notice extends \Exception

?>