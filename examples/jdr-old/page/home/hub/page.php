<?php

$lang=$GLOBALS['lang']['home']['hub'];

$PageElement=$Visitor->getPage()->getPageElement();

$PageElement->getElement('head')->addElement('title', $lang['title']);

$options=array(new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/hub/option.html',
	'elements' => array(
		'href' => $Router->createLink(array(
			'application' => 'home',
			'action'      => 'creation_character',
		)),
		'title' => $lang['creation_character_title'],
		'link'  => $lang['creation_character_link'],
		'class' => '',
	),
)));
$Manager=new \character\CharacterManager(\core\DBFactory::MysqlConnection());
$Character=new \character\Character(array('id' => 1));
if ($Visitor->isAdmin($Character))
{
	$Notification = new \user\Notification(array(
		'type' => \user\Notification::TYPE_WARNING,
		'content' => $GLOBALS['lang']['home']['warning_admin'],
	));
	$Notification->sendNotification($Visitor->getPage()->getPageElement(), new \content\pageelement\html\HTMLNotification);
	foreach ($Manager->getBy() as $character)
	{
		if ((int)$character['id_author']===$Visitor->getId())
		{
			$class='bg-success';
		}
		else
		{
			$class='';
		}
		$options[]=new \content\PageElement(array(
			'template' => $GLOBALS['config']['path_template'].'home/hub/option.html',
			'elements' => array(
				'href' => $Router->createLink(array(
					'application' => 'home',
					'action'      => 'play_character',
					'parameters'  => array(
						'id' => $character['id'],
					),
				)),
				'title' => $lang['play_character_title'].$character['name'],
				'link'  => $character['name'],
				'class' => $class,
			),
		));
	}
}
else
{
	if ($Manager->countBy(array(
		'id_author' => $Visitor->getId(),
	), array(
		'id_author' => '=',
	))>0)
	{
		foreach ($Manager->getBy(array(
			'id_author' => $Visitor->getId(),
		), array(
			'id_author' => '=',
		)) as $character)
		{
			$options[]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'home/hub/option.html',
				'elements' => array(
					'href' => $Router->createLink(array(
						'application' => 'home',
						'action'      => 'play_character',
						'parameters'  => array(
							'id' => $character['id'],
						),
					)),
					'title' => $lang['play_character_title'].$character['name'],
					'link'  => $character['name'],
					'class' => '', 
				),
			));
		}
	}
}

$content=new \content\PageElement(array(
	'template' => $GLOBALS['config']['path_template'].'home/hub/template.html',
	'elements' => array(
		'title'   => $lang['title'],
		'options' => $options,
	),
));

$PageElement->addElement('body', $content);

?>