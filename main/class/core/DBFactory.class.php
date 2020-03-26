<?php

namespace core;

/**
 * Allows quick connection to the database
 *
 * @author gugus2000
*/
class DBFactory
{
	/**
	* Creation of a database connexion
	*
	* @param string $dbname Name of the database to be connected to
	*
	* @return \PDO
	*/
	public static function MysqlConnection($dbname=null)
	{
		if ($dbname===null)
		{
			$dbname=$GLOBALS['config']['db_name'];
		}
		return new \PDO('mysql:host='.$GLOBALS['config']['db_host'].';dbname='.$dbname.';charset=utf8', $GLOBALS['config']['db_username'], $GLOBALS['config']['db_passwd'], $GLOBALS['config']['db_options']);
	}
} // END class DBFactory

?>