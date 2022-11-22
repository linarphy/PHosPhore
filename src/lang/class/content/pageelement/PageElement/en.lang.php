<?php

/** [__construct] **/
/* error in hydratation */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['error_hydrate'] = 'an error occured when hydrating the class {class}: {exception}';
/* error during construction of this object */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['__construct']['error'] = 'cannot construct the class {class}: {exception}';
/** [/__construct] **/

/** [addElement] **/
/* start the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['start'] = 'trying to add {key} with a value of {value} in the elements attributes';
/* success */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['success'] = 'successfuly added {key} => {value} to elements attribute';
/* failure, key already taken */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['identical_key'] = 'the key {key} is already taken, cannot change its value to {value}';
/* error when add element to this object */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addElement']['error'] = 'cannot add the element {key} with the value {value} for {class}: {exception}';
/** [/addElement] **/

/** [addValueElement] **/
/* start the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['start'] = 'trying to add {new_key} to the array {key} of the elements attribute';
/* the element does not exist */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['unknown_key'] = 'the key {key} does not exist, cannot add a key {new_key}';
/* an error occured when getting the element with the given key */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['error_get'] = 'an error occured when getting the value of the element {key}: {exception}';
/* the value associated with the key $key in elements attribute is not an array */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['not_array'] = 'the value associated to the key {key} in the elements attribute is not an array, cannot add {new_key} to another object than array';
/* success */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['success'] = 'successfuly added {new_key} to the array associated to {key} of the elements attribute';
/* the $new_key is already taken */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['already_taken'] = 'the key {new_key} of the array associated to the key {key} of the elements attribute is already taken, cannot change its value';
/* an error occured when adding a value to an element */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['addValueElement']['error'] = 'cannot add the key {new_key} the the element {key} for the class {class}: {exception}';
/** [/addValueElement] **/

/** [display] **/
/* start the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['start'] = 'starting to display the \\content\\pageeelement\\PageElement';
/* an error occured when displaying an attribute by using the class Base */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_display'] = 'an error occured when displaying the attribute {attribute} with the default method: {exception}';
/* using the cache */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['use_cache'] = 'cache used for the template {template}';
/* no file template */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_file_template'] = 'the template file {template} does not exist, using the same behavior than with an empty content';
/* no template */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_template'] = 'there is no template to use to display the content, the content will be all elements of the PageElement in a row';
/* an error occured when getting the template */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_get'] = 'an error occured when getting the template element: {exception}';
/* there are elements to display (at least one) */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['elements'] = 'there is at least one element to display';
/* an error occured when using the custom displayer to display an element of the array of elements */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_element_display'] = 'an error occured when using the dislay method of the class {element_class}: {exception}';
/* an error occured when using displayArray to display an element */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error_displayArray'] = 'an error occured when displaying an array with the default method: {exception}';
/* the content will not be displayed as a list of item without consideration to key value */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['content'] = 'the content is not empty, the content will not be displayed as all elements next to each other, in a row';
/* the object cannot be displayed because it does not have a display method */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['cannot_display_object'] = 'the object of the class {object} cannot be displayed because it does not possess a display method';
/* the content will be displayed as a list of item whithout taking key value into consideration */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['no_content'] = 'the content is empty, the content will be displayed as all elements newt to each other, in a row';
/* end of the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['end'] = '\\content\\pageelement\\PageElement displayed';
/* an error occured when displaying this pageelement */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['display']['error'] = 'cannot display this {class}: {exception}';
/** [/display] **/

/** [displayArray] **/
/* the object cannot be displayed because it does not have a display method */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['displayArray']['cannot_display_object'] = 'the object of the class {object} cannot be displayed in the array because it does not possess a display method';
/** [/displayArray] **/

/** [getElement] **/
/* start the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['start'] = 'trying to get the element {key}';
/* attribute elements is null */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['elements_null'] = 'attribute elements not defined, defined to an empty array';
/* element found */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['success'] = 'element {key} found';
/* element not found */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['getElement']['failure'] = 'element {key} not found';
/** [/getElement] **/

/** [setElement] **/
/* start the process */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['start'] = 'trying to set the element {key} to the value {value} with a {strict} strict';
/* value changed */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['change'] = 'the element {key} has now the value {value}';
/* value added */
$GLOBALS['lang']['class']['content']['pageelement']['PageElement']['setElement']['add'] = 'because of the strict setting (False), the element {key} was added to the elements list with a value {value}, because it did not exist before';
/** [/setElement] **/

?>
