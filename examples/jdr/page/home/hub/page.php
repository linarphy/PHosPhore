<?php

$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', $GLOBALS['lang']['page']['home']['hub']['title']);
$Visitor->getPage()->getPageElement()->addElement('body', $GLOBALS['lang']['page']['home']['hub']['content']);

?>