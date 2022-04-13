<?php

/** [preset] **/
/* about pre-existing page preset to construct a Page */
/* default preset */
$GLOBALS['config']['class']['content']['pageelement']['preset']['default_preset'] = 'none';
/* notifications element name in main content */
$GLOBALS['config']['class']['content']['pageelement']['preset']['notification_element_name'] = 'notifications';
/* template directory for preset */
$GLOBALS['config']['class']['content']['pageelement']['preset']['template_folder'] = 'preset';
/** [list] **/
/* list of vanilla available preset */
/** [default_html] **/
/* default html page */
/* \content\pageelement\PageElement associated to the main content */
$GLOBALS['config']['class']['content']['pageelement']['preset']['list']['default_html']['page_element'] = '\content\pageelement\preset\default\html\PageElement';
/* \content\pageelement\PageElement associated to the notification content */
$GLOBALS['config']['class']['content']['pageelement']['preset']['list']['default_html']['notification_element'] = '\content\pageelement\preset\default\html\NotificationElement';
/** [/default_html] **/
/** [none] **/
/* no preset */
/* \content\pageelement\PageElement associated to the main content */
$GLOBALS['config']['class']['content']['pageelement']['preset']['list']['none']['page_element'] = '\content\pageelement\PageElement';
/* \content\pageelement\PageElement associated to the notification content */
$GLOBALS['config']['class']['content']['pageelement']['preset']['list']['none']['notification_element'] = '\content\pageelement\PageElement';
/** [/none] **/
/** [/list] **/
/** [/preset] **/

?>
