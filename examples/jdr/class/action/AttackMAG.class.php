<?php

namespace action;

/**
 * Attack MAG
 *
 * @package jdr
 * @author gugus2000
 **/
class AttackLAG extends \action\Action
{
	/* Constant */

		/**
		 * PA cost of this action
		 *
		 * @var int
		 **/
		const COST=2;

	/* Attributes */

		/**
		 * Enemy to attack
		 *
		 * @var \character\Character
		 **/
		protected $enemy;
		/**
		 * Spell used
		 *
		 * @var \character\Spell
		 **/
		protected $spell;

	/* Method */

		/**
		 * Make the character attack the enemy with MAG
		 *
		 * @return bool
		 **/
		public function _do()
		{
			if (parent->_do())
			{
				$Attributes=$this->character->retrieveAttributes();
				$Inventory=$this->character->retrieveInventory();
				$damage=$Attributes->getAttr('MAG')/10+$Inventory->getMAGDamage($this->spell->getType())-$this->enemy->retrieveInventory()->getMagiProt();
				$roll=\jdr_utils\Dice::roll(1, 100);
				if ($roll>=$Attributes->getCritSucc('INT'))
				{
					$damage*=2;
				}
				else if ($roll>=$Attributes->getSucc('INT'))
				{
				}
				else if ($roll>=$Attributes->getFail('INT'))
				{
					$damage/=2;
				}
				else
				{
					$damage=0;
				}
				if ($this->enemy->canProtectMag())
				{
					$enemy_Attributes=$this->enemy->retrieveAttributes();
					$protect_spell=$this->enemy->retrieveSpells()->getProtectiveSpell($enemy_Attributes->getAttr('MANA'));
					$roll=\jdr_utils\Dice::roll(1, 100);
					if ($roll>=$enemy_Attributes->getCritSucc('INT'))
					{
						$damage=0;
					}
					else if ($roll>=$enemy_Attributes->getSucc('INT'))
					{
						$damage-=$protect_spell->getDamage();
						$enemy_Attributes->changeAttr('MANA', $enemy_Attributes->getAttr('MANA')-$protect_spell->getCost());
					}
					else if ($roll>=$enemy_Attributes->getFail('INT'))
					{
					}
					else
					{
						$damage+=(protect_spell->getDamage())/2;
					}
				$damage=floor($damage);
				if ($damage>0)
				{
					$this->enemy->takeDamage($damage);
					$this->enemy->retrieveEffect()->add(array_merge($spell->retrieveEffect(), $Inventory->getMAGEffects()));
					return true;
				}
			}
			return false;
		}
}

?>
