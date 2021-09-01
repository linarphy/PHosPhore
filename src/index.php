<?php

session_start();	// $_SESSION init at the very start

function custom_error_handler($errno, $errstr, $errfile, $errline)
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

try
{
	require(join(DIRECTORY_SEPARATOR, array('func', 'core', 'init.php')));

	$GLOBALS['Logger'] = new \core\Logger();	// need to load Logger first to log the rest
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['start']);	// first message to log
	$GLOBALS['Router'] = new \route\Router(init_router());
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['router_init']);
	$GLOBALS['Visitor'] = new \user\Visitor(init_visitor);
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['visitor_init']);

	try
	{
		if ($GLOBALS['Visitor']->connect())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['visitor_connect']);
			echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']))->display();
		}
		else	// cannot connect
		{
			$GLOBALS['Visitor'] = new \user\Visitor(array( // Guest
				'nickname' => $GLOBALS['config']['core']['guest']['nickname'],
			));

			if ($GLOBALS['Visitor']->connect($GLOBALS['config']['core']['guest']['password']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['core']['bad_cred']);

				// Notify the visitor
				$Notification = new \user\Notification(array(
					'text' => $GLOBALS['locale']['class']['user']['visitor']['bad_cred'],
					'type' => \user\Notification::TYPES['error'],
				));
				$Notification->addToSession();

				echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']))->display();
			}
			else	// guest configuration is wrong, check your configuration !
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['guest_missmatch']);
				throw new \Exception($GLOBALS['lang']['core']['guest_missmatch']);
			}
		}
	}
	catch (\Exception $exception)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['core']['exception_threw']);
		try
		{
			echo $GLOBALS['Visitor']->loadPage($GLOBALS['config']['core']['route']['error'])->display();
		}
		catch (\Exception $exception_1)	// $exception alreaty taken, but bad naming, yes. An error here possibly mean that the visitor is not initialized
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['core']['cannot_display_error_page']);
			try
			{
				echo $GLOBALS['locale']['core']['cannot_display_error_page'];
			}
			catch (\Exception $exception_2)	// same than $exception_1, an error here possibly means that we cannot echo: it's a FATAL ERROR
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['core']['cannot_display_error']);
				throw new \Exception($GLOBALS['lang']['core']['cannot_display_error']);
			}
		}
	}

	$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['core']['end']);
}
catch (\Exception $exception) // FATAL ERROR
{
	if(!http_response_code(500)) // CLI
	{
		echo 'FATAL ERROR, CANNOT RECOVER';
		var_dump($exception);
	}
	try
	{
		$file = fopen('fatal_crash.log', 'w');

		if (!$file)
		{
			throw new \Exception('Cannot open fatal_crash.log, check your permissions on the web directory');
		}

		// Converting var_dump to a string
		ob_start();
		var_dump($exception);
		$error = ob_get_clean();

		fwrite($file, $error);

		if (!fclose($file))
		{
			throw new \Exception('Cannot close fatal_crash.log, check your permissions on the web directory');
		}
		echo 'FATAL ERROR, Check fatal_crash.log in the root directory';
	}
	catch (\Exception $exception_1)
	{
		echo 'Cannot write logs';
		var_dump($exception_1);
	}
}

?>