<?php

namespace database;

/**
 * possible query type
 */
enum QueryTypes
{
	case delete;
	case insert;
	case select;
	case table;
	case update;
}

?>
