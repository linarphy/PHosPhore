<?php

$GLOBALS['lang']=array(
	/* class */
		/* content */
			'class_content_content_no_result'            => 'Aucun résultat pour cet id de contenu',
			'class_content_pageelement_cannot_add_value' => 'Ne peut pas ajouter un autre élément à un élément qui n\'est ni un tableau ni une chaîne',
		/* content */
			/* pageelement */
				/* html */
					/* charactersheet */
						'class_content_pageelement_html_charactersheet_title'     => 'Personnage',
						'class_content_pageelement_html_charactersheet_name'       => 'Nom',
						'class_content_pageelement_html_charactersheet_race'       => 'Race',
						'class_content_pageelement_html_charactersheet_class'      => 'Classe',
						'class_content_pageelement_html_charactersheet_hp'         => 'PV',
						'class_content_pageelement_html_charactersheet_mana'       => 'Mana',
						'class_content_pageelement_html_charactersheet_ap'         => 'PA',
						'class_content_pageelement_html_charactersheet_level'      => 'Level',
						'class_content_pageelement_html_charactersheet_xp'         => 'XP',
						'class_content_pageelement_html_charactersheet_inventory'  => 'Inventaire',
						'class_content_pageelement_html_charactersheet_attributes' => 'Attributs',
						'class_content_pageelement_html_charactersheet_author'     => 'Créateur',
					/* inventorysheet */
						'class_pageelement_html_inventorysheet_no_item' => 'Aucun items',
					/* attributessheet */
						'class_content_pageelement_html_attributessheet_str'  => 'Force ',
						'class_content_pageelement_html_attributessheet_dex'  => 'Dextérité ',
						'class_content_pageelement_html_attributessheet_con'  => 'Constitution ',
						'class_content_pageelement_html_attributessheet_int_' => 'Intelligence ',
						'class_content_pageelement_html_attributessheet_cha'  => 'Charisme ',
						'class_content_pageelement_html_attributessheet_agi'  => 'Agilité ',
						'class_content_pageelement_html_attributessheet_mag'  => 'Magie ',
						'class_content_pageelement_html_attributessheet_acu'  => 'Acuité ',
					/* navbar */
						'class_content_pageelement_html_navbar_home_title'   => 'Cliquez ici pour revenir à l\'accueil',
						'class_content_pageelement_html_navbar_home'         => 'Accueil',
						'class_content_pageelement_html_navbar_logout_title' => 'Cliquez ici pour vous deconnectez',
						'class_content_pageelement_html_navbar_logout'       => 'Déconnexion',
		/* core */
			/* manager */
				'class_core_manager_unknown_operator'  => 'Opérateur inconnue',
				'class_core_manager_unknown_attribute' => 'Attribut inconnue',
				'class_core_manager_unknown_direction' => 'Direction Inconnue',
			/* router */
				'class_router_argument_content_mismatch' => 'Inadéquation entre le contenu attendu d\'un paramètre et son contenu réel',
				'class_core_router_missing_parameter'    => 'Il manque au moins un paramètre',
				'class_core_router_too_much_parameters'  => 'Trop de paramètres ont été donnés',
			/* managed */
				'class_core_managed_no_attributes' => 'Pas d\'attribut à hydrater',
		/* item */
			/* item */
				'class_item_unknown_type'                  => 'Type inconnu',
				'class_item_unknown_quality'               => 'Qualité inconnue',
				'class_item_item_no_enchantment_available' => 'Pas d\'enchantement disponible pour ce type d\'item',
				'class_item_item_unknown_enchantable_item' => 'Ce type d\'item n\'est pas reconnu comme étant enchantable',
			/* equipment */
				'class_item_equipment_error_slot' => 'Slot inconnu',
			/* weapon */
				'class_item_weapon_error_unknown_attack_type' => 'Type d\'attaque inconnue',
				'class_item_weapon_error_unknown_slot'        => 'Slot inconnu',
			/* jewelry */
				'class_item_jewelry_error_unknown_slot' => 'Slot inconnu',
			/* spellbook */
				'class_item_spellbook_suffix' => 'Livre de sort: ',
		/* user */
			/* visitor */
				'class_user_visitor_no_file' => 'Le fichier ne peut pas être trouvé',
				'class_user_visitor_no_perm' => 'Vous n\'avez pas la permission de voir cette page',
	/* html */
		'html_title_prefix' => ' | '.$GLOBALS['config']['general_name'],
	/* general */
		/* error */
			'general_error_not_numeric' => 'Valeur non numérique',
			'general_error_connection'  => 'Erreur lors de la connexion : mauvais mot de passe ou pseudo',
);

?>