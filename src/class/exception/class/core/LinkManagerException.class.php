<?php

namespace exception\class\core;

class LinkManagerException extends \exception\CustomException
{
	/**
	 * default logger types
	 *
	 * @var array
	 */
	const LOGGER_TYPES = [
		\core\LoggerTypes::ERROR,
		'class',
		'core',
	];
}

?>
