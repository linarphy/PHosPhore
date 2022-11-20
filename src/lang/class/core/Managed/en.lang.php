<?php

/** [add] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['add']['start'] = 'start to insert the object {class} in the database';
/* error during the query */
$GLOBALS['lang']['class']['core']['Managed']['add']['unknown_error'] = 'unknown error during the query to insert the object {class} in the database';
/* success */
$GLOBALS['lang']['class']['core']['Managed']['add']['success'] = 'successfully inserted the object {class} in the database';
/* an error occured in the \core\Manager class */
$GLOBALS['lang']['class']['core']['Managed']['add']['manager_error'] = 'an error occured in the manager when inserting the object {class} in the database: {exception}';
/* error */
$GLOBALS['lang']['class']['core']['Managed']['add']['error'] = 'an error occured when inserting the object {class} in the database: {exception}';
/** [/add] **/

/** [arrDisp] **/
/* error when using \phosphore_display() to display an object */
$GLOBALS['lang']['class']['core']['Managed']['arrDisp']['object_error'] = 'an error occured when displaying the object {element}: {exception}';
/* error when displaying an array */
$GLOBALS['lang']['class']['core']['Managed']['arrDisp']['error'] = 'an error occured when displaying an array: {exception}';
/** [/arrDisp] **/

/** [delete] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['delete']['start'] = 'start to delete the object {class} in the database';
/* the object is not in the database */
$GLOBALS['lang']['class']['core']['Managed']['delete']['not_exist'] = 'the object {class} cannot be deleted because it is not in the database';
/* the index of the object is missing */
$GLOBALS['lang']['class']['core']['Managed']['delete']['missing_index'] = 'the object {class} cannot be deleted because its index is missing';
/* success */
$GLOBALS['lang']['class']['core']['Managed']['delete']['success'] = 'the object {class} has been deleted from the database';
/* error in the manager delete request */
$GLOBALS['lang']['class']['core']['Managed']['delete']['manager_error'] = 'an error occured in the manager when deleting the object {class}: {exception}';
/* error in delete request */
$GLOBALS['lang']['class']['core']['Managed']['delete']['error'] = 'cannot delete the object {object}: {exception}';
/** [/delete] **/

/** [exist] **/
/* index missing */
$GLOBALS['lang']['class']['core']['Managed']['exist']['missing_index'] = 'cannot check the existence of the object {class} because the index is not defined';
/* error in the manager exist request */
$GLOBALS['lang']['class']['core']['Managed']['exist']['manager_error'] = 'an error occured in the manager when checking the existence of the object {class}: {exception}';
/* error in exist request */
$GLOBALS['lang']['class']['core']['Managed']['exist']['error'] = 'cannot check the existence of the object {class}: {exception}';
/** [/exist] **/

/** [getIndex] **/
/* index attribute is not a string */
$GLOBALS['lang']['class']['core']['Managed']['getIndex']['type_attribute'] = 'attributes of the class {class} should be strings, {type} given';
/* error when getting the value of the attribute */
$GLOBASL['lang']['class']['core']['Managed']['getIndex']['get_error'] = 'cannot get the value of the attribute {attribute} of the class {class}: {exception}';
/* index attribute not defined */
$GLOBALS['lang']['class']['core']['Managed']['getIndex']['null_attribute'] = 'attribute {attribute} is an index but is not defined';
/* error when getting index of this object */
$GLOBALS['lang']['class']['core']['Managed']['getIndex']['error'] = 'cannot get index of the object {class}: {exception}';
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
/* index attribute is not a string */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['type_attribute'] = 'attributes of the class {class} should be string, {type} given';
/* error when getting index of this object */
$GLOBALS['lang']['class']['core']['Managed']['isIdentical']['get_error'] = 'cannot get the value of the attribute {attribute} of the class {class}: {exception}';
/* error when checking if these two objects are identical */
$GLOBASL['lang']['class']['core']['Managed']['isIdentical']['error'] = 'cannot check if the object of the class {class_1} and the object of the class {class_2} are the same: {exception}';
/** [/isIdentical] **/

/** [manager] **/
/* start */
$GLOBALS['lang']['class']['core']['Managed']['manager']['start'] = 'starting to create an instance of the associated manager of {class}';
/* manager class not found */
$GLOBALS['lang']['class']['core']['Managed']['manager']['not_defined'] = 'cannot found the associated manager class of {class}';
/* error during manager construction */
$GLOBALS['lang']['class']['core']['Managed']['manager']['manager_error'] = 'an error occured in manager construction of the class {class}: {exception}';
/* end */
$GLOBALS['lang']['class']['core']['Managed']['manager']['end'] = 'successfully found manager class associated to {class}';
/* error when creating a manager instance */
$GLOBALS['lang']['class']['core']['Managed']['manager']['error'] = 'cannot create an instance of the associated manager of {class}: {exception}';
/** [/manager] **/

/** [retrieve] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['start'] = 'start the retrieval of {class}';
/* object not defined (not exist) */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['not_defined'] = 'cannot retrieve {class} because it does not exist';
/* index attribute is not a string */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['type_attribute'] = 'attributes of the class {class} should be string, {type} given';
/* error when getting index of this object */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['get_error'] = 'cannot get the value of the attribute {attribute} of the class {class}: {exception}';
/* end of the process */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['end'] = '{class} retrieved';
/* error when retrieving the object */
$GLOBALS['lang']['class']['core']['Managed']['retrieve']['error'] = 'cannot retrieve values of the object {class}: {exception}';
/** [/retrieve] **/

/** [update] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['update']['start'] = 'start to update {class}';
/* object not exist */
$GLOBALS['lang']['class']['core']['Managed']['update']['not_exist'] = 'this instance of {class} does not exist';
/* missing index */
$GLOBALS['lang']['class']['core']['Managed']['update']['missing_index'] = 'at least one index of {class} is not defined: {exception}';
/* error in manager when updating database value */
$GLOBALS['lang']['class']['core']['Managed']['update']['manager_error'] = 'an error occured in the manager when updating the object {class}: {exception}';
/* error when updating the object */
$GLOBALS['lang']['class']['core']['Managed']['update']['error'] = 'cannot update values of the object {class}: {exception}';
/** [/update] **/

?>
