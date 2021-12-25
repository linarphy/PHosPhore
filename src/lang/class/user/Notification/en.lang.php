<?php

/** [addToSession] **/
/* no content */
$GLOBALS['lang']['class']['user']['Notification']['addToSession']['content'] = 'cannot add a notification without content to the session';
/* no id */
$GLOBALS['lang']['class']['user']['Notification']['addToSession']['id'] = 'cannot add a notification which has an id but no id_content';
/* successfuly added notification to the session */
$GLOBALS['lang']['class']['user']['Notification']['addToSession']['success'] = 'successfully added the notification to the session';
/** [/addToSession] **/

/** [create] **/
/* id_content undefined */
$GLOBALS['lang']['class']['user']['Notification']['create']['id_content'] = 'cannot create notification, id_content not defined';
/* id_users empty */
$GLOABLS['lang']['class']['user']['Notification']['create']['id_users'] = 'cannot create notification, id_users not defined';
/** [/create] **/

/** [delete] **/
/* missing attributes */
$GLOBALS['lang']['class']['user']['Notification']['delete']['missing_attributes'] = 'cannot delete notification without correct attributes';
/* notification not exist */
$GLOBALS['lang']['class']['user']['Notification']['delete']['not_exist'] = 'cannot delete the notification because it does not exist';
/* success */
$GLOBALS['lang']['class']['user']['Notification']['delete']['success'] = 'successfuly deleted {number} notifications';
/** [/delete] **/

/** [deleteNotifications] **/
/* start to delete notifications */
$GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['start'] = 'starting to delete notifications';
/* delete notifications in session */
$GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['session'] = 'deleting {number} notifications in session';
/* delete notifications in database */
$GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['db'] = 'deleting {number} notifications in database';
/* notifications deleted */
$GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['end'] = 'successfuly deleted {number} notifications';
/** [/deleteNotifications] **/

/** [displayContent] **/
/* no content */
$GLOBALS['lang']['class']['user']['Notification']['displayContent']['no_content'] = 'nothing to display, content is not defined';
/** [/displayContent] **/

/** [getNotifications] **/
/* pageElement already has a content */
$GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_content'] = 'The base element for the notification already has the content: {content}';
/* pageElement already has a date */
$GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_date'] = 'The base element for the notification already has the date: {date}';
/* pageElement already has a type */
$GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_type'] = 'The base element for the notification already has the type: {type}';
/* there is at least one notification in the session */
$GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_session'] = 'There is {number} notification(s) in the session';
/* there is at least one notification in the database */
$GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_db'] = 'Ther is {number} notification(s) in the database';
/** [/getNotifications] **/

/** [retrieveContent] **/
/* no content to retrieve */
$GLOBALS['lang']['class']['user']['Notification']['retrieveContent']['no_content'] = 'No content associated to the notification';
/** [/retrieveContent] **/

?>
