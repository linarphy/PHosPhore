<?php

$lang=$GLOBALS['lang']['giveaway']['prepare'];

$Visitor->getPage()->getPageElement()->getElement('head')->addValueElement('css', 'asset/css/form.css');
$Visitor->getPage()->getPageElement()->getElement('head')->addElement('title', $lang['title']);

$Content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'giveaway/prepare/template.html',
	'elements' => array(
		'legend'           => $lang['legend'],
		'action'           => $Router->createLink(array('application' => 'giveaway', 'action' => 'create')),
		'label'            => $lang['label'],
		'max_participants' => (string)$GLOBALS['config']['giveaway']['nb_max_participants'],
		'submit'           => $lang['submit'],
	),
));

$Visitor->getPage()->getPageElement()->addElement('body', $Content);

?>