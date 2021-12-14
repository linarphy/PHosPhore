<?php

$PageElement = $GLOBALS['Visitor']->get('page')->get('page_element');
$PageElement->addElement('head', '<title>Congratulation</title>');
$PageElement->addElement('body', '<p>If you see this message, it means that you have successfully installed PHosPhore !</p>');

?>
