<?php

namespace exception;

/**
 * FatalError exception
 *
 * @author gugus2000
 **/
class FatalError extends \exception\Warning
{
	/* constant */

		/**
		* Level of the exception
		*
		* @var int
		*/
		const LEVEL=3;
		/**
		* Type of the notification created with the error
		*
		* @var string
		*/
		const NOTIFICATION_TYPE=\user\Notification::TYPE_ERROR;

	/* method */

		/**
		* Constructor of an instance of \exception\FatalError
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
			throw $this;
		}
} // END class Notice extends \Exception

?>