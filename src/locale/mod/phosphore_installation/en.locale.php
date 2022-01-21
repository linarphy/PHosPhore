<?php

/** [error] **/
/* no locale file */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['no_locale'] = 'Error during mod initialization for phosphore_installation: missing locale file';
/* wrong secret */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['wrong_secret'] = 'Cannot continu PHosPhore installation, incorrect secret, reload the page and put the correct secret (a new secret will be set)';
/* stage file missformed */
$GLOABLS['locale']['mod']['phosphore_installation']['error']['bad_stage'] = 'stage file corrupted, it does not contains one number';
/* stage file cannot be opened */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_stage'] = 'stage file cannot be opened';
/* stage file cannot be closed */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_close_stage'] = 'stage file cannot be closed';
/* configuration file cannot be opened */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_open_config'] = 'personnal configuration file cannot be opened';
/* unknown driver chose */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['unknown_driver'] = 'the database driver you chose is not supported';
/* configuration file cannot be closed */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['cannot_close_config'] = 'personnal configuration file cannot be closed';
/* cannot feed table in the database */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['feeding_table'] = 'FATAL ERROR, There is a bug in PHosPhore, contact the website owner, if you are, contact to the PHosPhore maintener here: https://github.com/gugus2000/PHosPhore/issues';
/* cannot create the table in the database */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['create_table'] = 'Error when creating a table in the database created with a new user, check sql user permission, and if the name given is not already a table name';
/* cannot create the user in the database */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['create_user'] = 'Error when creating the phosphore user in the database, check sql permission for the user you set, and if the name is not already taken';
/* cannot connect to the database */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['connect_database'] = 'Error when connecting to the database with the given parameter, please check them';
/* cannot create the configuration file */
$GLOBALS['locale']['mod']['phosphore_installation']['error']['config_creation'] = 'Error when creating/updating the configuration file config/config.php, check the file permission in the root and config directory';
/** [/error] **/

/* installation finished */
$GLOBALS['locale']['mod']['phosphore_installation']['success_installation_notification'] = 'PHosPhore has been successfully installed';

?>
