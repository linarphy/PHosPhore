<?php

$LANG =& $GLOBALS
		 ['lang']
		 ['class']
		 ['content']
		 ['pageelement']
         ['PageElement'];

/** [__construct] **/
/* error in hydratation */
$LANG['__construct']['error_hydrate'] = 'an error occured when hydrating 
the object {class}: {exception}';
/* error during construction of this object */
$LANG['__construct']['error'] = 'cannot construct the object {class}: 
{exception}';
/** [/__construct] **/

/** [addElement] **/
/* start the process */
$LANG['addElement']['start'] = 'trying to add {key} with a value of 
{value} in the elements list';
/* failure, key already taken */
$LANG['addElement']['identical_key'] = 'the key {key} is already taken, 
cannot change its value to {value}';
/* success */
$LANG['addElement']['success'] = 'successfuly added {key} => {value} to 
the elements list';
/* error when add element to this object */
$LANG['addElement']['error'] = 'an error occured when adding {key} with 
the value {value} to the elements list: {exception}';
/** [/addElement] **/

/** [addValueElement] **/
/* start the process */
$LANG['addValueElement']['start'] = 'trying to add {new_key} with 
a value {value} to the array {key} of the elements list';
/* an error occured when getting the element with the given key */
$LANG['addValueElement']['error_get'] = 'an error occured when getting 
the value of the elements list: {exception}';
/* the element does not exist */
$LANG['addValueElement']['unknown_key'] = 'the key {key} does not exist, 
cannot add a key {new_key}';
/* the value associated with the key $key in elements attribute is not
 * an array */
$LANG['addValueElement']['not_array'] = 'the value associated to the 
key {key} in the elements lists is not an array, cannot add 
{new_key} to another object than array';
/* the $new_key is already taken */
$LANG['addValueElement']['already_taken'] = 'the key {new_key} of the 
array associated to the key {key} of the elements lists is already 
taken, cannot change its value';
/* success */
$LANG['addValueElement']['success'] = 'successfuly added {new_key} to 
the array associated to {key} of the elements lists';
/* an error occured when adding a value to an element */
$LANG['addValueElement']['error'] = 'an error occured when adding 
{new_key} with a value of {value} to the array {key} of the elements 
list: {exception}';
/** [/addValueElement] **/

/** [display] **/
/* an error occured when displaying an attribute by using the class
 * Base */
$LANG['display']['error_display'] = 'an error occured when displaying 
the attribute {attribute} with the default method: {exception}';
/* start the process */
$LANG['display']['start'] = 'starting to display the {class}';
/* an error occured when getting the template */
$LANG['display']['error_get'] = 'an error occured when getting the 
template element: {exception}';
/* using the cache */
$LANG['display']['use_cache'] = 'cache used for the template 
{template}';
/* no file template */
$LANG['display']['no_file_template'] = 'the template file {template} 
does not exist';
/* no template */
$LANG['display']['no_template'] = 'there is no template to use to 
display the content, the content will be all elements of the 
PageElement in a row';
/* there are elements to display (at least one) */
$LANG['display']['elements'] = 'there is at least one element to 
display';
/* the content will not be displayed as a list of item without
 * consideration to key value */
$LANG['display']['content'] = 'the content is not empty, the content 
will be displayed as the template with key field filled with their 
associated value';
/* an error occured when using the custom displayer to display an
 * element of the array of elements */
$LANG['display']['error_element_display'] = 'an error occured when using
the display method of the class {element_class}: {exception}';
/* the object cannot be displayed because it does not have a display
 * method */
$LANG['display']['cannot_display_object'] = 'the object of the class 
{class} cannot be displayed because it does not possess a display 
method';
/* an error occured when using displayArray to display an element */
$LANG['display']['error_displayArray'] = 'an error occured when 
displaying an array with the default method: {exception}';
/* the content will be displayed as a list of item whithout taking key
 * value into consideration */
$LANG['display']['no_content'] = 'the content is empty, the content 
will be displayed as all elements newt to each other, in a row';
/* end of the process */
$LANG['display']['end'] = '{class} displayed';
/* an error occured when displaying this pageelement */
$LANG['display']['error'] = 'cannot display the attribute {attribute} of 
the class {class}: {exception}';
/** [/display] **/

/** [displayArray] **/
/* an error occured when using the custom displayer to display an
 * element of the array of elements */
$LANG['displayArray']['error_display'] = 'an error occured when using 
the display method of the class {element_class}: {exception}';
/* the object cannot be displayed because it does not have a display method */
$LANG['displayArray']['cannot_display_object'] = 'the object of the 
class {class} cannot be displayed in the array because it does not 
possess a display method';
$LANG['displayArray']['error_displayError'] = 'an error occured when 
displaying an array in the array to display: {exception}';
/* an error occured */
$LANG['displayArray']['error'] = 'an error occured when displaying the 
array: {exception}';
/** [/displayArray] **/

/** [getElement] **/
/* start the process */
$LANG['getElement']['start'] = 'trying to get the element {key}';
/* attribute elements is null */
$LANG['getElement']['error_get'] = 'cannot get the attribute elements: 
{exception}';
/* element not found */
$LANG['getElement']['unknown_key'] = 'element {key} not found';
/* element found */
$LANG['getElement']['success'] = 'element {key} found';
/* an error occured */
$LANG['getElement']['error'] = 'an error occured, cannot get the key 
{key} for the class {class}: {exception}';
/** [/getElement] **/

/** [setElement] **/
/* start the process */
$LANG['setElement']['start'] = 'trying to set the element {key} to the
value {value} with a {strict} strict';
/* value added */
$LANG['setElement']['add'] = 'because of the strict setting (False), the 
element {key} was added to the elements list with a value {value}, 
because it did not exist before';
/* the element does not exist */
$LANG['setElement']['error_strict'] = 'an error occured when getting the 
element with the key {key}. Due to the strict setting (True) the element 
with the value {value} could not be added to the elements list:
{exception}';
/* value changed */
$LANG['setElement']['change'] = 'the element {key} has now the value 
{value}';
/* an error occured when setting an element */
$LANG['setElement']['error'] = 'an error occured when setting the 
element {key} to the value {value} with a {strict} strict for the class
{class}: {exception}';
/** [/setElement] **/

/** [setElements] **/
/* an error occured when setting elements attribute */
$LANG['setElements']['error'] = 'an error occured when setting the 
elements attribute for the class {class}: {exception}';
/** [/setElements] **/

/** [setTemplate] **/
/* an error occured when setting template attribute */
$LANG['setTemplate']['error'] = 'an error occured when setting the 
template attribute with the value {value} for the class {class}:
{exception}';
/** [/setTemplate] **/

?>
