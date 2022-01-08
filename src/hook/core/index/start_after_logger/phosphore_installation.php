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

		throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['no_locale']);
	}

	$stage_file = $GLOBALS['config']['mod']['phosphore_installation']['path']['stage'];
	if (\is_file($stage_file))
	{
		$contents = \file($stage_file, FILE_IGNORE_NEW_LINES);
		if (\phosphore_count($contents) !== 1)
		{
			$GLOBALS['Logger']->log([\core\Logger::TYPES['error'], 'mod', 'phosphore_installation'], $GLOBALS['lang']['mod']['phosphore_installation']['error']['bad_stage']);

			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['bad_stage']);
		}
		$stage = (int)$contents[0];
	}
	else
	{
		try
		{
			$pdo = \core\DBFactory::connection();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$request = $pdo->prepare('SHOW TABLES;');
			$request->execute([]);

			$results = $request->fetchAll();
			var_dump($results);
		}
		catch (\PDOException $error)
		{
			$stage = 0;
		}
	}


	if ($stage === -1)
	{
		$stage_file = \fopen($stage_file, 'w');
		if (!$stage_file)
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_stage']);
		}
		\fwrite($stage_file, '0');
		if (!\fclose($stage_file))
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_stage']);
		}
	}
	if ($stage === 1)
	{
		$config_path = $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['config']['filename'];

		$config_file = \fopen($config_path, 'a');
		if (!$config_file)
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config']);
		}
		\fwrite($config_file, '<?php

');

		/** start **/
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
					\fwrite($config_file, $pageElement->display());
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

				if (isset($_POST['username']))
				{
					if (!empty($_POST['username']))
					{
						$drivers[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers_username',
							'elements' => [
								'driver'   => $_POST['driver'],
								'username' => $_POST['username'],
							],
						]);
					}
				}
				if (isset($_POST['password']))
				{
					if (!empty($_POST['password']))
					{
						$drivers[] = new \content\pageelement\PageElement([
							'template' => $GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] . 'config_database_drivers_password',
							'elements' => [
								'driver'   => $_POST['driver'],
								'password' => $_POST['password'],
							],
						]);
					}
				}

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
				\fwrite($config_file, $Database->display());
			}
		}
		/** end **/

		\fwrite($config_file, '
?>');
		if (!\fclose($config_file))
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config']);
		}

		$stage_file = \fopen($stage_file, 'w');
		if (!$stage_file)
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_stage']);
		}
		\fwrite($stage_file, '2');
		if (!\fclose($stage_file))
		{
			throw new \exception\PHosPhoreInstallationException($GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_stage']);
		}
		exit();
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
catch (\exception\PHosPhoreInstallationException $error)
{
	echo $error->getMessage();

	exit();
}

?>
