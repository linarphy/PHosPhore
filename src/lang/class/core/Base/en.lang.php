<?php

/** [__construct] **/
/* construct the object */
$GLOBALS['lang']['class']['core']['Base']['__construct']['start'] = 'constructing a {class} instance';
/* cannot hydrate the object */
$GLOBALS['lang']['class']['core']['Base']['__construct']['error_hydrate'] = 'cannot hydrate the object {class}: {exception}';
/* cannot construct the object */
$GLOBALS['lang']['class']['core']['Base']['__construct']['error'] = 'cannot construct a {class} instance: {exception}';
/** [/__construct] **/

/** [clone] **/
/* cloning the object */
$GLOBALS['lang']['class']['core']['Base']['clone']['start'] = 'cloning the object {class}';
/* cannot convert this object into an array */
$GLOBALS['lang']['class']['core']['Base']['clone']['error_table'] = 'cannot convert the object {class} into a table: {exception}';
/* error during object cloning */
$GLOBALS['lang']['class']['core']['Base']['clone']['error'] = 'an error occured when cloning the object {class}: {exception}';
/** [/clone] **/

/** [display] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Base']['display']['start'] = 'start to display {attribute} of {class}';
/* cannot convert this object in array */
$GLOBALS['lang']['class']['core']['Base']['display']['error_table'] = 'cannot convert the object {class} into an array: {exception}';
/* error in \phosphore_display */
$GLOBALS['lang']['class']['core']['Base']['display']['error_display'] = 'cannot display the converted array from {class} into a string: {exception}';
/* display the entire object */
$GLOBALS['lang']['class']['core']['Base']['display']['object'] = 'display the entire object {class}';
/* the attribute does not exist */
$GLOBALS['lang']['class']['core']['Base']['display']['undefined'] = 'cannot display the attribute {attribute} of {class} because it does not exist';
/* cannot get display method for this attribute */
$GLOBALS['lang']['class']['core']['Base']['display']['error_getDisp'] = 'cannot get the method to display the attribute {attribute} from the class {class}: {exception}';
/* the method to display this attribute exist */
$GLOBALS['lang']['class']['core']['Base']['display']['exist'] = 'custom method {method} used to display the attribute {attribute} of {class}';
/* the custom method to display this attribute threw an error */
$GLOBALS['lang']['class']['core']['Base']['display']['custom_method_error'] = 'an error occured in the custom method {method} used to display the attribute {attribute} of class {class}: {exception}';
/* cannot get the attribute value */
$GLOBALS['lang']['class']['core']['Base']['display']['get_attribute'] = 'cannot get the value of the attribute {attribute} from the class {class}: {exception}';
/* the method to display this attribute does not exist */
$GLOBALS['lang']['class']['core']['Base']['display']['not_exist'] = 'no custom method {method} found, default method used to display the attribute {attribute} of {class}';
/* error in \phosphore_display when displaying the attribute value (not itself) */
$GLOBALS['lang']['class']['core']['Base']['display']['error_display_attribute'] = 'cannot display the attribute {attribue} from {class}: {exception}';
/* an error occured when displaying an attribute */
$GLOBALS['lang']['class']['core']['Base']['display']['error'] = 'an error occured and the element {attribute} of the object {class} could not be displayed: {exception}';
/** [/display] **/

/** [get] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Base']['get']['start'] = 'trying to get the attribute {attribute} of the object {class}';
/* attribute not defined */
$GLOBALS['lang']['class']['core']['Base']['get']['not_defined'] = 'cannot get the attribute {attribute} of {class} because it does not exist';
/* getGet threw an exception */
$GLOBALS['lang']['class']['core']['Base']['get']['error_getGet'] = 'an error occured when getting name of the getter method for the attribute {attribute} from the class {class}: {exception}';
/* the custom method to get this attribute threw an error */
$GLOBALS['lang']['class']['core']['Base']['get']['error_custom_method'] = 'an error occured in the custom method {method} used to get the attribut {attribute} of class {class}: {exception}';
/* custom method exist */
$GLOBALS['lang']['class']['core']['Base']['get']['getter'] = 'custom method {method} used to access the attribute {attribute} of {class}';
/* no custom method */
$GLOBALS['lang']['class']['core']['Base']['get']['default'] = 'no custom method {method} found, default method used to access the attribute {attribute} of {class}';
/** [/get] **/

/** [getDisp] **/
/* empty attribute */
$GLOBALS['lang']['class']['core']['Base']['getDisp']['empty'] = 'cannot get the displayer of attribute {attribute} which is empty for {class}';
/* an error occured when getting the displayer of an attribute for this object */
$GLOBALS['lang']['class']['core']['Base']['getDisp']['empty'] = 'cannot get the displayer of the attribute {attribute} of the class {class}: {exception}';
/** [/getDisp] **/

/** [getGet] **/
/* empty attribute */
$GLOBALS['lang']['class']['core']['Base']['getGet']['empty'] = 'cannot get the getter of an attribute {attribute} which is empty for {class}';
/* special attribute */
$GLOBALS['lang']['class']['core']['Base']['getGet']['special'] = 'the method for the attribute {attribute} for {class} is already used for something else, the getter name associated to it is different: {method}';
/** [/getGet] **/

/** [getSet] **/
/* empty attribute */
$GLOBALS['lang']['class']['core']['Base']['getSet']['empty'] = 'cannot get the setter of an attribute {attribute} wich is empty for {class}';
/** [/getSet] **/

/** [hydrate] **/
/* start hydrating */
$GLOBALS['lang']['class']['core']['Base']['hydrate']['start'] = 'start hydratation of {class}';
/* end hydrating */
$GLOBALS['lang']['class']['core']['Base']['hydrate']['end'] = 'hydratation of {class} finished, {count} attributes stored';
/** [/hydrate] **/

/** [set] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Base']['set']['start'] = 'start to set a value for the attribute {attribute} of {class}';
/* attribute does not exist */
$GLOBALS['lang']['class']['core']['Base']['set']['undefined'] = 'cannot set a value for the attribute {attribute} of {class} because this attribute does not exist in this class';
/* custom method exists */
$GLOBALS['lang']['class']['core']['Base']['set']['custom_method'] = 'custom setter found: {method} , defining {attribute} for {class}';
/* no custom method */
$GLOBALS['lang']['class']['core']['Base']['set']['default_method'] = 'custom setter not found, defining {attribute} for {class} with default method';
/** [/set] **/

/** [table] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Base']['table']['start'] = 'start to convert {class} into an array (depth: {depth})';
/* depth value not accepted */
$GLOBALS['lang']['class']['core']['Base']['table']['undefined_depth'] = 'depth {depth} is not valid for converting {class} into an array';
/* an error occured when converting the object into a table */
$GLOBALS['lang']['class']['core']['Base']['table']['error'] = 'an error occured when converting the object into a table with de depth {depth}, with the mode strict {strict} for the class {class}: {exception}';
/** [/table] **/

?>
