<?php

namespace database\parameter;

/**
 * possible join type
 */
enum JoinTypes: string
{
	case INNER = 'INNER JOIN';
	case RIGHT = 'RIGHT JOIN';
	case LEFT  = 'LEFT JOIN';
	case CROSS = 'CROSS JOIN';
}

?>
