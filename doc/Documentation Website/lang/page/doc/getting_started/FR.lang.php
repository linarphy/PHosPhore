<?php

global $Router;

/* Title displayed in the title and in the content of the page */
$GLOBALS['lang']['page']['doc']['getting_started']['title']='Pour Commencer';
/* Displayed description after the title */
$GLOBALS['lang']['page']['doc']['getting_started']['content']='Cette page présentera PHosPhore de la première installation à la construction d\'un site simple. Il est conseillé de consulter la <a href="'.$Router->createLink($GLOBALS['config']['page']['doc']['links']['link_faq']).'" title="Lien vers la FAQ">FAQ</a> avant d\'installer PHosPhore.';
/* Content of the page */
$GLOBALS['lang']['page']['doc']['getting_started']['sections']=array(
	array(
		'title'       => 'Installation',
		'content'     => 'Cette partie concerne l\'installation de PHosPhore, aussi bien en local que sur un serveur.',
		'subsections' => array(
			array(
				'title'   => 'Github',
				'content' => file_get_contents('install_github_FR.html', true),
			),
			array(
				'title'   => 'Sur le serveur',
				'content' => file_get_contents('install_server_FR.html', true),
			),
			array(
				'title'   => 'Première configuration',
				'content' => file_get_contents('install_config_FR.html', true),
			),
		),
	),
	array(
		'title'       => 'Fonctionnement général de PHosPhore',
		'content'     => 'Cette partie regroupe des aspects important du fonctionnement général du framework.',
		'subsections' => array(
			array(
				'title'   => 'Couples "application/action"',
				'content' => file_get_contents('work_1_FR.html', true),
			),
			array(
				'title'   => 'Permissions',
				'content' => file_get_contents('work_2_FR.html', true),
			),
			array(
				'title'   => 'Visiteur',
				'content' => file_get_contents('work_3_FR.html', true),
			),
			array(
				'title'       => 'Création de classes lié à la base de donnée',
				'content'     => file_get_contents('work_4_FR.html', true),
				'subsections' => array(
					array(
						'title'   => 'Manager',
						'content' => file_get_contents('work_4_1_FR.html', true),
					),
					array(
						'title'   => 'Managed',
						'content' => file_get_contents('work_4_2_FR.html', true),
					),
					array(
						'title'   => 'Utilisation de "A"',
						'content' => file_get_contents('work_4_3_FR.html', true),
					),
				),
			),
			array(
				'title'   => 'Affichage de contenu',
				'content' => file_get_contents('work_5_FR.html', true),
			),
			array(
				'title'   => 'Configuration d\'une page',
				'content' => file_get_contents('work_6_FR.html', true),
			),
			array(
				'title' => 'Fichiers lang et config',
				'content' => file_get_contents('work_7_FR.html', true),
				'subsections' => array(
					array(
						'title'   => 'Fichiers lang',
						'content' => file_get_contents('work_7_1_FR.html', true),
					),
					array(
						'title'   => 'Fichiers config',
						'content' => 'De la même façon que les fichiers lang, les fichiers config sont chargés dynamiquement. Ils doivent être nommés "config.php". Ils concernent toutes les configurations des applications/actions pour une meilleure modularité. Ils sont chargés <b>avant</b> les fichiers lang.',
					),
				),
			),
		),
	),
	array(
		'title'       => 'Création d\'un blogue avec PHosPhore',
		'content'     => 'Pour une application pratique au fonctionnement de PHosPhore, cette partie expliquera la mise en place d\'un site de blogging à l\'aide du framework.',
		'subsections' => array(
			array(
				'title'   => 'Création de la base de donnée',
				'content' => file_get_contents('blog_1_FR.html', true),
			),
			array(
				'title'   => 'Création du système de connexion',
				'content' => file_get_contents('blog_2_FR.html', true),
			),
		),
	),
);

?>