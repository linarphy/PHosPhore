<?php

$lang=$GLOBALS['lang']['user']['register'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'user/register/template.html',
	'elements' => array(
		'action'            => $Router->createLink(array('application' => 'user', 'action' => 'validate_register')),
		'legend'            => $lang['legend'],
		'display_nickname'  => $lang['nickname'],
		'small_nickname'    => $lang['small_nickname'],
		'display_password'  => $lang['password'],
		'small_password'    => $lang['small_password'],
		'display_password2' => $lang['password2'],
		'small_password2'   => $lang['small_password2'],
		'display_email'     => $lang['email'],
		'small_email'       => $lang['small_email'],
		'submit'            => $lang['submit'],
		'login'             => $lang['login'],
	),
));

$PageElement->addElement('body', $content);