<?php

namespace database\parameter;

/**
 * possible expression type
 */
enum ExpressionTypes: string
{
	case COMP = '';
	case AND = 'AND';
	case OR = 'OR';
	case XOR = 'XOR';
}
