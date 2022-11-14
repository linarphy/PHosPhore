<?php

namespace exception\class\content\pageelement;

class PageElementException extends \exception\CustomException
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
