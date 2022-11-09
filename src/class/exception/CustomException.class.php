<?php

namespace exception;

abstract class CustomException extends \Exception
{
	public function __construct(?string $message = null, int $code = 0, ?\Throwable $previous = null)
	{
		if ($message === null)
		{
			throw new $this('Unknown ' . \get_class($this));
		}
		parent::__construct($message, $code, $previous);
	}

	public function __toString()
	{
		return \htmlspecialchars(\get_class($this)) . ' ' . \htmlspecialchars($this->message) . ' in ' . \htmlspecialchars($this->file) . '(' . \htmlspecialchars($this->line) . ')\n' . \htmlspecialchars($this->getTraceAsString());
	}
}

?>
