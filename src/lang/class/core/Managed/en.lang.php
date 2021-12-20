<?php

/** [__construct] **/
/* construct the object */
$GLOBALS['lang']['class']['core']['Managed']['__construct'] = 'constructing a {class} instance';
/** [/__construct] **/

/** [add] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['add']['start'] = 'start to insert the object {class} in the database';
/* error during the query */
$GLOBALS['lang']['class']['core']['Managed']['add']['error'] = 'error during the query to insert the object {class} in the database';
/* success */
$GLOBALS['lang']['class']['core']['Managed']['add']['success'] = 'successfully inserted the object {class} in the database';
/** [/add] **/

/** [clone] **/
/* cloning the object */
$GLOBALS['lang']['class']['core']['Managed']['clone'] = 'cloning the object {class}';
/** [/clone] **/

/** [delete] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['delete']['start'] = 'start to delete the object {class} in the database';
/* the object is not in the database */
$GLOBALS['lang']['class']['core']['Managed']['delete']['not_exist'] = 'the object {class} cannot be deleted because it is not in the database';
/* the index of the object is missing */
$GLOBALS['lang']['class']['core']['Managed']['delete']['missing_index'] = 'the object {class} cannot be deleted because its index is missing';
/* success */
$GLOBALS['lang']['class']['core']['Managed']['delete']['success'] = 'the object {class} has been deleted from the database';
/** [/delete] **/

/** [displayer] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['displayer']['start'] = 'start to display the attribute {attribute} of the class {class}';
/* the method to display this attribute exist */
$GLOBALS['lang']['class']['core']['Managed']['displayer']['exist'] = 'a custom method exist to display the attribute {attribute} of the class {class}';
/* the method to display this attribute does not exist, using the default one */
$GLOBALS['lang']['class']['core']['Managed']['displayer']['not_exist'] = 'no custom method found to display the attribute {attribute} of the class {class}, the default method will be used';
/** [/displayer] **/

/** [exist] **/
/* index missing */
$GLOBALS['lang']['class']['core']['Managed']['exist']['missing_index'] = 'cannot check the existence of the object {class} because the index is not defined';
/** [/exist] **/

/** [hydrate] **/
/* start hydrating */
$GLOBALS['lang']['class']['core']['Managed']['hydrate']['start'] = 'start hydratation of {class}';
/* end hydrating */
$GLOBALS['lang']['class']['core']['Managed']['hydrate']['end'] = 'hydratation of {class} finished, {count} attributes stored';
/** [/hydrate] **/

/** [get] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Managed']['get']['start'] = 'trying to get the attribute {attribute} of the object {class}';
/* attribute not defined */
$GLOBALS['lang']['class']['core']['Managed']['get']['not_defined'] = 'attribute {attribute} of {class} is not defined';
/* custom method exist */
$GLOBALS['lang']['class']['core']['Managed']['get']['getter'] = 'custom method found for accessing the attribute {attribute} of the class {class}';
/* no custom method */
$GLOBALS['lang']['class']['core']['Managed']['get']['default'] = 'no custom method found for accessing the attribute {attribute} of the class {class}, default one will be used';
/** [/get] **/

/** [getIndex] **/
/* index attribute not defined */
$GLOBALS['lang']['class']['core']['Managed']['getIndex'] = 'attribute {attribute} is an index but is not defined';
/** [/getIndex] **/

/** [isIdentical] **/
/* start the check */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['start'] = 'start checking if {class_1} and {class_2} are identical';
/* not the same class */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_class'] = '{class_1} and {class_2} are not the same class';
/* missing index */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['missing_index'] = 'at least one index attribute of {class_1} or {class_2} is missing (attribute {attribute})';
/* not the same index value */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['dif_index'] = 'the value of {attribute} is different in {class_1} and {class_2}';
/* same object */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['same'] = '{class_1} and {class_2} ared identical';
/** [/isIdentical] **/

/** [manager] **/
/* start */
$GLOBALS['lang']['class']['core']['Managed']['manager']['start'] = 'starting to create an instance of the associated manager of {class}';
/* manager class not found */
$GLOBALS['lang']['class']['core']['Managed']['manager']['not_defined'] = 'cannot found the associated manager class of {class}';
/* end */
$GLOBALS['lang']['class']['core']['Managed']['manager']['end'] = 'successfully found manager class associated to {class}';
/** [/manager] **/

/** [retrieve] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['start'] = 'start the retrieval of {class}';
/* object not defined (not exist) */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['not_defined'] = 'cannot retrieve {class} because it does not exist';
/* end of the process */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['end'] = '{class} retrieved';
/** [/retrieve] **/

/** [set] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['set']['start'] = 'start to set a value for the attribute {attribute} of the class {class}';
/* attribute does not exist */
$GLOBALS['lang']['class']['core']['Managed']['set']['undefined'] = 'cannot set a value for the attribute attribute {attribute} of the class {class} because this attribute does not exist in this class';
/* custom method exists */
$GLOBALS['lang']['class']['core']['Managed']['set']['custom_method'] = 'custom setter found: {method} , defining {attribute} for {class}';
/* attribute is typed */
$GLOBALS['lang']['class']['core']['Managed']['set']['typed_attribute'] = 'attribute {attribute} is typed for the class {class}';
/* unknown attribute type */
$GLOBALS['lang']['class']['core']['Managed']['set']['unknown_type'] = 'unknown type {type}';
/* attribute is note typed */
$GLOBALS['lang']['class']['core']['Managed']['set']['not_typed'] = 'attribute {attribute} is not typed for the class {class}';
/* no custom method */
$GLOBALS['lang']['class']['core']['Managed']['set']['default_method'] = 'custom setter not found, defining {attribute} for {class} with default method';
/** [/set] **/

/** [table] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['table']['start'] = 'start to convert {class} into an array (depth: {depth})';
/* depth value not accepted */
$GLOBALS['lang']['class']['core']['Managed']['table']['undefined_depth'] = 'depth {depth} is not valid for converting {class} into an array';
/** [/table] **/

/** [update] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['update']['start'] = 'start to update {class}';
/* object not exist */
$GLOBALS['lang']['class']['core']['Managed']['update']['not_exist'] = 'this instance of {class} does not exist';
/* missing index */
$GLOBALS['lang']['class']['core']['Managed']['update']['missing_index'] = 'at least one index of {class} is not defined';
/** [/update] **/

?>
