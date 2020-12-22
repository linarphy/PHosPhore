<?php

global $Router;

/* Title displayed in the title and in the content of the page */
$GLOBALS['lang']['page']['doc']['getting_started']['title']='Pour Commencer';
/* Displayed description after the title */
$GLOBALS['lang']['page']['doc']['getting_started']['content']='Cette page présentera PHosPhore de la première installation à la construction d\'un site simple. Il est conseillé de consulter la <a href="'.$Router->createLink($GLOBALS['config']['page']['doc']['links']['faq']).'" title="Lien vers la FAQ">FAQ</a> avant d\'installer PHosPhore.';
/* [SECTIONS] */
/* 0 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['title']='Installation';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['content']='Cette partie concerne l\'installation de PHosPhore, aussi bien en local que sur un serveur.';
/* [SUBSECTIONS] */
/* 0 /*
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][0]['title']='GitHub';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][0]['content']=file_get_contents('install_github_FR.html', true);
/* 1 /*
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][1]['title']='Sur le serveur';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][1]['content']=file_get_contents('install_server_FR.html', true);
/* 2 /*
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][2]['title']='Première configuration';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][0]['subsections'][2]['content']=file_get_contents('install_config_FR.html', true);

/* 1 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['title']='Fonctionnement général de PHosPhore';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['content']='Cette partie regroupe des aspects important du fonctionnement général du framework.';
/* [SUBSECTIONS] */
/* 0 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][0]['title']='Couples "application/action"';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][0]['content']=file_get_contents('work_1_FR.html', true);
/* 1 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][1]['title']='Permissions';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][1]['content']=file_get_contents('work_2_FR.html', true);
/* 2 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][2]['title']='Visiteur';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][2]['content']=file_get_contents('work_3_FR.html', true);
/* 3 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['title']='Création de classe lié à la base de donnée';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['content']=file_get_contents('work_4_FR.html', true);
/* [SUBSECTIONS] */
/* 0 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][0]['title']='Manager';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][0]['content']=file_get_contents('work_4_1_FR.html', true);
/* 1 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][1]['title']='Managed';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][1]['content']=file_get_contents('work_4_2_FR.html', true);
/* 2 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][2]['title']='Utilisation de "A"';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][3]['subsections'][2]['content']=file_get_contents('work_4_3_FR.html', true);

/* 4 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][4]['title']='Affichage de contenu';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][4]['content']=file_get_contents('work_5_FR.html', true);
/* 5 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][5]['title']='Configuration d\'une page';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][5]['content']=file_get_contents('work_6_FR.html', true);
/* 6 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['title']='Fichiers lang et config';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['content']=file_get_contents('work_7_FR.html', true);
/* [SUBSECTIONS] */
/* 0 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['subsections'][0]['title']='Fichiers lang';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['subsections'][0]['content']=file_get_contents('work_7_1_FR.html', true);
/* 1 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['subsections'][1]['title']='Fichiers config';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][1]['subsections'][6]['subsections'][1]['content']='De la même façon que le fichiers lang, les fichiers config sont chargés dynamiquement. Ils doivent être nommés "config.php". Ils concernent toutes les configurations des applications/actions pour une meilleure modularité. Ils sont chargés <b>avant</b> les fichiers lang.';


/* 2 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['title']='Création d\'un blogue avec PHosPhore';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['content']='Pour une application pratique au fonctionnement de PHosPhore, cette partie expliquera la mise en place d\'un site de blogging à l\'aide du framework.';
/* [SUBSECTIONS] */
/* 0 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['subsections'][0]['title']='Création de la base de donnée';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['subsections'][0]['content']=file_get_contents('blog_1_FR.html', true);
/* 1 */
/* Title of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['subsections'][1]['title']='Création du système de connexion';
/* Content of the section */
$GLOBALS['lang']['page']['doc']['getting_started']['sections'][2]['subsections'][1]['content']=file_get_contents('blog_2_FR.html', true);

?>
