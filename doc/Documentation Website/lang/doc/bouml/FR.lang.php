<?php

$GLOBALS['lang']['doc']['bouml']=array(
	'title'    => 'BOUML',
	'content'  => 'Comment utiliser la documentation généré automatiquement avec le logiciel BOUML.',
	'sections' => array(
	 	array(
			'title'   => 'Introduction à BOUML',
			'content' => file_get_contents('intro_FR.html', true),
	 	),
	 	array(
	 		'title'   => 'Accès à la documentation généré par BOUML',
	 		'content' => '<p>La documentation généré par BOUML peut être récupéré sous forme de dossier, via le github. Il s\'agit du dossier doc/BOUML/PHosPhore/HTML. Dans celui-ci, vous trouverez un fichier, nommé index-withframe.html, qui, une fois ouvert, vous permettra d\'accéder à la documentation.</p>'
	 	),
	 	array(
			'title'       => 'La documentation, composant par composant',
			'content'     => '<p>Dans cette section, chaque élément d\'affichage de la documentation sera expliqué.<br /></p>
							<figure>
								<figcaption>L\'affichage général</figcaption>
								<img src="asset/img/file/bouml_home.png" alt="Capture d\'écran de la documentation de bouml lors du chargement de la page">
							</figure>',
			'subsections' => array(
				array(
					'title'   => 'La page principale',
					'content' => '<figure>
									<figcaption>L\'affichage de la page principale</figcaption>
									<img src="asset/img/file/bouml_home_component_main.png" alt="Capture d\'écran de l\'affichage de la page principale dans la documentation de bouml">
								</figure>
								<p>Cette section de la page va être la seule à changer lors de votre parcours dans la documentation.<br />
								Chaque affichage de cette page sera expliqué ultérieurement.</p>',
				),
				array(
					'title'   => 'La liste des classes',
					'content' => '<figure>
									<figcaption>L\'affichage de la liste des classes</figcaption>
									<img src="asset/img/file/bouml_home_component_classes.png" alt="Capture d\'écran de l\'affichage de la liste des classes dans la documentation de bouml">
								</figure>
								<p>
									Vous pouvez accéder facilement aux détails de n\'importe quelle classe en cliquant sur un des liens.
								</p>
								<figure>
									<figcaption>L\'affichage de la page principale lors de l\'affichage d\'une classe</figcaption>
									<img src="asset/img/file/bouml_classes.png" alt="Capture d\'écran de l\'affichage des détails d\'une des classes dans la documentation de bouml">
								</figure>',
				),
				array(
					'title'   => 'Le système de navigation',
					'content' => '<figure>
									<figcaption>L\'affichage du système de navigation</figcaption>
									<img src="asset/img/file/bouml_home_component_top.png" alt="Capture d\'écran de l\'affichage du système de navigation dans la documentation de bouml">
								</figure>
								<p>Cette section de la page vous permet de naviguer facilement dans la documentation.<br />
								Elle contient deux lignes, l\'une comportant quatre liens, l\'autres plusieurs liens associés à des lettres rangées dans l\'ordre alphabétiques.<br />
								Le lien "-Top-" vous ramenera à la page de départ. Le lien "-Classes-", lui, vous redirigera vers un index détaillé de toutes les classes du projet.</p>
								<figure>
									<figcaption>L\'affichage de l\'index des classes disponibles à travers le système de navigation</figcaption>
									<img src="asset/img/file/bouml_top_classes.png" alt="Capture d\'écran de l\'affichage de l\'index des classes dans la documentation de bouml">
								</figure>
								<p>Le lien "-Public Operations-" vous redirigera vers un index détaillé de toutes les méthodes publiques existantes du projet.</p>
								<figure>
									<figcaption>L\'affichage de l\'index des méthodes publiques disponibles à travers le système de navigation</figcaption>
									<img src="asset/img/file/bouml_top_public_operations.png" alt="Capture d\'écran de l\'affichage de l\'index des méthodes publiques dans la documentation de bouml">
								</figure>
								<p>Vous pouvez ignorer le dernier lien, "-Packages-", car inutile ici.<br />
								Cliquez sur une des lettres de la deuxième liste affichera toutes les classes, méthodes et attributs commençant par cette lettres.</p>
								<figure>
									<figcaption>L\'affichage de l\'index des classes, méthodes et attributs commençant par la même lettre disponibles à travers le système de navigation</figcaption>
									<img src="asset/img/file/bouml_top_letters.png" alt="Capture d\'écran de l\'affichage de l\'index des des classes, méthodes et attributs commençant par une lettre commune dans la documentation de bouml">
								</figure>',
				),
			),
	 	),
		array(
			'title'   => 'Dans la pratique',
			'content' => 'La documentation généré par BOUML peut être utile à plusieurs occasions. La première est de chercher plus d\'informations sur une classe, méthodes ou attributs donné sans fouiller le code. Une autre est lors de l\'usage d\'une classe, méthode ou attribut mal documenté ou pas documenté (ajouté au cours d\'une mise à jour récente par exemple). Finalement, cette documentation peut être utilisé pour maintenir votre propre code, en regénérant la documentation avec le logiciel vous même. Vous aurez ainsi une documentation facilement maintenable et accessible.',
		),
		array(
			'title'   => 'Générer sa documentation avec BOUML',
			'content' => file_get_contents('use_FR.html', true),
		),
	 ),
);

?>