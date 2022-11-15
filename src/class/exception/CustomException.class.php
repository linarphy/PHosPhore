<?php

namespace exception;

abstract class CustomException extends \Exception
{
	/**
	 * default logger types
	 *
	 * @var array
	 */
	const LOGGER_TYPES = [];
	/**
	 * CustomException constructor
	 *
	 * @param ?string $message error message (default to null)
	 *
	 * @param int $code user defined code (default to 0)
	 *
	 * @param ?\Throwable $previous previous throwable (default to null)
	 *
	 * @param ?array $logger_types types of the generated log (default to null)
	 *
	 * @param ?\user\Notification $notification if set, notification to display
	 */
	public function __construct(?string $message = null, int $code = 0, ?\Throwable $previous = null, array $logger_types = null, ?\user\Notification $notification = null, ?array $tokens = [])
	{
		if ($message === null)
		{
			throw new $this(
				$GLOBALS['lang']['class']['exception']['CustomException']['default']['message'],
				$code,
				$previous,
				$logger_types,
				$notification,
				$tokens,
			);
		}
		try
		{
			if ($logger_types === null)
			{
				$logger_types = $this::LOGGER_TYPES;
			}
			$GLOBALS['Logger']->log($logger_types, $message, $tokens);
			if ($notification != null)
			{
				if ($notification->get('content') === null)
				{
					$notification->set('content', $GLOBALS['locale']['class']['exception']['CustomException']['default']['message']);
				}
				$notification->addToSession();
			}
			parent::__construct($message, $code, $previous);
		}
		catch (\Throwable $exception)
		{
			parent::__construct($GLOBALS['lang']['class']['exception']['CustomException']['default']['message']);
		}
	}
	/**
	 * convert this exception into a readable string
	 *
	 * @return string
	 */
	public function __toString() : string
	{
		return \htmlspecialchars(\get_class($this)) . ' ' . \htmlspecialchars($this->message) . ' in ' . \htmlspecialchars($this->file) . '(' . \htmlspecialchars($this->line) . ')\n' . \htmlspecialchars($this->getTraceAsString());
	}
}

?>
