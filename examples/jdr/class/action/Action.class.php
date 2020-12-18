<?php

namespace action;

/**
 * A model for action
 *
 * @package jdr
 * @author gugus2000
 **/
abstract class Action
{
	/* Constant */

		/**
		 * PA cost of the action
		 *
		 * @var int
		 **/
		const COST=0;

	/* Attribute */

		/**
		 * The character which make the action
		 *
		 * @var \character\Character
		 **/
		protected $character;

	/* Method */

		/**
		 * Make the character make the action
		 *
		 * @return bool
		 **/
		public function _do()
		{
			$Attributes=$this->character->retrieveAttributes();
			$PA=$Attributes->getAttr('PA');
			if ($PA>=$this::COST)
			{
				$Attributes->changeAttr('PA', $PA-$this::COST);
				return true;
			}
			return false;
		}
}

?>
