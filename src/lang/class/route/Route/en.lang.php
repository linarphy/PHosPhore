<?php

/** [getPath] **/
/* start the process */
$GLOBALS['lang']['class']['route']['Route']['getPath']['start'] = 'starting to get a path from route {id_root} to route {this_route}';
/* the path is the name of the route, the route is itself */
$GLOBALS['lang']['class']['route']['Route']['getPath']['found_itself'] = 'the path is the name of the route itself, because {id_root} is {this_route}';
/* infinite recursion */
$GLOBALS['lang']['class']['route']['Route']['getPath']['infinite_recursion'] = 'there is an infinite recursion in the route table (parent is a child of children) between {id_root} and {this_route}';
/* cannot find any parent to this route */
$GLOBALS['lang']['class']['route']['Route']['getPath']['no_parent'] = 'there is no parent to route {this_route}';
/* root_id is null, the route is itself */
$GLOBALS['lang']['class']['route']['Route']['getPath']['empty_id'] = 'the path is the name of the route itself because no root id has been given to reach {this_route}';
/* the path cannot be defined because it does not exist */
$GLOBALS['lang']['class']['route']['Route']['getPath']['path_not_exist'] = 'a path cannot be found because we reached a root directory (no parent) before reaching {id_root} starting from {this_route}';
/* the path has been found */
$GLOBALS['lang']['class']['route']['Route']['getPath']['found'] = 'a path has been found: {path} from {id_root} and {this_route}';
/* no path found */
$GLOBALS['lang']['class']['route']['Route']['getPath']['not_found'] = 'no path has been found between {id_root} and {this_route}';
/** [/getPath] **/

/** [loadSubFiles] **/
/* start the process */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['start'] = 'starting to load subfiles (config, locale and lang files) for {name}';
/* loading direct subfiles (not files from parent route) */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['current'] = 'loading direct subfiles for {name}';
/* list of files that will be loaded if existing */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['list_files'] = 'subfiles path generated: config files {config}, locale files {locale} and lang files {lang}';
/* config file found */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['config'] = 'config file {path} found';
/* locale file found */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['locale'] = 'locale file {path} found';
/* lang file found */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['lang'] = 'lang file {path} found';
/* end of the process */
$GLOBALS['lang']['class']['route']['Route']['loadSubFiles']['end'] = 'finished loading subfiles for {name}';
/** [/loadSubFiles] **/

/** [retrieveParameters] **/
/* start the process */
$GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['start'] = 'starting to load route parameters';
/* loading parameter of parent route */
$GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['loading_parameters']  = 'loading parameters of parent routes';
/* the parent route is already loaded, meaning there is a circular reference or two parent with the same parent */
$GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['already_loaded'] = 'the route {route} is already loaded, this can be due to two parent route sharing the same parent or a circular reference';
/* this route don't got any parent */
$GLOBALS['lang']['class']['route']['Route']['retrieveParameters']['root_parameters'] = 'this route is a root, it does not have any parents';
/** [/retrieveParameters] **/

?>
