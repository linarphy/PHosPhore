<?php

namespace user;

/**
 * set of possible notification type
 */
enum NotificationTypes: string
{
	case DEBUG       = 'debug';
	case ERROR       = 'error';
	case FATAL_ERROR = 'fatal_error';
	case INFO        = 'info';
	case NOTICE      = 'notice';
	case SUCCESS     = 'success';
	case WARNING     = 'warning';
}

?>
