<?php

try
{
	$path_config = $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['path']['mod'] . 'phosphore_installation' . DIRECTORY_SEPARATOR . 'config.php';

	if (\is_file($path_config))
	{
		require $path_config;
	}
	else
	{
		$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], 'Error during mod initialization for phosphore_installation: missing config file');

		throw new \exception\PHosPhoreInstallationException('Error during mod initialization for phosphore_installation: missing config file');
	}

	/**
	 * Create path of configuration file
	 *
	 * @param string $type lang or locale
	 *
	 * @param string $value name of the lang or locale
	 *
	 * @return string
	 */
	function phosphore_installation_path(string $type, string $value)
	{
		$path = $GLOBALS['config']['core']['path'][$type] . $GLOBALS['config']['core']['path']['mod'] . 'phosphore_installation' . DIRECTORY_SEPARATOR . $value . '.' . $GLOBALS['config']['core'][$type]['filename'];
		return $path;
	}

	$path_lang = phosphore_installation_path('lang', $GLOBALS['lang']['core']['lang']['abbr']);
	$path_default_lang = phosphore_installation_path('lang', $GLOBALS['config']['mod']['phosphore_installation']['default']['lang']);
	if (\is_file($path_lang))
	{
		require $path_lang;

	}
	else if (\is_file($path_default_lang))
	{
		require $path_default_lang;
	}
	else
	{
		$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], 'Error during mod initialization for phosphore_installation: missing lang file');

		throw new \exception\PHosPhoreInstallationException('Error during mod initialization for phosphore_installation: missing lang file');
	}

	$path_locale = phosphore_installation_path('locale', $GLOBALS['locale']['core']['locale']['abbr']);
	$path_default_locale = phosphore_installation_path('locale', $GLOBALS['config']['mod']['phosphore_installation']['default']['locale']);
	if (\is_file($path_locale))
	{
		require $path_locale;

	}
	else if (\is_file($path_default_locale))
	{
		require $path_default_locale;
	}
	else
	{
		$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['no_locale']);

		throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['no_locale']);
	}

	$stage_file = $GLOBALS['config']['mod']['phosphore_installation']['path']['stage'];
	if (\is_file($stage_file))
	{
		$contents = \file($stage_file, FILE_IGNORE_NEW_LINES);
		if (\phosphore_count($contents) !== 1)
		{
			$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['bad_stage']);

			throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['bad_stage']);
		}
		$stage = (int)$contents[0];
	}
	else
	{
		try
		{
			$pdo = \core\DBFactory::connection();
		}
		catch (\PDOException $error)
		{
			$stage = 0;
		}
	}


	if (isset($stage))
	{
		if ($stage === 1)
		{
			$GLOBALS['Logger']->log([\core\Logger::TYPES['debug'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['start']);

			$config_path = $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename'];

			try
			{
				if (!\is_file($config_path))
				{
					$config_content = '<?php

	';
					$old_content = ''; // backup (useless)

				}
				else
				{
					if ($config_content = \file_get_contents($config_path))
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config']);

						throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_config']);
					}

					$old_content = $config_content; // backup (useful)

					$config_content = \trim($config_content);

					if (\substr($config_content, -2) === '?>') // delete end of the file
					{
						$config_content = \substr($config_content, 0, -2);
					}
				}

				/** start of config.php generation **/
				foreach (['lang', 'locale'] as $key)
				{
					if (isset($_POST[$key]))
					{
						if (!empty($_POST[$key]))
						{
							$pageElement = new \content\pageelement\PageElement([
								'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_' . $key,
								'elements' => [
									$key => $_POST[$key],
								],
							]);
							$config_content .= $pageElement->display();
						}
					}
				}

				if (isset($_POST['driver']))
				{
					if (!empty($_POST['driver']))
					{
						if (!in_array($_POST['driver'], \core\DBFactory::DRIVERS))
						{
							$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['unknown_driver'], ['driver' => $_POST['driver']]);

							throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['unknown_driver']);
						}
						$database = [];

						$database[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_driver',
							'elements' => [
								'driver' => $_POST['driver'],
							],
						]);

						$drivers = [];

						/** generating username and password for created user **/
						$username = 'phosphore_user';
						$password = \bin2hex(\random_bytes($GLOBALS['config']['mod']['phosphore_installation']['database_user_password_length']));

						$drivers[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers_username',
							'elements' => [
								'driver'   => $_POST['driver'],
								'username' => $username,
							],
						]);

						$drivers[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers_password',
							'elements' => [
								'driver'   => $_POST['driver'],
								'password' => $password,
							],
						]);

						switch ($_POST['driver'])
						{
							case 'MYSQL':
								$keys = ['host', 'port', 'dbname', 'unix_socket', 'charset'];
								break;
							case 'POSTGRESQL':
								$keys = ['host', 'port', 'dbname'];
								break;
							case 'FIREBIRD':
								$keys = ['role', 'dialect'];
								break;
							case 'SQLITE':
								$keys = ['memory', 'path'];
								break;
						}
						foreach ($keys as $key)
						{
							if (isset($_POST[$key]))
							{
								if (!empty($_POST[$key]))
								{
									$drivers[] = new \content\pageelement\PageElement([
										'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers_' . $key,
										'elements' => [
											'driver' => $_POST['driver'],
											$key     => $_POST[$key],
										],
									]);
								}
							}
						}

						$database[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers',
							'elements' => [
								'driver'  => $_POST['driver'],
								'drivers' => $drivers,
							],
						]);
						$Database = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database',
							'elements' => [
								'database' => $database,
							],
						]);
						$config_content .= $Database->display();
					}
				}
				/** end of config.php generation **/

				$config_content .= '
	?>';

				if (!\is_file($config_path))
				{
					if (!$config_file = \fopen($config_path, 'w')) // delete file if not exist
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config']);

						throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_config']);
					}

					\fwrite($config_file, $config_content);

					if (!\fclose($config_file))
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);

						throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);
					}
				}
				else
				{
					if ($config_file = \fopen($config_path, 'a')) // update file if exist
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config']);

						throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_config']);
					}

					\fwrite($config_file, $config_content);

					if (!\fclose($config_file))
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);

						throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);
					}
				}

				include($config_path);

				try
				{
					/** try database connection with parameter **/

					$config_dbfactory = $GLOBALS['config']['class']['core']['DBFactory']['database'];

					if (\in_array($config_dbfactory['driver'], ['MYSQL', 'POSTGRESQL']))
					{
						$dsn_parameters = $config_dbfactory['drivers'][$config_dbfactory['driver']]['dsn_parameters'];
						unset($dsn_parameters['dbname']);
						$pdo = \core\DBFactory::connection(dsn_parameters: $dsn_parameters,username: $_POST['username'], password: $_POST['password']);
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					}

					try
					{
						/** create user **/
						if ($config_dbfactory['driver'] === 'MYSQL')
						{
							$request = $pdo->prepare('CREATE USER `' . $config_dbfactory['drivers']['MYSQL']['username'] . '`@`localhost` IDENTIFIED BY \'' . $config_dbfactory['drivers']['MYSQL']['password'] . '\'');
							$request->execute([]);
						}
						else if ($config_dbfactory['driver'] === 'POSTGRESQL')
						{
							$request = $pdo->prepare('CREATE USER ? WITH PASSWORD ?');
							$request->execute(['`' . $config_dbfactory['drivers']['POSTGRESQL']['username'] . '`@`localhost`', '\'' . $config_dbfactory['drivers']['POSTGRESQL']['password'] . '\'']);
						}

						try
						{
							/** create database **/
							if ($config_dbfactory['driver'] === 'MYSQL')
							{
								$request = $pdo->prepare('CREATE DATABASE `' . $config_dbfactory['drivers']['MYSQL']['dsn_parameters']['dbname'] . '`');
								$request->execute();

								$request = $pdo->prepare('GRANT ALL PRIVILEGES ON `' . $config_dbfactory['drivers']['MYSQL']['dsn_parameters']['dbname'] . '`.* TO ' . '`' . $config_dbfactory['drivers']['MYSQL']['username'] . '`@`localhost`');
								$request->execute([]);
							}
							else if ($config_dbfactory['driver'] === 'POSTGRESQL')
							{
								$request = $pdo->prepare('CREATE DATABASE ? WITH OWNER = ?');
								$request->execute([$config_dbfactory['drivers']['POSTGRESQL']['dsn_parameters']['dbname'], '`' . $config_dbfactory['drivers']['POSTGRESQL']['username'] . '`@`localhost`']);
							}

							try
							{
								$request = $pdo->prepare('FLUSH PRIVILEGES');
								$request->execute();

								$pdo_user = \core\DBFactory::connection(); // user is created with the good permission
								$pdo_user->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								/** create table **/
								if (\in_array($config_dbfactory['driver'], ['MYSQL', 'POSTGRESQL']))
								{
									$request_content = \file_get_contents($GLOBALS['config']['core']['path']['asset'] . 'sql' . DIRECTORY_SEPARATOR . 'mod' . DIRECTORY_SEPARATOR . 'phosphore_installation' . DIRECTORY_SEPARATOR . 'table_creation.sql');

									$request = $pdo_user->prepare($request_content);
									$request->execute([]);
								}

								$request = $pdo->prepare('FLUSH TABLES');
								$request->execute([]);

								/** insert necessary elements **/
								$ErrorFolder = new \route\Folder([
									'name'      => 'error',
								]);
								$ErrorFolder->add();
								$MainFolder = new \route\Folder([
									'name'      => 'main',
								]);
								$MainFolder->add();
								$HomeFolder = new \route\Folder([
									'name' => 'home',
									'id_parent' => $MainFolder->get('id'),
								]);
								$HomeFolder->add();
								$ErrorRoute = new \route\Route([
									'name' => 'error',
									'type' => \route\Route::TYPES['page'],
								]);
								$ErrorRoute->add();
								$MainRoute = new \route\Route([
									'name' => 'main',
									'type' => \route\Route::TYPES['folder'],
								]);
								$MainRoute->add();
								$HomeRoute = new \route\Route([
									'name' => 'home',
									'type' => \route\Route::TYPES['page'],
								]);
								$HomeRoute->add();

								$LinkRouteRoute = new \route\LinkRouteRoute();
								$LinkRouteRoute->add([
									'id_route_parent' => 2,
									'id_route_child'  => 3,
								]);
								$MainParameter = new \user\Parameter([
									'key'   => 'preset',
									'value' => 'default_html',
								]);
								$MainParameter->add();
								$LinkPageParameter = new \user\LinkPageParameter();
								$LinkPageParameter->add([
									'id_page'      => 3,
									'id_parameter' => 1,
								]);

								$Password = new \user\Password([
									'password_clear' => $GLOBALS['config']['core']['login']['guest']['password'],
								]);
								$Password->hash();
								$Permissions = [];
								$Permissions[] = new \user\Permission([
									'id_route'  => 1,
									'name_role' => 'all',
								]);
								$Permissions[] = new \user\Permission([
									'id_route'  => 3,
									'name_role' => 'all',
								]);
								foreach ($Permissions as $Permission)
								{
									$Permission->add();
								}

								$Role = new \user\Role([
									'name_role' => 'all',
								]);
								$Visitor = new \user\Visitor([
									'nickname' => $GLOBALS['config']['core']['login']['guest']['nickname'],
									'password' => $Password,
									'roles'    => [
										$Role
									],
								]);
								$Visitor->register();
							}
							catch (\Exception $exception)
							{
								// error when feeding the table => bug to report
								// clean config.php
								// clean user
								// clean table
								$level = 0;
								$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['feeding_table'], ['exception' => $exception]);
								echo $GLOBALS['locale']['mod']['phosphore_installation']['error']['feeding_table'];

								if (\in_array($config_dbfactory['driver'], ['MYSQL', 'POSTGRESQL']))
								{
									$request = $pdo->prepare('DROP DATABASE `' . $config_dbfactory['drivers'][$config_dbfactory['driver']]['dsn_parameters']['dbname'] . '`');
									$request->execute([]);
								}
								$GLOBALS['Logger']->log([\core\Logger::TYPES['info'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['deleted_table']);

								throw new \Exception('no additional error');
							}

							// clean stage file, installation finished
							if (\is_file($stage_file))
							{
								\unlink($stage_file);
							}
							$Notification = new \user\Notification([
								'text' => $GLOBALS['locale']['mod']['phosphore_installation']['success_installation_notification'],
								'type' => \user\Notification::TYPES['success'],
							]);
							$Notification->addToSession();
						}
						catch (\Exception $exception)
						{
							// error when creating a table
							// clean config.php
							// clean user
							if (!isset($level))
							{
								$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['create_table'], ['exception' => $exception]);
								echo $GLOBALS['locale']['mod']['phosphore_installation']['error']['create_table'];
								$level = 1;
							}

							if (\in_array($config_dbfactory['driver'], ['MYSQL', 'POSTGRESQL']))
							{
								$request = $pdo->prepare('DROP USER `' . $config_dbfactory['drivers'][$config_dbfactory['driver']]['username'] . '`@`localhost`');
								$request->execute([]);
							}
							$GLOBALS['Logger']->log([\core\Logger::TYPES['info'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['deleted_user']);

							throw new \PDOException('no additional error');
						}
					}
					catch (\Exception $exception)
					{
						// error when creating an user
						// clean config.php
						if (!isset($level))
						{
							$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['create_user'], ['exception' => $exception]);
							echo $GLOBALS['locale']['mod']['phosphore_installation']['error']['create_user'];
							$level = 2;
						}

						throw new \Exception('no additional error');
					}
				}
				catch (\Exception $exception)
				{
					// error with the given parameter
					// clean config.php
					if (!isset($level))
					{
						$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['connect_database'], ['exception' => $exception]);
						echo $GLOBALS['locale']['mod']['phosphore_installation']['error']['connect_database'];
						$level = 3;
					}

					$GLOBALS['config']['class']['DBFactory']['database']['drivers'][$config_dbfactory['driver']]['username'] = $_POST['username'];
					$GLOBALS['config']['class']['DBFactory']['database']['drivers'][$config_dbfactory['driver']]['password'] = $_POST['password'];

					if (\is_file($config_path))
					{
						if (\phosphore_count($old_content) !== 0) // backup config file
						{
							if ($config_file = \fopen($config_path, 'w'))
							{
								$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config']);

								throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_config']);
							}

							\fwrite($config_file, $old_content);

							if (!\fclose($config_file))
							{
								$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);

								throw new \exception\PHosPhoreInstallationException($GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_close_config']);
							}
							$GLOBALS['Logger']->log([\core\Logger::TYPES['info'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['restored_config']);
						}
						else
						{
							\unlink($config_path);
							$GLOBALS['Logger']->log([\core\Logger::TYPES['info'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['deleted_config']);
						}
					}

					throw new \Exception('no additional error');
				}
			}
			catch (\Exception $exception)
			{
				// error when creating config.php
				if (!isset($level))
				{
					$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['config_creation'], ['exception' => $exception]);
					echo $GLOBALS['locale']['mod']['phosphore_installation']['error']['config_creation'];
				}
				$stage = 0;
			}

			$GLOBALS['Logger']->log([\core\Logger::TYPES['debug'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['end']);
		}
		if ($stage === 0) // database & website configuration
		{
			$elements_lang = $GLOBALS['lang']['mod']['phosphore_installation']['config_elements'];
			$select_driver = '';
			foreach (\core\DBFactory::DRIVERS as $driver)
			{
				$select_driver .= '<option value="' . $driver . '">' . $driver . '</option>';
			}
			$pageElement = new \content\pageelement\PageElement([
				'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_template'],
				'elements' => [
					'title'                 => $elements_lang['title'],
					'action'                => '',
					'method'                => 'POST',
					'legend'                => $elements_lang['legend'],
					'label_lang'            => $elements_lang['label_lang'],
					'value_lang'            => $GLOBALS['config']['core']['lang']['server'],
					'label_locale'          => $elements_lang['label_locale'],
					'value_locale'          => $GLOBALS['config']['core']['locale']['default'],
					'label_username'        => $elements_lang['label_username'],
					'value_username'        => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['username'],
					'label_password'        => $elements_lang['label_password'],
					'value_password'        => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['password'],
					'database_legend'       => $elements_lang['database_legend'],
					'label_driver'          => $elements_lang['label_driver'],
					'select_driver'         => $select_driver,
					'driver_options_legend' => $elements_lang['driver_options_legend'],
					'label_host'            => $elements_lang['label_host'],
					'value_host'            => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['host'],
					'label_port'            => $elements_lang['label_port'],
					'value_port'            => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['port'],
					'label_dbname'          => $elements_lang['label_dbname'],
					'value_dbname'          => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['dbname'],
					'label_unix_socket'     => $elements_lang['label_unix_socket'],
					'value_unix_socket'     => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['unix_socket'],
					'label_charset'         => $elements_lang['label_charset'],
					'value_charset'         => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['charset'],
					'label_role'            => $elements_lang['label_role'],
					'value_role'            => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['dsn_parameters']['role'],
					'label_dialect'         => $elements_lang['label_dialect'],
					'value_dialect'         => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['dsn_parameters']['dialect'],
					'label_memory'          => $elements_lang['label_memory'],
					'value_memory'          => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['dsn_parameters']['memory'],
					'label_path'            => $elements_lang['label_path'],
					'value_path'            => $GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['dsn_parameters']['path'],
					'submit'                => $elements_lang['submit'],
				],
			]);
			echo $pageElement->display();

			$stage_file = \fopen($stage_file, 'w');
			if (!$stage_file)
			{
				throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_stage']);
			}
			\fwrite($stage_file, '1');
			if (!\fclose($stage_file))
			{
				throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_stage']);
			}
			exit();
		}
	}
}
catch (\exception\PHosPhoreInstallationException $error)
{
	var_dump($error);
	echo $error->getMessage();

	exit();
}

?>
