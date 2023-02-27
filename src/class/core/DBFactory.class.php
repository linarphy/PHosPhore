<?php

namespace core;

$LANG = $GLOBALS
        ['lang']
        ['class']
        ['core']
        ['DBFactory'];

$LOCALE = $GLOBALS
          ['locale']
          ['class']
          ['core']
          ['DBFactory'];

$CONFIG = $GLOBALS
          ['config']
          ['class']
          ['core']
          ['DBFactory'];

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
	];
	/**
	 * Creating a database connection
	 *
	 * @param string|\database\DatabaseDrivers $driver Name of the
	 *                       driver that will be used.
	 *                       Id null, the default one defined in the
	 *                       configuration will be used.
	 *                       Default to null.
	 *
	 * @param array $dsn_parameters Parameters of DSN associated to the
	 *                              chosen driver.
	 *                              Mysql     : host, port, dbname,
	 *                              unix_socket, charset
	 *                              PostgreSQL: host, port, dbname
	 *                              Firebird  : dbname, charset, role,
	 *                              dialect
	 *                              SQLite    : memory, path
	 *
	 * @param string $username The username for the DSN string.
	 *                         If null, the default one defined in the
	 *                         configuration will be used.
	 *                         Default to null.
	 *
	 * @param string $password The password for the DSN string.
	 *                         If null, the default one defined in the
	 *                         configuration will be used.
	 *                         Default to null.
	 *
	 * @param array $options A key => value array of driver-specific
	 *                       connection options.
	 *                       If null, the default one defined in the
	 *                       configuration will be used.
	 *                       Default to null.
	 *
	 * @return \PDO
	 *
	 * @throws \exception\class\core\DBFactoryException
	 */
	public static function connection(
		?string|\database\DatabaseDrivers $driver = null,
		?array $dsn_parameters = null,
		?string $username = null,
		?string $password = null,
		?array $options = null,
	) : \PDO
	{
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$LANG
				['connection']
				['start'],
			);

			if ($driver === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\Logger::TYPES['debug'],
					],
					$LANG
					['connection']
					['default_driver'],
				);

				$driver = $CONFIG
						  ['database']
				          ['driver'];
			}

			$driver = \strtoupper($driver);

			if (
				(
					\is_string($driver) &&
					\database\DatabaseDrivers::tryFrom($driver)
				) |
				!\in_array(
					$driver,
					\database\DatabaseDrivers::cases(),
				)
			)
			{
				throw new \exception\class\core\DBFactoryException(
					message: $LANG
						     ['connection']
					         ['unknown_driver'],
					tokens:  [
						'driver' => $driver,
					],
				);
			}

			if ($dsn_parameters === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\Logger::TYPES['debug'],
					],
					$LANG
					['connection']
					['default_dsn_parameters']
				);

				$dsn_parameters = $CONFIG
								  ['database']
								  ['drivers']
								  [$driver]
				                  ['dsn_parameters'];
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
								throw new \exception\class\core\DBFactoryException(
									message: $LANG
											 ['connection']
									         ['unknown_mysql_parameter'],
									tokens:  [
										'key'   => $key,
										'value' => $parameter,
									],
								);
						}
					}

					if (!isset($host))
					{
						throw new \exception\class\core\DBFactoryException(
							message: $LANG
									 ['connection']
							         ['no_mysql_host'],
						);
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
								throw new \exception\class\core\DBFactoryException(
									message: $LANG
											 ['connection']
									         ['unknown_postgresql_parameter'],
									tokens:  [
										'key'   => $key,
										'value' => $parameter,
									],
								);
						}
					}

					if (!isset($host))
					{
						throw new \exception\class\core\DBFactoryException(
							message: $LANG
									 ['connection']
							         ['no_postgresql_host'],
						);
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
								throw new \exception\class\core\DBFactoryException(
									message: $LANG
											 ['connection']
									         ['unknown_firebird_parameter'],
									tokens:  [
										'key'   => $key,
										'value' => $attribute,
									],
								);
						}
					}

					if (!isset($dbname))
					{
						throw new \exception\class\core\DBFactoryException(
							message: $LANG
									 ['connection']
							         ['no_firebird_dbname'],
						);
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
								throw new \exception\class\core\DBFactoryException(
									message: $LANG
											 ['connection']
									         ['unknown_sqlite_parameter'],
									tokens:  [
										'key'   => $key,
										'value' => $attribute,
									],
								);
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
					throw new \exception\class\core\DBFactoryException(
						message: $LANG
								 ['connection']
						         ['unknown_driver'],
						tokens: [
							'driver' => $driver,
						],
					);
			}
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$LANG
				['connection']
				['dsn'],
				[
					'dsn' => $dsn,
				],
			);

			if ($username === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$LANG
					['connection']
					['default_username']
				);

				$username = $CONFIG
							['database']
							['drivers']
							[$driver]
				            ['username'];
			}

			if ($password === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$LANG
					['connection']
					['default_password'],
				);

				$password = $CONFIG
							['database']
							['drivers']
							[$driver]
				            ['password'];
			}

			if ($options === null)
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::DEBUG,
					],
					$LANG
					['connection']
					['default_options'],
				);

				$options = $CONFIG
						   ['database']
						   ['drivers']
						   [$driver]
				           ['options'];
			}

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$LANG
				['connection']
				['end'],
			);

			try
			{
				return new \PDO($dsn, $username, $password, $options);
			}
			catch (\PDOException $exception)
			{
				throw new \exception\class\core\DBFactoryException(
					message:  $LANG
							  ['connection']
					          ['error_pdo'],
					tokens:   [
						'exception' => $exception->getMessage(),
					],
					previous: $exception,
				);
			}
		}
		catch (
			\exception\class\core\DBFactoryException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\DBFactoryException(
				message:      $LANG
							  ['connection']
				              ['error_custom'],
				tokens:       [
					'exception'      => $exception->getMessage(),
					'driver'         => $driver,
					'dsn_parameters' => $dsn_parameters,
					'username'       => $username,
					'options'        => $options,
				],
				notification: new \user\Notification([
					'content' => $LOCALE
								 ['connection']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
}

?>
