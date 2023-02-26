<?php

$LANG =& $GLOBALS
         ['lang']
         ['class']
         ['content']
         ['Content'];

/** [display] **/
/* an error occured when displaying the text attribute of the content */
$LANG['display']['error_before'] = 'an error occured when displaying 
the text attribute of this content: {exception}';
/* an error occured when using the \core\Base::display method */
$LANG['display']['error_display'] = 'an error occured when using the 
default method to display the attribute {attribute}: {exception}';
/* an error occured when displaying the attribute */
$LANG['display']['error'] = 'an error occured when displaying the 
attribute {attribute}: {exception}';
/** [/display] **/

/** [retrieveText] **/
/* start */
$LANG['retrieveText']['start'] = 'start to retrieve content text';
/* an error has been thrown by the manager method */
$LANG['retrieveText']['error_manager'] = 'an error occured in the 
manager creation: {exception}';
/* an error occured when retrieving the text */
$LANG['retrieveText']['error_retrieve'] = 'an error occured in the 
retrieve method: {exception}';
/* successful retrieval */
$LANG['retrieveText']['success'] = 'successfully retrieved content 
text';
/* cannot retrieve the text in the good lang */
$LANG['retrieveText']['warning'] = 'cannot retrieve the text in the 
wanted language, but the content exist in at least one lang';
/* can retrieve the text in the lang of the user (but not the wanted 
 * one) */
$LANG['retrieveText']['success_user_lang'] = 'successfully retrieved 
content text in the user lang';
/* an error occured when hydrating this content */
$LANG['retrieveText']['error_hydrate'] = 'an error occured when 
hydrating the content: {exception}';
/* can retrieve the text in the default lang */
$LANG['retrieveText']['success_default_lang'] = 'successfully 
retrieved content text in default lang';
/* retrieve the text from one of the possible lang */
$LANG['retrieveText']['success_any'] = 'successfully retrieved the 
content text in one random lang';
/* content does not exist */
$LANG['retrieveText']['failure'] = 'the content does not exist';
/* cannot check the existence of this content */
$LANG['retrieveText']['error_exist'] = 'an error occured when checking 
the existence of this content: {exception}';
/* cannot retrieve the text of this content */
$LANG['retrieveText']['error'] = 'an error occured when retrieving the 
text of this content: {exception}';
/** [/retrieveText] **/

?>
