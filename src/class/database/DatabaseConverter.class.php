<?php

namespace database;

/**
 * convert php query into the correct database query
 */
abstract class DatabaseConverter
{
	/**
	 * available operators
	 *
	 * @var array
	 */
	const OPERATORS = [
		'=',
		'<',
		'<=',
		'>',
		'>=',
		'!=',
		'<=>',
		'&',
		'|',
		'^',
		'<<',
		'>>',
		'&~',
		'~',
		'~*',
		'!~',
		'!~*',
		'~~*',
		'!~~*',
		'ilike',
		'is',
		'is not',
		'like',
		'like binary',
		'not ilike',
		'not like',
		'not similar to',
		'not regexp',
		'not rlike',
		'regexp',
		'rlike',
		'similar to',
	];
	/**
	 * reserved keywords
	 *
	 * @var array
	 */
	const RESERVED_KEYWORDS = [
	];
	/**
	 * count all row of a table
	 *
	 * @param string $table
	 *
	 * @return int
	 */
	public static function countAll(string $table) : int;
	/**
	 * check if a table exists
	 *
	 * @param string $table
	 *
	 * @return bool
	 */
	public static function ifTableExist(string $table) : bool;
	/**
	 * select a row with the given index exists in the given table
	 *
	 * @param string $table
	 *
	 * @param array $index
	 */
	public static function ifRowExist(string $table, array $index) : bool;
	/**
	 * select a row with the given index from the given table
	 *
	 * @param string $table
	 *
	 * @param array $index
	 *
	 * @return array
	 */
	public static function select(string $table, array $index) : array;
	/**
	 * select all row of a table
	 *
	 * @param string $table
	 *
	 * @return array
	 */
	public static function selectAll(string $table) : array;
}

?>
