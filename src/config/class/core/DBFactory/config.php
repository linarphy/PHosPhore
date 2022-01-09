<?php

/** [database] **/
/* default driver used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['driver'] = 'MYSQL';
/** [drivers] **/
/** [MYSQL] **/
/** [dsn_parameters] **/
/* host which possess the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['host'] = 'localhost';
/* port associated to the database server */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['port'] = null;
/* name of the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['dbname'] = 'website';
/* unix socket used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['unix_socket'] = null;
/* charset used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['charset'] = 'UTF8';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['username'] = 'root';
/* password of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['password'] = '';
/* specifics options used to connect to the database (see https://php.net/pdo.construct) */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['options'] = null;
/** [/MYSQL] **/
/** [POSTGRESQL] **/
/** [dsn_parameters] **/
/* host which possess the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['dsn_parameters']['host'] = 'localhost';
/* port associated to the database server */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['dsn_parameters']['port'] = null;
/* name of the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['dsn_parameters']['dbname'] = 'website';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['username'] = 'root';
/* password of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['password'] = '';
/* specifics options used to connect to the database (see https://php.net/pdo.construct) */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['POSTGRESQL']['options'] = null;
/** [/POSTGRESQL] **/
/** [FIREBIRD] **/
/** [dsn_parameters] **/
/* role used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['dsn_parameters']['role'] = '';
/* dialect used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['dsn_parameters']['dialect'] = '';
/** [§dsn_parameters] **/
/* name of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['username'] = 'root';
/* password of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['password'] = '';
/* specifics options used to connect to the database (see https://php.net/pdo.construct) */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['FIREBIRD']['options'] = null;
/** [/FIREBIRD] **/
/** [SQLITE] **/
/** [dsn_parameters] **/
/* if the the database must be stored in memory */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['dsn_parameters']['memory'] = False;
/* path to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['dsn_parameters']['path'] = '';
/** [/dsn_parameters] **/
/* name of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['username'] = 'root';
/* password of the user which will connect to the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['password'] = '';
/* specifics options used to connect to the database (see https://php.net/pdo.construct) */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['SQLITE']['options'] = null;
/** [/SQLITE] **/
/** [/drivers] **/
/** [/database] **/

?>
