<?php

namespace core;

/**
 * set of database drivers
 */
enum DatabaseDrivers: string
{
	case MYSQL      = 'MYSQL';
	case POSTGRESQL = 'POSTGRESQL';
}

?>
