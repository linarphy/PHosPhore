<?php

namespace core;

/**
 * Tool to connect with the database
 */
class DBFactory
{
	/**
	 * implemented drivers
	 *
	 * @var array
	 */
	const DRIVERS = [
		'MYSQL',
		'POSTGRESQL',
		'FIREBIRD',
		'SQLITE',
	];
	/**
	 * Creating a database connection
	 *
	 * @param string $driver Name of the driver that will be used.
	 *                       Id null, the default one defined in the configuration will be used.
	 *                       Default to null.
	 *
	 * @param array $dsn_parameters Parameters of DSN associated to the chosen driver.
	 *                              Mysql     : host, port, dbname, unix_socket, charset
	 *                              PostgreSQL: host, port, dbname
	 *                              Firebird  : dbname, charset, role, dialect
	 *                              SQLite    : memory, path
	 *
	 * @param string $username The username for the DSN string.
	 *                         If null, the default one defined in the configuration will be used.
	 *                         Default to null.
	 *
	 * @param string $password The password for the DSN string.
	 *                         If null, the default one defined in the configuration will be used.
	 *                         Default to null.
	 *
	 * @param array $options A key => value array of driver-specific connection options.
	 *                       If null, the default one defined in the configuration will be used.
	 *                       Default to null.
	 *
	 * @return \PDO
	 */
	public static function Connection(?string $driver = null, ?array $dsn_parameters = null, $username = null, ?string $password = null, ?array $options = null) : \PDO
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['start']);

		if ($driver === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['default_driver']);
			$driver = $GLOBALS['config']['class']['core']['DBFactory']['database']['driver'];
		}
		$driver = \strtoupper($driver);
		if (!in_array($driver, self::DRIVERS))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unknown_driver'], ['driver' => $driver]);
			throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_driver']);
		}
		if ($dsn_parameters === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['default_dsn_parameters']);
			$dsn_parameters = $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers'][$driver]['dsn_parameters'];
		}
		switch ($driver)
		{
			case 'MYSQL':
				foreach ($dsn_parameters as $key => $parameter)
				{
					switch ($key)
					{
						case 'host':
							$host = $parameter;
							break;
						case 'port':
							$port = $parameter;
							break;
						case 'dbname':
							$dbname = $parameter;
							break;
						case 'unix_socket':
							$unix_socket = $parameter;
							break;
						case 'charset':
							$charset = $parameter;
							break;
						default:
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unknown_mysql_parameter'], ['key' => $key, 'value' => $parameter]);
							throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_mysql_parameter']);
					}
				}
				if (!isset($host))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['no_mysql_host']);
					throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['no_mysql_host']);
				}
				$dsn = 'mysql: host=' . $host;
				if (isset($port))
				{
					$dsn .= ';port=' . $port;
				}
				if (isset($dbname))
				{
					$dsn .= ';dbname=' . $dbname;
				}
				if (isset($unix_socket))
				{
					$dsn .= ';unix_socket=' . $unix_socket;
				}
				if (isset($charset))
				{
					$dsn .= ';charset=' . $charset;
				}
				break;
			case 'POSTGRESQL':
				foreach ($dsn_parameters as $key => $parameter)
				{
					switch ($key)
					{
						case 'host':
							$host = $parameter;
							break;
						case 'port':
							$port = $parameter;
							break;
						case 'dbname':
							$dbname = $parameter;
							break;
						default:
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unknown_postgresql_parameter'], ['key' => $key, 'value' => $parameter]);
							throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_postgresql_parameter']);
							break;
					}
				}
				if (!isset($host))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['no_postgresql_host']);
					throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['no_postgresql_host']);
				}

				$dsn = 'pgsql: host=' . $host;
				if (isset($port))
				{
					$dsn .= ';port=' . $port;
				}
				if (isset($dbname))
				{
					$dsn .= ';dbname=' . $dbname;
				}
				break;
			case 'FIREBIRD':
				foreach ($dsn_parameters as $key => $parameter)
				{
					switch ($key)
					{
						case 'dbname':
							$dbname = $parameter;
							break;
						case 'charset':
							$charset = $parameter;
							break;
						case 'role':
							$role = $parameter;
							break;
						case 'dialect':
							$dialect = $parameter;
							break;
						default:
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unknown_firebird_parameter'], ['key' => $key, 'value' => $parameter]);
							throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_firebird_parameter']);
							break;
					}
				}

				if (!isset($dbname))
				{
					$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['no_firebird_dbname']);
					throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['no_firebird_dbname']);
				}
				$dsn = 'firebird: dbname=' . $dbname;
				if (isset($charset))
				{
					$dsn .= ';charset=' . $charset;
				}
				if (isset($role))
				{
					$dsn .= ';role=' . $role;
				}
				if (isset($dialect))
				{
					$dsn .= ';dialect=' . $dialect;
				}
				break;
			case 'SQLITE':
				foreach ($dsn_parameters as $key => $parameter)
				{
					switch ($key)
					{
						case 'memory':
							if ($parameter)
							{
								$memory = True;
							}
							break;
						case 'path':
							$path = $parameter;
							break;
						default:
							$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unknown_sqlite_parameter'], ['key' => $key, 'value' => $parameter]);
							throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_sqlite_parameter']);
							break;
					}
				}

				$dsn = 'sqlite:';
				if (isset($memory))
				{
					$dsn .= ':memory:';
				}
				else if (isset($path))
				{
					$dsn .= $path;
				}
				break;
			default:
				$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['unkown_driver'], ['driver' => $driver]);
				throw new \Exception($GLOBALS['locale']['class']['core']['DBFactory']['Connection']['unknown_driver']);
				break;
		}
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['dsn'], ['dsn' => $dsn]);

		if ($username === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['default_username']);
			$username = $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers'][$driver]['username'];
		}
		if ($password === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['default_password']);
			$password = $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers'][$driver]['password'];
		}
		if ($options === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['default_options']);
			$options = $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers'][$driver]['options'];
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['DBFactory']['Connection']['end']);

		return new \PDO($dsn, $username, $password, $options);
	}
}

?>
