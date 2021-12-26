<?php

/** [database] **/
/* default driver used */
$GLOBALS['config']['class']['core']['DBFactory']['database']['driver'] = 'MYSQL';
/** [drivers] **/
/** [MYSQL] **/
/** [dsn_parameters] **/
/* host which possess the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['host'] = 'localhost';
/* name of the database */
$GLOBALS['config']['class']['core']['DBFactory']['database']['drivers']['MYSQL']['dsn_parameters']['dbname'] = 'website';
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
/** [/drivers] **/
/** [/database] **/

?>
