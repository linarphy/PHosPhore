<?php

$LANG =& $GLOBALS
         ['lang']
         ['class']
         ['core']
         ['Base'];

/** [__construct] **/
/* construct the object */
$LANG['__construct']['start'] = 'constructing a {class} instance';
/* cannot hydrate the object */
$LANG['__construct']['error_hydrate'] = 'cannot hydrate the object 
{class}: {exception}';
/* cannot construct the object */
$LANG['__construct']['error'] = 'cannot construct a {class} instance: 
{exception}';
/** [/__construct] **/

/** [clone] **/
/* cloning the object */
$LANG['clone']['start'] = 'cloning the object {class}';
/* cannot convert this object into an array */
$LANG['clone']['error_table'] = 'cannot convert the object {class} into 
a table: {exception}';
/* error during object cloning */
$LANG['clone']['error'] = 'an error occured when cloning the object 
{class}: {exception}';
/** [/clone] **/

/** [display] **/
/* start the process */
$LANG['display']['start'] = 'start to display {attribute} of {class}';
/* cannot convert this object in array */
$LANG['display']['error_table'] = 'cannot convert the object {class} 
into an array: {exception}';
/* error in \phosphore_display */
$LANG['display']['error_display'] = 'cannot display the converted array 
from {class} into a string: {exception}';
/* display the entire object */
$LANG['display']['object'] = 'display the entire object {class}';
/* the attribute does not exist */
$LANG['display']['undefined'] = 'cannot display the attribute 
{attribute} of {class} because it does not exist';
/* cannot get display method for this attribute */
$LANG['display']['error_getDisp'] = 'cannot get the method to display 
the attribute {attribute} from the class {class}: {exception}';
/* the method to display this attribute exist */
$LANG['display']['exist'] = 'custom method {method} used to display 
the attribute {attribute} of {class}';
/* the custom method to display this attribute threw an error */
$LANG['display']['custom_method_error'] = 'an error occured in the 
custom method {method} used to display the attribute {attribute} of 
class {class}: {exception}';
/* cannot get the attribute value */
$LANG['display']['get_attribute'] = 'cannot get the value of the 
attribute {attribute} from the class {class}: {exception}';
/* the method to display this attribute does not exist */
$LANG['display']['not_exist'] = 'no custom method {method} found, 
default method used to display the attribute {attribute} of {class}';
/* error in \phosphore_display when displaying the attribute value (not
 * itself) */
$LANG['display']['error_display_attribute'] = 'cannot display the 
attribute {attribue} from {class}: {exception}';
/* an error occured when displaying an attribute */
$LANG['display']['error'] = 'an error occured and the element 
{attribute} of the object {class} could not be displayed: {exception}';
/** [/display] **/

/** [get] **/
/* start of the process */
$LANG['get']['start'] = 'trying to get the attribute {attribute} of the 
object {class}';
/* attribute not defined */
$LANG['get']['not_defined'] = 'cannot get the attribute {attribute} of 
{class} because it does not exist';
/* getGet threw an exception */
$LANG['get']['error_getGet'] = 'an error occured when getting name of 
the getter method for the attribute {attribute} from the class {class}: 
{exception}';
/* the custom method to get this attribute threw an error */
$LANG['get']['error_custom_method'] = 'an error occured in the custom 
method {method} used to get the attribut {attribute} of class {class}: 
{exception}';
/* custom method exist */
$LANG['get']['getter'] = 'custom method {method} used to access the 
attribute {attribute} of {class}';
/* no custom method */
$LANG['get']['default'] = 'no custom method {method} found, default 
method used to access the attribute {attribute} of {class}';
/* cannot get the attribute of this object */
$LANG['get']['error'] = 'cannot get the attribute {attribute} of the 
class {class}: {exception}';
/** [/get] **/

/** [getDisp] **/
/* empty attribute */
$LANG['getDisp']['empty'] = 'cannot get the displayer of attribute 
{attribute} which is empty for {class}';
/* an error occured when getting the displayer of an attribute for this
 * object */
$LANG['getDisp']['empty'] = 'cannot get the displayer of the attribute 
{attribute} of the class {class}: {exception}';
/** [/getDisp] **/

/** [getGet] **/
/* empty attribute */
$LANG['getGet']['empty'] = 'cannot get the getter of an attribute 
{attribute} which is empty for {class}';
/* special attribute */
$LANG['getGet']['special'] = 'the method for the attribute {attribute} 
for {class} is already used for something else, the getter name 
associated to it is different: {method}';
/* an error occured when getting the getter of the attribute of this
 * object */
$LANG['getGet']['error'] = 'cannot get the getter of the attribute 
{attribute} of class {class}: {exception}';
/** [/getGet] **/

/** [getSet] **/
/* empty attribute */
$LANG['getSet']['empty'] = 'cannot get the setter of an attribute 
{attribute} wich is empty for {class}';
/* an error occured when getting the setter of an attribute of this
 * object */
$LANG['getSet']['error'] = 'cannot get the setter of the attribute 
{attribute} of class {class}: {exception}';
/** [/getSet] **/

/** [hydrate] **/
/* start hydrating */
$LANG['hydrate']['start'] = 'start hydratation of {class}';
/* the attribute is not a string */
$LANG['hydrate']['type_attribute'] = 'an attribute of {class} should be 
a string, {type} given';
/* error when setting a value to the attribute */
$LANG['hydrate']['error_set'] = 'cannot set a value to the attribute 
{attribute} of class {class}: {exception}';
/* end hydrating */
$LANG['hydrate']['end'] = 'hydratation of {class} finished, {count} 
attributes stored';
/* error when hydrating an object */
$LANG['hydrate']['error'] = 'cannot hydrate an object of the class 
{class}: {exception}';
/** [/hydrate] **/

/** [set] **/
/* start the process */
$LANG['set']['start'] = 'start to set a value for the attribute 
{attribute} of {class}';
/* attribute does not exist */
$LANG['set']['undefined'] = 'cannot set a value for the attribute 
{attribute} of {class} because this attribute does not exist in this 
class';
/* error when generating setter name for the attribute of this object */
$LANG['set']['error_getSet'] = 'error occured in generating setter name 
for the attribute {attribute} of {class}: {exception}';
/* custom method exists */
$LANG['set']['custom_method'] = 'custom setter found: {method} , 
defining {attribute} for {class}';
/* custom method threw an error */
$LANG['set']['error_custom_method'] = 'an error occured in the custom 
method {method} for setting the attribute {attribute} of {class}: 
{exception}';
/* no custom method */
$LANG['set']['default_method'] = 'custom setter not found, defining 
{attribute} for {class} with default method';
/* error when setting an attribute */
$LANG['set']['error'] = 'cannot set a valur for the attribute 
{attribute} of {class}: {exception}';
/** [/set] **/

/** [table] **/
/* start the process */
$LANG['table']['start'] = 'start to convert {class} into an array 
(depth: {depth})';
/* depth value not accepted */
$LANG['table']['undefined_depth'] = 'depth {depth} is not valid for 
converting {class} into an array';
/* an error occured when converting the object into a table */
$LANG['table']['error'] = 'an error occured when converting the object 
into a table with de depth {depth}, with the mode strict {strict} for 
the class {class}: {exception}';
/** [/table] **/

?>
