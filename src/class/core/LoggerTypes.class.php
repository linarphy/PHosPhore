<?php

namespace core;

/**
 * set of classic log type
 */
enum LoggerTypes: string
{
	case DEBUG   = 'debug';
	case INFO    = 'info';
	case WARNING = 'warning';
	case ERROR   = 'error';
}

?>
