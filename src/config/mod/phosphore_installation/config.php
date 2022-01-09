<?php

/** [default] **/
/* default lang abbr */
$GLOBALS['config']['mod']['phosphore_installation']['default']['lang'] = 'en';
/* default locale abbr */
$GLOBALS['config']['mod']['phosphore_installation']['default']['locale'] = 'en';
/** [/default] **/

/** [path] **/
/* stage file */
$GLOBALS['config']['mod']['phosphore_installation']['path']['stage'] = $GLOBALS['config']['core']['path']['mod'] . 'phosphore_installation' . DIRECTORY_SEPARATOR . 'stage';
/* configuration template file */
$GLOBALS['config']['mod']['phosphore_installation']['path']['config_template'] = $GLOBALS['config']['core']['path']['mod'] . 'phosphore_installation' . DIRECTORY_SEPARATOR . 'configuration.html';
/* templates file for config generation */
$GLOBALS['config']['mod']['phosphore_installation']['path']['config_files'] = $GLOBALS['config']['core']['path']['mod'] . 'phosphore_installation' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
/** [/path] **/

/* number of bytes used to generate a random password for phosphore database user */
$GLOBALS['config']['mod']['phosphore_installation']['database_user_password_length'] = 16;

?>
