# Logging system

PHosPhore implement logging functionalities.

To use it, `$GLOBALS['Logger']->log` method (`\core\Logger::log()`) should be used.

Every message can be logged in multiple `types`, which are, concretly, different folder in [`log/`](../../src/log).

You can configurate Logging message format, types which will be logged, or base directory.
