<?php

global $e;
$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', 'ERROR');
$Visitor->getPage()->getPageElement()->addElement('body', $e->getMessage());

?>