<?php

$lang=$GLOBALS['lang']['page']['doc']['license'];
$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);
$PageElement->getElement('body')->addElement('content', $lang['content']);

?>
