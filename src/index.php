<?php

session_start();

try
{
	require('./func/core/init.php');

	$GLOBALS['Logger'] = new \core\Logger();
	$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['core']['start']);
	$GLOBALS['Router'] = new \route\Router();
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['core']['router_init']);
	$GLOBALS['Visitor'] = new \user\Visitor();
	$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['core']['visitor_init']);

	try
	{
		if ($GLOBALS['Visitor']->connect())
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['core']['visitor_connect']);
			echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']));
		}
		else
		{
			$GLOBALS['Visitor'] = new \user\Visitor(array( // Guest
				'nickname' => $GLOBALS['config']['core']['guest']['nickname'],
			));

			if ($GLOBALS['Visitor']->connect($GLOBALS['config']['core']['guest']['password']))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['log_message']['core']['bad_cred'];

				// Notify the visitor
				$Notification = new \user\Notification(array(
					'text' => $GLOBALS['locale']['class']['user']['visitor']['bad_cred'],
					'type' => \user\Notification::TYPES['error'],
				));
				$Notification->addToSession();

				echo $GLOBALS['Visitor']->loadPage($GLOBALS['Router']->decodeRoute($_SERVER['REQUEST_URI']));
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['log_message']['core']['guest_missmatch']);
				throw new \Exception($GLOBALS['log_message']['core']['guest_missmatch']);
			}
		}
	}
	catch (\Exception $exception)
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['core']['exception_threw'];
		try
		{
			echo $GLOBALS['Visitor']->loadPage($GLOBALS['config']['core']['route']['error']);
		}
		catch
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['log_message']['core']['cannot_display_error_page'];
			try
			{
				echo $GLOBALS['locale']['core']['cannot_display_error_page'];
			}
			catch
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['log_message']['core']['cannot_display_error'];
				throw new \Exception($GLOBALS['log_message']['core']['cannot_display_error'];
			}
		}
	}

	$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['log_message']['core']['end']);
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

		$fwrite($file, $error);

		if (!fclose($file))
		{
			throw new \Exception('Cannot close fatal_crash.log, check your permissions on the web directory');
		}
	}
	catch (\Exception $exception1)
	{
		echo 'Cannot write logs';
		var_dump($exception1);
	}
}

?>
