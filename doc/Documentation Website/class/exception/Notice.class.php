<?php

namespace exception;

/**
 * Notice exception
 *
 * @author gugus2000
 **/
class Notice extends \Exception
{
	/* constant */

		/**
		* Level of the exception
		*
		* @var int
		*/
		const LEVEL=0;

	/* attribute */

		/**
		* Channel of the notice
		* 
		* @var string
		*/
		protected $channel;
	/* method */

		/**
		* Constructor of an instance of \exception\Notice
		*
		* @param string message Exception message
		* @param int code User defined exception code
		* @param \Exception previous Previous exception if nested exception
		* 
		* @return void
		*/
		public function __construct($message=null, $channel='CORE', $code=0, \Exception $previous=null)
		{
			$this->channel=$channel;
			parent::__construct($message, $code, $previous);
			if ($GLOBALS['config']['log_level']<=$this::LEVEL)
			{
				$this->log();
			}
		}
		/**
		* Log the exception into the the log file
		* 
		* @return void
		*/
		public function log()
		{
			if (!is_dir($GLOBALS['config']['path_log']))
			{
				mkdir($GLOBALS['config']['path_log']);
			}
			$file=fopen($GLOBALS['config']['path_log'].'log.txt', 'a');
			if ($file===False)
			{
				throw new \Exception($GLOBALS['lang']['class']['exception']['error_write_log']);
			}
			fwrite($file, date($GLOBALS['config']['class']['exception']['date_format']).' - '.get_class($this).' ['.strtoupper($this->channel).']'.' : '.$this->code.' -> '.$GLOBALS['lang']['class']['exception']['in_file'].' '.$this->file.' '.$GLOBALS['lang']['class']['exception']['at_line'].' '.$this->line.' '.$this->message.PHP_EOL);
			fclose($file);
		}
} // END class Notice extends \Exception

?>