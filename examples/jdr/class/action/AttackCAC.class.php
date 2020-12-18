<?php

namespace action;

/**
 * Attack CAC
 *
 * @package jdr
 * @author gugus2000
 **/
class AttackCAC extends \action\Action
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

	/* Method */

		/**
		 * Make the character attack the enemy with CAC
		 *
		 * @return bool
		 **/
		public function _do()
		{
			if (parent->_do())
			{
				$Attributes=$this->character->retrieveAttributes();
				$Inventory=$this->character->retrieveInventory();
				$damage=$Attributes->getAttr('FOR')/10+$Inventory->getCACDamage()-$this->enemy->retrieveInventory()->getPhysProt();
				$roll=\jdr_utils\Dice::roll(1, 100);
				if ($roll>=$Attributes->getCritSucc('FOR'))
				{
					$damage*=2;
				}
				else if ($roll>=$Attributes->getSucc('FOR'))
				{
				}
				else if ($roll>=$Attributes->getFail('FOR'))
				{
					$damage/=2;
				}
				else
				{
					$damage=0;
				}
				$roll=\jdr_utils\Dice::roll(1, 100);
				$enemy_Attributes=$this->enemy->retrieveAttributes();
				if ($roll>=$enemy_Attributes->getCritSucc('AGI'))
				{
					$damage=0;
				}
				else if ($roll>=$enemy_Attributes->getSucc('AGI'))
				{
					$damage/=2;
				}
				else if ($roll>=$enemy_Attributes->getFail('AGI'))
				{
				}
				else
				{
					$damage*=2;
				}
				$damage=floor($damage);
				if ($damage>0)
				{
					$this->enemy->takeDamage($damage);
					$this->enemy->retrieveEffect()->add($Inventory->getCACEffects());
					return true;
				}
			}
			return false;
		}
}

?>
