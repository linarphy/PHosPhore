<?php

/** [__construct] **/
/* construction of the object */
$GLOBALS['lang']['class']['core']['Manager']['__construct'] = 'constructing the {class}';
/** [/__construct] **/

/** [add] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['add']['start'] = '{class} start to add a row in the database';
/* item to add does not have any attributes */
$GLOBALS['lang']['class']['core']['Manager']['add']['no_attributes'] = '{class} cannot add an item in the database without any attribute';
/* query $query constructed */
$GLOBALS['lang']['class']['core']['Manager']['add']['query'] = '{class} query constructed: {query}';
/* success */
$GLOBALS['lang']['class']['core']['Manager']['add']['success'] = '{class} successfully added a row in the database';
/** [/add] **/

/** [boundaryInterpreter] **/
/* start of the process */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['start'] = '{class} starting creating LIMIT clause with the boundary interpreter';
/** [group] **/
/* group element of the argument array is not an array */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['not_array'] = '{class} cannot create GROUP BY clause, incorrect argument given: the group element of the array must be an array composed of 3 elements: attribute, operations and having';
/* the attribute element of the group element does not exist */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['missing_key'] = '{class} cannot create GROUP BY clause, incorrect argument given: the group element must have an attribute key to be valid';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['group']['end'] ='{class} query constructed for GROUP BY: {query}';
/** [/group] **/
/** [order] **/
/* order element of the argument array is not an array */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['not_array'] = '{class} cannot create ORDER BY clause, incorrect argument given: the order element of the array must be an array composed of 2 elements: name, and diretion';
/* the name element does not exist or is not in the list of the class'attributes */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['unknown_name'] = '{class} cannot create ORDER BY clause, incorrect argument given: the order element must have a valid name element';
/* direction must be ASC or DESC to be valid */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['direction'] = '{class} cannot create ORDER BY clause, direction element is not "ASC" or "DESC"';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['order']['end'] = '{class} query constructed for ORDER BY: {query}';
/** [/order] **/
/** [limit] **/
/* limit element of the argument array is not an array */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['not_array'] = '{class} cannot create LIMIT clause, incorrect argument given: the limit element of the array must be an array composed of 2 elements: number, and offset';
/* invalid value for number or/and offset */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['invalid'] = '{class} cannot create the LIMIT clause, incorrect argument given: the number and the offset element of the limit element must be integer';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['limit']['end'] = '{class} query constructed for LIMIT: {query}';
/** [/limit] **/
/* unknown element in the argument array */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['unknown_key'] = '{class} the element with the key {key} is not supported, only order, group and limit are';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['boundaryInterpreter']['end'] = '{class} final query constructed: {query}';
/** [/boundaryInterpreter] **/

/** [conditionCreator] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['start'] = '{class} start creating condition (WHERE) clause';
/* no value given */
$GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['no_values'] = '{class} cannot create the condition, no values given';
/* no operation given for a value */
$GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['missing_operation'] = '{class} cannot create the condition, no operation given for the attribute {attribute}';
/* no array given for IN operation */
$GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['empty'] = '{class} cannot get IN operation for the attribute {attribute} because IN operation need an array of value not empty to be used';
/* operation not in the whitelist */
$GLOBALS['lang']['class']['core']['Manager']['conditionCreator']['not_in_whitelist'] = '{class} cannot create the condition, the operation {operation} is not in the list of valid operation';
/** [/conditionCreator] **/

/** [count] **/
/* counting element of the database */
$GLOBALS['lang']['class']['core']['Manager']['count'] = '{class} counting elements in the database';
/** [/count] **/

/** [countBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['countBy']['start'] = '{class} starting to count elements respecting a condition in the database';
/* no values given */
$GLOBALS['lang']['class']['core']['Manager']['countBy']['values'] = '{class} cannot create condition without values';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['countBy']['end'] = '{class} query constructed: {query}';
/** [/countBy] **/

/** [delete] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['delete']['start'] = '{class} starting to delete an element of the database';
/* missing index */
$GLOBALS['lang']['class']['core']['Manager']['delete']['missing_index'] = '{class} cannot delete an element of the database because the index {attribute} is missing';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['delete']['end'] = '{class} query constructed: {query}';
/** [/delete] **/

/** [deleteBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['deleteBy']['start'] = '{class} starting to delete elements respecting a condition in the database';
/* empty values */
$GLOBALS['lang']['class']['core']['Manager']['deleteBy']['values'] = '{class} cannot delete elements respecting a condition in the database because values is empty, so there is no condition';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['deleteBy']['end'] = '{class} query constructed: {query}';
/** [/deleteBy] **/

/** [exist] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['exist']['start'] = '{class} starting to check the existence of an element in the database';
/* missing index */
$GLOBALS['lang']['class']['core']['Manager']['exist']['missing_index'] = '{class} cannot check the existence of an element in the database because the index {attribute} is missing';
/* there is more than one element with the same index */
$GLOBALS['lang']['class']['core']['Manager']['exist']['more_one_index'] = '{class} there is more than one element ({number}) for the same index';
/** [/exist] **/

/** [existBy] **/
/* check if there is at least one element which respect a condition */
$GLOBALS['lang']['class']['core']['Manager']['existBy'] = '{class} check if there is at least one element which respect a condition';
/** [/existBy] **/

/** [get] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['get']['start'] = '{class} starting to get an element in the database';
/* missing index */
$GLOBALS['lang']['class']['core']['Manager']['get']['missing_index'] = '{class} cannot get the element in the database because the index {attribute} is missing';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['get']['end'] = '{class} query constructed: {query}';
/** [/get] **/

/** [getBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['getBy']['start'] = '{class} starting to get elements respecting a condition in the database';
/* empty values */
$GLOBALS['lang']['class']['core']['Manager']['getBy']['values'] = '{class} cannot get eleements respecting a condition in the database because values is empty, so there is no condition';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['getBy']['end'] = '{class} query constructed: {query}';
/** [/getBy] **/

/** [getIdBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['getIdBy']['start'] = '{class} starting to get index of elements respecting a condition in the database';
/* empty values */
$GLOBALS['lang']['class']['core']['Manager']['getIdBy']['values'] = '{class} cannot get index of elements respecting a condition in the database because values is empty, so there is no condition';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['getIdBy']['end'] = '{class} query constructed: {query}';
/** [/getIdBy] **/

/** [getIdByPos] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['start'] = '{class} starting to get index of elements by checking their position in the database';
/* invalid type for arguments */
$GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['invalid_data'] = '{class} invalid types for some arguments';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['getIdByPos']['end'] = '{data} query constructed: {query}';
/** [/getIdByPos] **/

/** [getNextId] **/
/* get next value of the index */
$GLOBALS['lang']['class']['core']['Manager']['getNextId'] = '{class} getting next value of the index in the database';
/** [/getNextId] **/

/** [managed] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['managed']['start'] = '{class} creating an instance of the Managed class associated to this one';
/* the calculated class was not found */
$GLOBALS['lang']['class']['core']['Manager']['managed']['not_defined'] = '{class} class {managed} not found';
/** [/managed] **/

/** [retrieveBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['start'] = '{class} starting to retrieve object with data stored in the database matching a condition';
/* custom class not defined */
$GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_not_defined'] = '{class} class {managed} not found, cannot retrieve object of this class';
/* custom class manager not defined */
$GLOBALS['lang']['class']['core']['Manager']['retrieveBy']['custom_class_manager_not_defined'] = '{class} class {manager} not found, cannot retrieve object not directly linked to this database';
/* objects retrieved */
$GLOBALS['lang']['class']['core']['Manager']['retrievedBy']['end'] = '{class} objects retrieved';
/** [/retrieveBy] **/

/** [setDb] **/
/* trying to set a db which is not an instance of \PDO */
$GLOBALS['lang']['class']['core']['Manager']['seetDb'] = '{class} cannot set db to this new value because this is not an instance of \PDO';
/** [/setDb] **/

/** [update] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['update']['start'] = '{class} starting to update an element of the database';
/* missing index */
$GLOBALS['lang']['class']['core']['Manager']['update']['missing_index'] = '{class} cannot update an element of the database because the index {attribute} is missing';
/* values */
$GLOBALS['lang']['class']['core']['Manager']['update']['values'] = '{class} cannot update an element of the database because the values to replace are empty';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['udpate']['end'] = '{class} query constructed: {query}';
/** [/update] **/

/** [updateBy] **/
/* start the process */
$GLOBALS['lang']['class']['core']['Manager']['updateBy']['start'] = '{class} starting to update elements respecting a condition in the database';
/* empty values */
$GLOBALS['lang']['class']['core']['Manager']['updateBy']['values'] = '{class} cannot update elements respecting a condition in the database because the values to make the condition or modification are empty';
/* end, query constructed */
$GLOBALS['lang']['class']['core']['Manager']['updateBy']['end'] = '{class} query constructed: {query}';
/** [/updateBy] **/

?>
