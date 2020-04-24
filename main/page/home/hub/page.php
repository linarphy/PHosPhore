<?php

$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', 'Hello');
$Visitor->getPage()->getPageElement()->addElement('body', 'It works!');

?>