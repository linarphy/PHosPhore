<?php

namespace exception\class\content;

class ContentException extends \exception\CustomException
{
	/**
	 * default logger types
	 *
	 * @var array
	 */
	const LOGGER_TYPES = [
		\core\LoggerTypes::DEBUG,
		'class',
		'core',
	];
}

?>
