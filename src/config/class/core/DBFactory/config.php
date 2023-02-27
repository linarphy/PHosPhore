<?php

$CONFIG =& $GLOBALS
           ['config']
           ['class']
           ['core']
           ['DBFactory'];

/** [database] **/
/* default driver used */
$CONFIG['database']['driver'] = 'MYSQL';
/** [drivers] **/
/** [MYSQL] **/
/** [dsn_parameters] **/
/* host which possess the database */
$CONFIG['database']['drivers']['MYSQL']['dsn_parameters']
['host'] = 'localhost';
/* port associated to the database server */
$CONFIG['database']['drivers']['MYSQL']['dsn_parameters']
['port'] = null;
/* name of the database */
$CONFIG['database']['drivers']['MYSQL']['dsn_parameters']
['dbname'] = 'website';
/* unix socket used */
$CONFIG['database']['drivers']['MYSQL']['dsn_parameters']
['unix_socket'] = null;
/* charset used */
$CONFIG['database']['drivers']['MYSQL']['dsn_parameters']
['charset'] = 'UTF8';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$CONFIG['database']['drivers']['MYSQL']['username'] = 'root';
/* password of the user which will connect to the database */
$CONFIG['database']['drivers']['MYSQL']['password'] = '';
/* specifics options used to connect to the database (see
 * https://php.net/pdo.construct) */
$CONFIG['database']['drivers']['MYSQL']['options'] = null;
/** [/MYSQL] **/
/** [POSTGRESQL] **/
/** [dsn_parameters] **/
/* host which possess the database */
$CONFIG['database']['drivers']['POSTGRESQL']['dsn_parameters']
['host'] = 'localhost';
/* port associated to the database server */
$CONFIG['database']['drivers']['POSTGRESQL']['dsn_parameters']
['port'] = null;
/* name of the database */
$CONFIG['database']['drivers']['POSTGRESQL']['dsn_parameters']
['dbname'] = 'website';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$CONFIG['database']['drivers']['POSTGRESQL']['username'] = 'root';
/* password of the user which will connect to the database */
$CONFIG['database']['drivers']['POSTGRESQL']['password'] = '';
/* specifics options used to connect to the database (see
 * https://php.net/pdo.construct) */
$CONFIG['database']['drivers']['POSTGRESQL']['options'] = null;
/** [/POSTGRESQL] **/
/** [FIREBIRD] **/
/** [dsn_parameters] **/
/* role used */
$CONFIG['database']['drivers']['FIREBIRD']['dsn_parameters']
['role'] = '';
/* dialect used */
$CONFIG['database']['drivers']['FIREBIRD']['dsn_parameters']
['dialect'] = '';
/** [§dsn_parameters] **/
/* name of the user which will connect to the database */
$CONFIG['database']['drivers']['FIREBIRD']['username'] = 'root';
/* password of the user which will connect to the database */
$CONFIG['database']['drivers']['FIREBIRD']['password'] = '';
/* specifics options used to connect to the database (see
 * https://php.net/pdo.construct) */
$CONFIG['database']['drivers']['FIREBIRD']['options'] = null;
/** [/FIREBIRD] **/
/** [SQLITE] **/
/** [dsn_parameters] **/
/* if the the database must be stored in memory */
$CONFIG['database']['drivers']['SQLITE']['dsn_parameters']['memory'] = False;
/* path to the database */
$CONFIG['database']['drivers']['SQLITE']['dsn_parameters']['path'] = '';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$CONFIG['database']['drivers']['SQLITE']['username'] = 'root';
/* password of the user which will connect to the database */
$CONFIG['database']['drivers']['SQLITE']['password'] = '';
/* specifics options used to connect to the database (see
 * https://php.net/pdo.construct) */
$CONFIG['database']['drivers']['SQLITE']['options'] = null;
/** [/SQLITE] **/
/** [/drivers] **/
/** [/database] **/

?>
