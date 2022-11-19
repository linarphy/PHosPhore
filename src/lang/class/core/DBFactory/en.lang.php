<?php

/** [connection] **/
/* start to construct the database connection */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['start'] = 'starting to create the database connection';
/* default driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['default_driver'] = 'using default driver';
/* unknown driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['unknown_driver'] = 'driver {driver} is unknown';
/* default dsn_parameters */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['default_dsn_parameters'] = 'using default dsn parameters for this driver';
/* unknown dsn_parameters for mysql driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['unknown_mysql_parameter'] = 'the parameter {key} with the value {value} is unknown';
/* unknown dsn_parameters for postgresql driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['unknown_postgresql_parameter'] = 'the parameter {key} with the value {value} is unknown';
/* unknown dsn_parameters for firebird driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['unknown_firebird_parameter'] = 'the parameter {key} with the value {value} is unknown';
/* unknown dsn_parameters for sqlite driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['unknown_sqlite_parameter'] = 'the parameter {key} with the value {value} is unknown';
/* no parameter host for mysql driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['no_mysql_host'] = 'a host is mandatory to create a mysql database connection';
/* no parameter host for postgresql driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['no_postgresql_host'] = 'a host is mandatory to create a postgresql database connection';
/* no parameter dbname for firebird driver */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['no_firebird_dbname'] = 'a database name is mandatory to create a firebird database connection';
/* successfully created the dsn string */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['dsn'] = 'dsn successfully generated: {dsn}';
/* default username */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['default_username'] = 'using default username for this driver';
/* default password */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['default_password'] = 'using default password for this drivers';
/* default options */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['default_options'] = 'using default options for this driver';
/* end of the database connection creation */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['end'] = 'database connection created';
/* a PDO error happened during database connection */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['error_pdo'] = 'an error occured during the PDO object construction: {exception}';
/* an error happened during database connection */
$GLOBALS['lang']['class']['core']['DBFactory']['connection']['error_custom'] = 'an error occured during database creation (driver: {driver}, dsn_parameters: {dsn_parameters}, username: {username}, password: {password}, options: {options}): {exception}';
/** [/connection] **/

?>
