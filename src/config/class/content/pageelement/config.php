<?php

$CONFIG =& $GLOBALS
           ['config']
           ['class']
           ['content']
           ['pageelement'];

/** [preset] **/
/* about pre-existing page preset to construct a Page */
/* default preset */
$CONFIG['preset']['default_preset'] = 'none';
/* notifications element name in main content */
$CONFIG['preset']['notification_element_name'] = 'notifications';
/* template directory for preset */
$CONFIG['preset']['template_folder'] = 'preset';
/** [list] **/
/* list of vanilla available preset */
/** [default_html] **/
/* default html page */
/* \content\pageelement\PageElement associated to the main content */
$CONFIG['preset']['list']['default_html']
['page_element'] = '\content\pageelement\preset\default\html\PageElement';
/* \content\pageelement\PageElement associated to the notification
 * content */
$CONFIG['preset']['list']['default_html']
['notification_element'] = '\content\pageelement\preset\default\html\NotificationElement';
/** [/default_html] **/
/** [none] **/
/* no preset */
/* \content\pageelement\PageElement associated to the main content */
$CONFIG['preset']['list']['none']
['page_element'] = '\content\pageelement\PageElement';
/* \content\pageelement\PageElement associated to the notification
 * content */
$CONFIG['preset']['list']['none']
['notification_element'] = '\content\pageelement\PageElement';
/** [/none] **/
/** [/list] **/
/** [/preset] **/

?>
