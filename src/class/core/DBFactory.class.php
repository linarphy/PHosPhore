<?php

namespace core;

/**
 * Tool to connect with the database
 */
class DBFactory
{
	/**
	 * Creating a database connection
	 *
	 * @param string $db_name Name of the database to be connected to.
	 *                        If null, the default one defined in the configuration ($GLOBALS['config']['class']['core']['DBFactory']['db_name']) will be used.
	 *                        Default to null.
	 *
	 * @param string $db_host The host name on which the Mysql database server resides.
	 *                        If null, the default one defined in the configuration ($GLOBALS['config']['class']['core']['DBFactory']['db_host']) will be used.
	 *                        Default to null.
	 *
	 * @param string $db_username The username for the DSN string.
	 *                            If null, the default one defined in the configuration ($GLOBALS['config']['class']['core']['DBFactory']['db_username']) will be used.
	 *                            Default to null.
	 *
	 * @param string $db_password The password for the DSN string.
	 *                            If null, the default one defined in the configuration ($GLOBALS['config']['class']['core']['DBFactory']['db_password']) will be used.
	 *                            Default to null.
	 *
	 * @param array $db_options A key => value array of driver-specific connection options.
	 *                           If null, the default one defined in the configuration ($GLOBALS['config']['class']['core']['DBFactory']['db_options']) will be used.
	 *                           Default to null.
	 *
	 * @return \PDO The database connection
	 */
	public static function MysqlConnection(?string $db_name = null, ?string $db_host = null, ?string $db_username = null, ?string $db_password = null, ?array $db_options = null) : \PDO
	{
		$config = $GLOBALS['config']['class']['core']['DBFactory'];

		if ($db_name === null)
		{
			$db_name = $config['database']['name'];
		}
		if ($db_host === null)
		{
			$db_host = $config['database']['host'];
		}
		if ($db_username === null)
		{
			$db_username = $config['database']['username'];
		}
		if ($db_password === null)
		{
			$db_password = $config['database']['password'];
		}
		if ($db_options === null)
		{
			$db_options = $config['database']['options'];
		}

		$GLOBALS['Hook']->load(['class', 'core', 'DBFactory', 'MysqlConnection', 'end'], [$db_name, $db_host, $db_username, $db_password, $db_options]);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['MysqlConnection']);

		return new \PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_username, $db_password, $db_options);
	}
}

?>
