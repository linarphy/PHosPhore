<?php

$PageElement=$Visitor->getPage()->getPageElement();

$config_mod=$GLOBALS['config']['mod']['login'];
$config=$GLOBALS['config']['page'][$config_mod['application']][$config_mod['login']['action']];
$lang_mod=$GLOBALS['lang']['mod']['login'];
$lang=$GLOBALS['lang']['page'][$config_mod['application']][$config_mod['login']['action']];

$PageElement->getElement('head')->addElement('title', $lang['title'].$lang_mod['title']);

$Form=new \content\PageElement(array(
  'template' => $GLOBALS['config']['path_template'].'page/user/'.$config_mod['login']['action'].'/template.html',
  'elements' => array(
	  'action'   => $Router->createLink(array('application' => $config_mod['application'], 'action' => $config_mod['login-validate']['action'])),
	  'method'   => strtoupper($config_mod['login']['method']),
	  'charset'  => $config['charset'],
	  'legend'   => $lang['legend'],
	  'nickname' => $lang['nickname'],
	  'password' => $lang['password'],
	  'submit'   => $lang['submit'],
  ),
));

$PageElement->addElement('body', $Form);

?>
