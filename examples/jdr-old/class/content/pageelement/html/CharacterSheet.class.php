<?php

namespace content\pageelement\html;

/**
 * A character sheet
 *
 * @author gugus2000
 **/
class CharacterSheet extends \content\PageElement
{
	/* method */

		/**
		* Construction of an instance of a \content\pageelement\html\CharacterSheet
		*
		* @param \character\Character Character The Character of the sheet
		* 
		* @return void
		*/
		public function __construct($Character)
		{
			$Inventory=new \content\pageelement\html\InventorySheet($Character->retrieveInventory());
			$Attributes=new \content\pageelement\html\AttributesSheet($Character->retrieveAttributes(), $Character->retrieveMaxAttributes());
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/charactersheet/template.html',
				'elements' => array(
					'title'            => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_title'],
					'name'             => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_name'],
					'name_value'       => $Character->displayName(),
					'race'             => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_race'],
					'race_value'       => $Character->retrieveRace()->displayName(),
					'class'            => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_class'],
					'class_value'      => $Character->retrieveClass()->displayName(),
					'hp'               => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_hp'],
					'hp_percent'       => (string)($Character->getMax_hp()/$Character->getHp())*100,
					'hp_value'         => $Character->displayHp(),
					'hp_value_max'     => $Character->displayMax_hp(),
					'mana'             => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_mana'],
					'mana_percent'     => (string)($Character->getMax_mana()/$Character->getMana())*100,
					'mana_value'       => $Character->displayMana(),
					'mana_value_max'   => $Character->displayMax_mana(),
					'ap'               => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_ap'],
					'ap_percent'       => (string)($Character->getMax_ap()/$Character->getAp())*100,
					'ap_value'         => $Character->displayAp(),
					'ap_value_max'     => $Character->displayMax_ap(),
					'level'            => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_level'],
					'level_value'      => $Character->displayLevel(),
					'xp'               => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_xp'],
					'xp_value'         => $Character->displayXp(),
					'inventory'        => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_inventory'],
					'inventory_value'  => $Inventory->display(),
					'attributes'       => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_attributes'],
					'attributes_value' => $Attributes->display(),
					'author'           => $GLOBALS['lang']['class_content_pageelement_html_charactersheet_author'],
					'author_value'     => $Character->retrieveAuthor()->displayNickname(),
				),
			));
		}
} // END class CharacterSheet extends \content\PageElement

?>