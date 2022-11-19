<?php

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

/** [update] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Managed']['update']['start'] = 'start to update {class}';
/* object not exist */
$GLOBALS['lang']['class']['core']['Managed']['update']['not_exist'] = 'this instance of {class} does not exist';
/* missing index */
$GLOBALS['lang']['class']['core']['Managed']['update']['missing_index'] = 'at least one index of {class} is not defined';
/** [/update] **/

?>
