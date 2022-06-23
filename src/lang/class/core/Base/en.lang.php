<?php

/** [__construct] **/
/* construct the object */
$GLOBALS['lang']['class']['core']['Base']['__construct'] = 'constructing a {class} instance';
/** [/__construct] **/

/** [clone] **/
/* cloning the object */
$GLOBALS['lang']['class']['core']['Base']['clone'] = 'cloning the object {class}';
/** [/clone] **/

/** [display] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Base']['display']['start'] = 'start to display {attribute} of {class}';
/* display the entire object */
$GLOBALS['lang']['class']['core']['Base']['display']['object'] = 'display the entire object {class}';
/* the attribute does not exist */
$GLOBALS['lang']['class']['core']['Base']['display']['undefined'] = 'cannot display the attribute {attribute} of {class} because it does not exist';
/* the method to display this attribute exist */
$GLOBALS['lang']['class']['core']['Base']['display']['exist'] = 'custom method {method} used to display the attribute {attribute} of {class}';
/* the method to display this attribute does not exist */
$GLOBALS['lang']['class']['core']['Base']['display']['not_exist'] = 'no custom method {method} found, default method used to display the attribute {attribute} of {class}';
/** [/display] **/

/** [get] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Base']['get']['start'] = 'trying to get the attribute {attribute} of the object {class}';
/* attribute not defined */
$GLOBALS['lang']['class']['core']['Base']['get']['not_defined'] = 'cannot get the attribute {attribute} of {class} because it does not exist';
/* custom method exist */
$GLOBALS['lang']['class']['core']['Base']['get']['getter'] = 'custom method {method} used to access the attribute {attribute} of {class}';
/* no custom method */
$GLOBALS['lang']['class']['core']['Base']['get']['default'] = 'no custom method {method} found, default method used to access the attribute {attribute} of {class}';
/** [/get] **/

/** [getDisp] **/
/* empty attribute */
$GLOBALS['lang']['class']['core']['Base']['getDisp']['empty'] = 'cannot get the displayer of attribute {attribute} which is empty for {class}';
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
/** [/table] **/

?>
