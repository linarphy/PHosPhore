<?php

namespace exception;

/**
 * Warning exception
 *
 * @author gugus2000
 **/
class Warning extends \exception\Notice
{
	/* constant */

		/**
		* Level of the exception
		*
		* @var int
		*/
		const LEVEL=1;

	/* method */

		/**
		* Constructor of an instance of \exception\Warning
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
		}
} // END class Notice extends \Exception

?>