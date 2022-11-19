<?php

session_start();	// $_SESSION init at the very start
date_default_timezone_set('UTC');

/**
 * a custom error handler to avoid crash and allows "pretty" recovery
 *
 * @param int $errno Error number
 *
 * @param string $errstr Error message
 *
 * @param string $errfile Path to the file where the error ocurred
 *
 * @param int $errline Line where the error ocurred
 *
 * @return False allows this error to be handled by vanilla php logging
 */
function custom_error_handler($errno, $errstr, $errfile, $errline) : bool
{
    // Determine if this error is one of the enabled ones in php config (php.ini, .htaccess, etc)
    $error_is_enabled = (bool)($errno & ini_get('error_reporting') );

    // -- FATAL ERROR
    // throw an Error Exception, to be handled by whatever Exception handling logic is available in this context
    if( in_array($errno, array(E_USER_ERROR, E_RECOVERABLE_ERROR)) && $error_is_enabled ) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    // -- NON-FATAL ERROR/WARNING/NOTICE
    // Log the error if it's enabled, otherwise just ignore it
    else if( $error_is_enabled ) {
		throw new Exception('Error ' . $errno . ': '. $errstr . ' at ' . $errfile . ' line ' . $errline, 0);
        error_log($errstr, 0 );
        return false; // Make sure this ends up in $php_errormsg, if appropriate
    }
}

set_error_handler('custom_error_handler');	// try to catch as many errors as possible

/**
 * a fatal error handler to crash in a "good" manner when a fatal error occur
 */
function fatal_handler()
{
	$error = error_get_last();

	if ($error !== NULL)
	{
		$errno = $error['type'];
		$errfile = $error['file'];
		$errstr = $error['message'];
		$errline = $error['line'];

		var_dump([
			'errfile' => $errfile,
			'errstr'  => $errstr,
			'errno'   => $errno,
			'errline' => $errline,
		]);
	}
}
register_shutdown_function('fatal_handler'); // try to catch fatal error

try
{
	require(join(DIRECTORY_SEPARATOR, array('func', 'core', 'init.php')));

	$GLOBALS['Hook'] = new \core\Hook();
	$GLOBALS['Hook']->load(['core', 'index', 'start'], []);
	$GLOBALS['Logger'] = new \core\Logger();													// need to load Logger first to log the rest
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['start']);	// first message to log
	$GLOBALS['Hook']->load(['core', 'index', 'start_after_logger'], []);
	$GLOBALS['Router'] = new \route\Router(init_router());
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['router_init']);
	$GLOBALS['Hook']->load(['core', 'index', 'start_after_router'], []);
	$GLOBALS['Visitor'] = new \user\Visitor(init_visitor());
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['visitor_init']);
	$GLOBALS['Hook']->load(['core', 'index', 'start_after_visitor'], []);

	try
	{
		$GLOBALS['Visitor']->retrieve();
		if ($GLOBALS['Visitor']->connect())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['visitor_connect']);
			$GLOBALS['Hook']->load(['core', 'index', 'start_connect'], []);
			echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']))->display();
			$GLOBALS['Hook']->load(['core', 'index', 'end_connected'], []);
		}
		else	// cannot connect
		{
			$GLOBALS['Hook']->load(['core', 'index', 'start_connect_guest'], []);
			$GLOBALS['Visitor'] = new \user\Visitor(array( // Guest
				'id'       => $GLOBALS['config']['core']['login']['guest']['id'],
				'password' => new \user\Password([
					'password_clear' => $GLOBALS['config']['core']['login']['guest']['password'],
				]),
			));
			$GLOBALS['Visitor']->retrieve();

			if ($GLOBALS['Visitor']->connect())
			{
				$GLOBALS['Hook']->load(['core', 'index', 'success_connect_guest'], []);
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['bad_cred']);

				// Notify the visitor
				$Notification = new \user\Notification(array(
					'text' => $GLOBALS['locale']['core']['bad_credentials'],
					'type' => \user\Notification::TYPES['error'],
				));
				$Notification->addToSession();

				echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']))->display();
			}
			else	// guest configuration is wrong, check your configuration !
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['guest_missmatch']);
				$GLOBALS['Hook']->load(['core', 'index', 'start_bad_connect'], []);
				throw new \Exception($GLOBALS['lang']['core']['guest_missmatch']);
			}
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['end']);
		}
		$GLOBALS['Hook']->load(['core', 'index', 'end_connect'], []);
	}
	catch (\Throwable $exception)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['core']['exception_threw']);
		try
		{
			$Route = new \route\Route(array(
				'id' => $GLOBALS['config']['core']['route']['error']['id'],
			));
			$Route->retrieve();

			\route\Router::initPage($Route, []);

			$GLOBALS['exception'] = $exception;
			$GLOBALS['Hook']->load(['core', 'index', 'start_error_page'], [$exception]);
			echo $GLOBALS['Visitor']->loadPage($Route)->display();
			$GLOBALS['Hook']->load(['core', 'index', 'end_error_page'], [$exception]);
		}
		catch (\Throwable $exception_1)	// $exception already taken, but bad naming, yes. An error here possibly mean that the visitor is not initialized
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['core']['cannot_display_error_page']);
			try
			{
				echo $GLOBALS['locale']['core']['cannot_display_error_page'];
			}
			catch (\Throwable $exception_2)	// same than $exception_1, an error here possibly means that we cannot echo: it's a FATAL ERROR
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['cannot_display_error']);
				throw $exception;
			}
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['end_error'], array('error' => $exception->getMessage()));
	}
}
catch (\Throwable $exception) // FATAL ERROR
{
	try
	{
		var_dump($exception);
	}
	catch (\Throwable $exception_1)
	{
		if(!\http_response_code(500)) // CLI
		{
			echo 'FATAL ERROR, CANNOT RECOVER';
			var_dump($exception);
		}
		try
		{
			$file = fopen('fatal_crash.html', 'w');

			if (!$file)
			{
				throw new \Exception('Cannot open fatal_crash.html, check your permissions on the web directory');
			}

			// Converting var_dump to a string
			ob_start();
			var_dump($exception);
			$error = ob_get_clean();

			fwrite($file, $error);

			if (!fclose($file))
			{
				throw new \Exception('Cannot close fatal_crash.html, check your permissions on the web directory');
			}
			echo 'FATAL ERROR, There is a bug in PHosPhore, contact the website owner, if you are, check fatal_crash.html in the root directory and report its content to the PHosPhore maintener here: https://github.com/gugus2000/PHosPhore/issues';
		}
		catch (\Throwable $exception_1)
		{
			echo 'Cannot write logs, check your permissions on the web directory';
		}
	}
}

?>
