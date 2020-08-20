<?php

/* [DATABASE] */
/* The hostname on which the Mysql database server resides */
$GLOBALS['config']['db_host']='localhost';
/* The name of the Mysql database */
$GLOBALS['config']['db_name']='documentation';
/* The username for Mysql */
$GLOBALS['config']['db_username']='root';
/* The password for Mysql */
$GLOBALS['config']['db_passwd']='';

/* [PAGE] */
/* Default application */
$GLOBALS['config']['default_application']='doc';

/* [IDENTITY] */
/* Name of the website */
$GLOBALS['config']['general_name']='PHosPhore';
/* Email of the website administrator */
$GLOBALS['config']['general_email']='gugus2000@phosphore.org';

/*---------- DOCUMENTATION ----------*/

/* [CONTENT TYPE] */
/* DOCUMENTATION */
/* Description of this content type */
$GLOBALS['config']['default_content_type']['documentation']=array();
/* Name of this content type */
$GLOBALS['config']['default_content_type']['documentation']['name']='documentation';
/* PageElement corresponding to the base content of this content type */
$GLOBALS['config']['default_content_type']['documentation']['content']='documentation\Documentation';
/* PageElement corresponding to the base content of a notification for this content type*/
$GLOBALS['config']['default_content_type']['documentation']['notification']='html\HTMLNotification';

/* [LOG] */
/* Define the logging level */
$GLOBALS['config']['log_level']=2;

?>