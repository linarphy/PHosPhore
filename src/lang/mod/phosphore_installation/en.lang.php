<?php

/** [config_elements] **/
/* title of the page */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['title'] = 'Server configuration';
/* main form legend */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['legend'] = 'Server Configuration';
/* label for server lang */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_lang'] = 'default lang of the server';
/* label for server locale */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_locale'] = 'default locale of the server';
/* legend for database fieldset */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['database_legend'] = 'Database configuration';
/* label for username */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_username'] = 'Name of the user which will CREATE the database';
/* label for password */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_password'] = 'Password of the user which will CREATE the database';
/* label for drivers */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_driver'] = 'Database driver (see <a href="https://www.php.net/manual/pdo.drivers.php">here</a>)';
/* label for drivers options */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['driver_options_legend'] = 'Driver Options';
/* label for host configuration */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_host'] = '(Mysql, PostgreSQL) server host';
/* label for port configuration */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_port'] = '(Mysql, PostgreSQL) server port';
/* label for name of the database */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_dbname'] = '(Mysql, PostgreSQL, Firebird) name of the database';
/* label for unix_socket */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_unix_socket'] = '(Mysql) unix socket';
/* label for the charset used */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_charset'] = '(Mysql) charset used';
/* label for the role used */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_role'] = '(Firebase) name of the SQL role';
/* label for the dialect */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_dialect'] = '(Firebase) database dialect (1 or 3)';
/* label for memory */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_memory'] = '(SQLite) if the database must be created in memory';
/* label for path */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['label_path'] = '(SQLite) path to the database';
/* submit button */
$GLOBALS['lang']['mod']['phosphore_installation']['config_elements']['submit'] = 'validate configuration';
/** [/config_elements] **/

/** [error] **/
/* no locale file */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['no_locale'] = 'Error during mod initialization for phosphore_installation: missing locale file';
/* stage file missformed */
$GLOABLS['lang']['mod']['phosphore_installation']['error']['bad_stage'] = 'stage file corrupted, it does not contains one number';
/* stage file cannot be opened */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_stage'] = 'stage file cannot be opened';
/* stage file cannot be closed */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_stage'] = 'stage file cannot be closed';
/* configuration file cannot be opened */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_open_config'] = 'personnal configuration file cannot be opened';
/* unknown driver chose */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['unknown_driver'] = 'the database driver {driver} is not supported';
/* configuration file cannot be closed */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_close_config'] = 'personnal configuration file cannot be closed';
/* cannot connect to the database with the given parameter */
$GLOBALS['lang']['mod']['phosphore_installation']['error']['cannot_connect_database'] = 'cannot connect to the database with the given parameter: error: {exception}';
/** [/error] **/

/** [stage_1] **/
/* start to applying configuration and creating database */
$GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['start'] = 'start stage 1: applying configuration and creation database';
/* end stage 1 */
/** [/stage_1] **/
$GLOBALS['lang']['mod']['phosphore_installation']['stage_1']['end'] = 'end stage 1';

?>
