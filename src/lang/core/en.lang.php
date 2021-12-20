<?php

/** [lang] **/
/* abbreviation of the lang */
$GLOBALS['lang']['core']['lang']['abbr'] = 'en';
/* full name of the lang */
$GLOBALS['lang']['core']['lang']['full'] = 'english';
/** [/lang] **/

/** [AUTOLOAD] **/
/* starting autoload */
$GLOBALS['lang']['core']['autoload']['start'] = 'starting the autoload for the class {class}';
/* load config file */
$GLOBALS['lang']['core']['autoload']['config_file'] = 'loading {path} config file for the class {class}';
/* load lang file */
$GLOBALS['lang']['core']['autoload']['lang_file'] = 'loading {path} lang file for the class {class}';
/* load locale file */
$GLOBALS['lang']['core']['autoload']['locale_file'] = 'loading {path} locale file for the class {class}';
/* end of autoload */
$GLOBALS['lang']['core']['autoload']['end'] = 'autoload of the class {class} finished';
/** [/AUTOLOAD] **/

/** [LOG] **/
/* start */
$GLOBALS['lang']['core']['start'] = 'starting the script, Logger initialized';
/* router_init */
$GLOBALS['lang']['core']['router_init'] = 'router initialized';
/* visitor_init */
$GLOBALS['lang']['core']['visitor_init'] = 'visitor initialized';
/* visitor successfully connect */
$GLOBALS['lang']['core']['visitor_connect'] = 'visitor connected';
/* guest credentials are incorrect */
$GLOBALS['lang']['core']['guest_missmatch'] = 'guest credentials stored in the server configuration are incorrect';
/* exception threw */
$GLOBALS['lang']['core']['exception_threw'] = 'exception threwed, trying to recover';
/* cannot display the error page */
$GLOBALS['lang']['core']['cannot_display_error_page'] = 'cannot display the error page, trying to recover';
/* cannot display at all */
$GLOBALS['lang']['core']['cannot_display_error'] = 'error cannot be displayed, trying to recover';
/* recovery ended */
$GLOBALS['lang']['core']['end'] = 'successfull recovery for the error: {error}';
/** [/LOG] **/

/** [LOGIN] **/
/* no token stored in session */
$GLOBALS['lang']['core']['login']['no_session'] = 'no token stored in session, connect with guest';
/* token stored in session */
$GLOBALS['lang']['core']['login']['session'] = 'token stored in session';
/* bad token */
$GLOBALS['lang']['core']['login']['bad_credential'] = 'token invalid';
/** [/LOGIN] **/

/** [TYPE] **/
/* unknown type */
$GLOBALS['lang']['core']['type']['unknown'] = 'unknown type'
/** [/TYPE] **/

?>
