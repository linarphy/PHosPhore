<?php

$lang=$GLOBALS['lang']['user']['login'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'user/login/template.html',
	'elements' => array(
		'action'   => $Router->createLink(array('application' => 'user', 'action' => 'validate_login')),
		'legend'   => $lang['legend'],
		'nickname' => $lang['nickname'],
		'password' => $lang['password'],
		'submit'   => $lang['submit'],
		'register' => $lang['register'],
	),
));

$PageElement->addElement('body', $content);

?>