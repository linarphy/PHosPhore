<?php

namespace database;

/**
 * set of database drivers
 */
enum DatabaseDrivers: string
{
	case MYSQL      = 'MYSQL';
	case POSTGRESQL = 'POSTGRESQL';
}

?>
