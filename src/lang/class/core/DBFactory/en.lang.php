<?php

$LANG =& $GLOBALS
          ['lang']
          ['class']
          ['core']
          ['DBFactory'];

/** [connection] **/
/* start to construct the database connection */
$LANG['connection']['start'] = 'starting to create the database 
connection';
/* default driver */
$LANG['connection']['default_driver'] = 'using default driver';
/* unknown driver */
$LANG['connection']['unknown_driver'] = 'driver {driver} is unknown';
/* default dsn_parameters */
$LANG['connection']['default_dsn_parameters'] = 'using default dsn 
parameters for this driver';
/* unknown dsn_parameters for mysql driver */
$LANG['connection']['unknown_mysql_parameter'] = 'the parameter {key} 
with the value {value} is unknown';
/* unknown dsn_parameters for postgresql driver */
$LANG['connection']['unknown_postgresql_parameter'] = 'the parameter 
{key} with the value {value} is unknown';
/* unknown dsn_parameters for firebird driver */
$LANG['connection']['unknown_firebird_parameter'] = 'the parameter {key} 
with the value {value} is unknown';
/* unknown dsn_parameters for sqlite driver */
$LANG['connection']['unknown_sqlite_parameter'] = 'the parameter {key} 
with the value {value} is unknown';
/* no parameter host for mysql driver */
$LANG['connection']['no_mysql_host'] = 'a host is mandatory to create a 
mysql database connection';
/* no parameter host for postgresql driver */
$LANG['connection']['no_postgresql_host'] = 'a host is mandatory to 
create a postgresql database connection';
/* no parameter dbname for firebird driver */
$LANG['connection']['no_firebird_dbname'] = 'a database name is 
mandatory to create a firebird database connection';
/* successfully created the dsn string */
$LANG['connection']['dsn'] = 'dsn successfully generated: {dsn}';
/* default username */
$LANG['connection']['default_username'] = 'using default username for 
this driver';
/* default password */
$LANG['connection']['default_password'] = 'using default password for 
this drivers';
/* default options */
$LANG['connection']['default_options'] = 'using default options for 
this driver';
/* end of the database connection creation */
$LANG['connection']['end'] = 'database connection created';
/* a PDO error happened during database connection */
$LANG['connection']['error_pdo'] = 'an error occured during the PDO 
object construction: {exception}';
/* an error happened during database connection */
$LANG['connection']['error_custom'] = 'an error occured during database 
creation (driver: {driver}, dsn_parameters: {dsn_parameters}, username: 
{username}, options: {options}): {exception}';
/** [/connection] **/

?>
