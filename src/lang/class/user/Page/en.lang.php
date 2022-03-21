<?php

/** [__construct] **/
/* start of the process */
$GLOBALS['lang']['class']['user']['Page']['__construct']['start'] = 'start constructing the page';
/* no attributes to hydrate */
$GLOBALS['lang']['class']['user']['Page']['__construct']['no_attributes'] = 'page cannot be constructed, attributes are empty or invalid';
/* no route defined */
$GLOBALS['lang']['class']['user']['Page']['__construct']['no_route'] = 'page cannot be constructed, id was not defined';
/* end of the process */
$GLOBALS['lang']['class']['user']['Page']['__construct']['end'] = 'page constructed';
/** [/__construct] **/

/** [addParameter] **/
/* start of the process */
$GLOBALS['lang']['class']['user']['Page']['addParameter']['start'] = 'begin to add {key} as a (temporary) parameter with the value {value} of the page';
/* trying to overwrite a parameter */
$GLOBALS['lang']['class']['user']['Page']['addParameter']['already'] = 'parameter {name} was already defined with the value of {old}, cannot overwrite with the value of {value}';
/** [/addParameter] **/

/** [display] **/
/* display the page */
$GLOBALS['lang']['class']['user']['Page']['display'] = 'displaying the Page';
/** [/display] **/

/** [load] **/
/* start the loading of the page */
$GLOBALS['lang']['class']['user']['Page']['load']['start'] = 'start to load the Page';
/* there is an existing preset */
$GLOBALS['lang']['class']['user']['Page']['load']['preset'] = 'using existing preset "{preset}" to construct the Page';
/* the number of notification fetched does not match the number of notifications deleted */
$GLOBALS['lang']['class']['user']['Page']['load']['different_number'] = 'the number of notifications fetched ({number_fetch}) does not match the number notifications deleted ({number_delete})';
/* inserting notifications */
$GLOBALS['lang']['class']['user']['Page']['load']['notifications'] = 'inserted {number} notifications elements in the main \\content\\PageElement';
/* there is no file for this page */
$GLOBALS['lang']['class']['user']['Page']['load']['no_file'] = 'cannot find the file {file} which is required to load the Page';
/* start to load the sub files */
$GLOBALS['lang']['class']['user']['Page']['load']['subfiles'] = 'start to load the Sub Files necessary to load the Page';
/* start to include the file */
$GLOBALS['lang']['class']['user']['Page']['load']['include'] = 'start to include the file {file}, which will end the loading of the Page';
/** [/load] **/

/** [retrieveParameters] **/
/* start the retrieval */
$GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['start'] = 'retrieval of Page parameters';
/* already retrieved */
$GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['already_defined'] = 'parameters already retrieved before';
/* parameters of parent loading */
$GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['loading_parameters'] = 'loading parameter of parent route';
/* parameteres of this parent is already loaded */
$GLOBALS['lang']['class']['user']['Page']['retrievedParameters']['already_loaded'] = 'parameters of this parent already loaded';
/* no parameteres to load, root route */
$GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['root_parameters'] = 'root page, no more parameters to load';
/* parameters retrieved */
$GLOBALS['lang']['class']['user']['Page']['retrieveParameters']['loaded'] = 'retrieved {number} parameters for the Page';
/** [/retrieveParameters] **/

/** [retrieveRoute] **/
/* the route does not exist */
$GLOBALS['lang']['class']['user']['Page']['retrieveRoute']['no_exist'] = 'the route associated to this page does not exist';
/* route already retrieved */
$GLOBALS['lang']['class']['user']['Page']['retrieveRoute']['already_defined'] = 'route already retrieved';
/** [/retrieveRoute] **/

?>
