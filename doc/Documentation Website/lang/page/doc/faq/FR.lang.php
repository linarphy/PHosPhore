<?php

/* Title of this page */
$GLOBALS['lang']['page']['doc']['faq']['title']='FAQ';
/* Description of this page */
$GLOBALS['lang']['page']['doc']['faq']['description']='Bienvenue dans la FAQ (Foire Aux Questions)';
/* Question & Answer */
$GLOBALS['lang']['page']['doc']['faq']['qa']=array(
	array(
		'q' => 'A qui s\'adresse ce framework?',
		'a' => 'S\'il est évident que tout le monde peut utiliser ce framework, il est important de comprendre qu\'il est juste le résultat d\'un projet amateur. Cela signifie que ses performances ne sont pas bonnes, que certaines bonnes pratiques du PHP n\'y sont pas appliqué (par méconnaissance, rassurez-vous ;) ). JE DÉCONSEILLE DONC CE FRAMEWORK À QUICONQUE SOUHAITE L\'UTILISER EN PRODUCTION OU AUTRES USAGES PROFESSIONELS.',
	),
	array(
		'q' => 'Pourquoi ce projet existe-t-il?',
		'a' => 'Ce projet est le résultat de mon expérience avec PHP sur ces cinq dernières années. La construction du framework lui-même n\'a pas pris toutes ces années, mais est le fruit de la construction d\'un site cinq fois, dont cinq fois avec une approche différente. La dernière m\'a ammené à penser une certaine démarche, que j\'ai décidé d\'approfondir en en faisant ce framework. Bien sur, le projet a progressé dans plusieurs aspects par rapport à l\'idée originale (qui est principalement basé sur la symétrie URL/fichier).',
	),
	array(
		'q' => 'La page n\'affiche pas "It works!" lors du chargement du site mais une page blanche, que se passe-t-il?',
		'a' => 'Il peut y avoir plusieurs problèmes. D\'abord, vérifiez vos configurations, sait-on jamais. Si la configuration est bonne, qu\'aucun fichie n\'a été modifié et que la base de donnée a bien été importé, il est possible que "mod_rewrite" ne soit pas activé dans votre configuration apache. Activez le avec <code>sudo a2enmod rewrite</code> sur linux. Sur window, cela dépend de la façon dont est installé le serveur. Si cela ne fonctionne toujours pas et si vous utilisez un virtualHost, vérifiez la présence de <code>AllowOverride All</code> dans le fichier de configuration du virtualHost. Si l\'erreur n\'est toujours pas résolu, n\'hésitez pas à me contacter.',
	),
	array(
		'q' => 'J\'ai trouvé des erreurs/mauvaises pratiques/autres choses pas cool dans le code! Que faire?',
		'a' => 'Merci pour votre interêt pour ce projet ! N\'hésitez pas à me contacter, les critiques me permettenet de m\'améliorer, et je ne doute pas que le projet soit sûrement truffé d\'âneries !',
	),
	array(
		'q' => 'Je souhaite vous contactez, comment faire?',
		'a' => 'N\'hésitez pas à visiter la page "me contacter", qui liste différents moyens de me contacter.',
	),
	array(
		'q' => 'Puis-je utiliser, diffuser, modifier ce framework?',
		'a' => 'La license est disponible facilement sur le site et Github, mais pour faire court: OUI, qu\'il soit associé à un contenu payant, sous license commerciale ou libre, etc...',
	),
);

?>