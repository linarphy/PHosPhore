<?php

$GLOBALS['lang']=array(
	/* class */
		/* content */
			'class_content_content_no_result'            => 'No result for this content id',
			'class_content_pageelement_cannot_add_value' => 'Cannot add another element to an element that is neither an array nor a string',
		/* content */
			/* pageelement */
				/* html */
					/* charactersheet */
						'class_content_pageelement_html_charactersheet_title'     => 'Character',
						'class_content_pageelement_html_charactersheet_name'      => 'Name',
						'class_content_pageelement_html_charactersheet_race'      => 'Race',
						'class_content_pageelement_html_charactersheet_class'     => 'Class',
						'class_content_pageelement_html_charactersheet_hp'        => 'HP',
						'class_content_pageelement_html_charactersheet_mana'      => 'Mana',
						'class_content_pageelement_html_charactersheet_ap'        => 'AP',
						'class_content_pageelement_html_charactersheet_level'     => 'Level',
						'class_content_pageelement_html_charactersheet_xp'        => 'XP',
						'class_content_pageelement_html_charactersheet_inventory' => 'Inventory',
						'class_content_pageelement_html_charactersheet_attributes' => 'Attributes',
						'class_content_pageelement_html_charactersheet_author'    => 'Creator',
					/* inventorysheet */
						'class_pageelement_html_inventorysheet_no_item' => 'No items',
					/* attributessheet */
						'class_content_pageelement_html_attributessheet_str'  => 'Strength ',
						'class_content_pageelement_html_attributessheet_dex'  => 'Dexterity ',
						'class_content_pageelement_html_attributessheet_con'  => 'Constitution ',
						'class_content_pageelement_html_attributessheet_int_' => 'Intelligence ',
						'class_content_pageelement_html_attributessheet_cha'  => 'Charisma ',
						'class_content_pageelement_html_attributessheet_agi'  => 'Agility ',
						'class_content_pageelement_html_attributessheet_mag'  => 'Magic ',
						'class_content_pageelement_html_attributessheet_acu'  => 'Acuity ',
					/* navbar */
						'class_content_pageelement_html_navbar_home_title'   => 'Click here to go to home',
						'class_content_pageelement_html_navbar_home'         => 'Home',
						'class_content_pageelement_html_navbar_logout_title' => 'Click here to logout',
						'class_content_pageelement_html_navbar_logout'       => 'Logout',
		/* core */
			/* manager */
				'class_core_manager_unknown_operator'  => 'Unknown operator',
				'class_core_manager_unknown_attribute' => 'Unknown attribute',
				'class_core_manager_unknown_direction' => 'Unknown direction',
			/* router */
				'class_router_argument_content_mismatch' => 'Mismatch between the expected content of a parameter and its actual content',
				'class_core_router_missing_parameter'    => 'At least one parameter is missing',
				'class_core_router_too_much_parameters'  => 'Too many parameters were given',
			/* managed */
				'class_core_managed_no_attributes' => 'No attributes to hydrate',
		/* item */
			/* item */
				'class_item_unknown_type'                  => 'Unknown type',
				'class_item_unknown_quality'               => 'Unknown quality',
				'class_item_item_no_enchantment_available' => 'No available enchantment for this type of item',
				'class_item_item_unknown_enchantable_item' => 'This type of item is not known to be enchantable',
			/* equipment */
				'class_item_equipment_error_slot' => 'Unknown slot',
			/* weapon */
				'class_item_weapon_error_unknown_attack_type' => 'Unknown attack type',
				'class_item_weapon_error_unknown_slot'        => 'Unknown slot',
			/* jewelry */
				'class_item_jewelry_error_unknown_slot' => 'Unknown slot',
			/* spellbook */
				'class_item_spellbook_suffix' => 'Spell Book: ',
		/* user */
			/* visitor */
				'class_user_visitor_no_file' => 'The requested file cannot be found',
				'class_user_visitor_no_perm' => 'You do not have permission to view this page',
	/* html */
		'html_title_prefix' => ' | '.$GLOBALS['config']['general_name'],
	/* general */
		/* error */
			'general_error_not_numeric' => 'Value not numeric',
			'general_error_connection'  => 'Error during the connection: bad password or nickname',
);

?>