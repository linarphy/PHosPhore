<?php

/** [buildNode] **/
/* start the process */
$GLOBALS['lang']['class']['route']['Router']['buildNode']['start'] = 'starting to build the node to check the route path';
/* empty array */
$GLOBALS['lang']['class']['route']['Router']['buildNode']['empty_array'] = 'no available route, cannot construct the node';
/* last level route */
$GLOBALS['lang']['class']['route']['Router']['buildNode']['last'] = 'last node build (no more route to try)';
/* end of the process */
$GLOBALS['lang']['class']['route']['Router']['buildNode']['end'] = 'node built';
/** [/buildNode] **/

/** [cleanParameters] **/
/* start the process */
$GLOBALS['lang']['class']['route']['Router']['cleanParameters']['start'] = 'start to clean the parameters of {page}';
/* parameter found */
$GLOBALS['lang']['class']['route']['Router']['cleanParameters']['found'] = 'parameter {name} with the value {value} corresponding to {regex} has been found in the {page}';
/* missing parameter */
$GLOBALS['lang']['class']['route']['Router']['cleanParameters']['missing'] = 'parameter {name} with the value {value} corresponding to {regex} has not been found in the {page} and is necessary';
/* end of the process */
$GLOBALS['lang']['class']['route']['Router']['cleanParameters']['end'] = 'parameters cleaned';
/** [/cleanParameters] **/

/** [createLink] **/
/* empty array */
$GLOBALS['lang']['class']['route']['Router']['createLink']['empty'] = 'cannot create a link without any route path to a page';
/* unknown Router mode */
$GLOBALS['lang']['class']['route']['Router']['createLink']['unknown_mode'] = 'router mode {mode} does not exist';
/** [/createLink] **/

/** [createLinkGet] **/
/* empty array */
$GLOBALS['lang']['class']['route']['Router']['createLinkGet']['empty'] = 'cannot create a link with GET mode without any route path to a page';
/* path not found */
$GLOBALS['lang']['class']['route']['Router']['createLinkGet']['not_found'] = 'cannot get the path of the route {route}';
/* path is file */
$GLOBALS['lang']['class']['route']['Router']['createLinkGet']['file'] = '{file} is a file';
/* link created */
$GLOBALS['lang']['class']['route']['Router']['createLinkGet']['success'] = 'link created: {link}';
/** [/createLinkGet] **/

/** [createLinkMixed] **/
/* empty array */
$GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['empty'] = 'cannot create a link with MIXED mode without any route path to a page';
/* path not found */
$GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['not_found'] = 'cannot get the path of the route {route}';
/* path is file */
$GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['file'] = '{file} is a file';
/* link created */
$GLOBALS['lang']['class']['route']['Router']['createLinkMixed']['success'] = 'link created: {link}';
/** [/createLinkMixed] **/

/** [createLinkRoute] **/
/* empty array */
$GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['empty'] = 'cannot create a link with ROUTE mode without any route path to a page';
/* path not found */
$GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['not_found'] = 'cannot get the path of the route {route}';
/* path is file */
$GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['file'] = '{file} is a file';
/* link created */
$GLOBALS['lang']['class']['route']['Router']['createLinkRoute']['success'] = 'link created: {link}';
/** [/createLinkRoute] **/

/** [decodeRoute] **/
/* empty url */
$GLOBALS['lang']['class']['route']['Router']['decodeRoute']['empty'] = 'cannot decode an empty url';
/* unknown Router mode */
$GLOBALS['lang']['class']['route']['Router']['decodeRoute']['unknown_mode'] = 'router mode {mode} does not exist';
/* route not found **/
$GLOBALS['lang']['class']['route']['Router']['decodeRoute']['404'] = 'cannot get the route associated to the url {url}';
/** [/decodeRoute] **/

/** [decodeWithGet] **/
/* path not defined */
$GLOBALS['lang']['class']['route']['Router']['decodeWithGet']['no_path'] = 'no path found in the url';
/** [/decodeWithGet] **/

/** [decodeWithMixed] **/
/* unknown route */
$GLOBALS['lang']['class']['route']['Router']['decodeWithMixed']['unknown_route'] = 'unknown route for {url}';
/** [/decodeWithMixed] **/

/** [decodeWithRoute] **/
/* start to decode parameter list */
$GLOBALS['lang']['class']['route']['Router']['decodeWithRoute']['start_parameter_list'] = 'start to decode parameters list';
/** [/decodeWithRoute] **/

/** [setMode] **/
/* unknown mode */
$GLOBALS['lang']['class']['route']['Router']['setMode']['unknown'] = 'unknown mode {mode}';
/** [/setMode] **/

?>
