<?php

namespace exception\class\core;

class DBFactoryException extends \exception\CustomException
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
