<?php

namespace core;

/**
 * Manage a table which link two tables (manage a many to many table)
 */
class LinkManager extends \core\Manager
{
	/**
	 * Add entries to the table with variant and non variant parameters
	 *
	 * @param array $variants An array of n array (where n is the number of entries) of x values (with x the number of variant attributes of each entry).
	 *
	 * @param array $invariants An array of invariants values for each entry
	 *
	 * Example:
	 *     for adding these entries:
	 *     ------------------------------------------------------
	 *     | id_element | id_name | value_1 | value_2 | value_3 |
	 *     ------------------------------------------------------
	 *     |     12     |    17   |    a    |    b    |    c    |
	 *     ------------------------------------------------------
	 *     |     12     |    17   |    d    |    e    |    f    |
	 *     ------------------------------------------------------
	 *     |     12     |    17   |    g    |    h    |    i    |
	 *     ------------------------------------------------------
	 *
	 *     $variants = array(
	 *         array(
	 *             'value_1' => 'a',
	 *             'value_2' => 'b',
	 *             'value_3' => 'c',
	 *         ),
	 *         array(
	 *             'value_1' => 'd',
	 *             'value_2' => 'e',
	 *             'value_3' => 'f',
	 *         ),
	 *         array(
	 *             'value_1' => 'g',
	 *             'value_2' => 'h',
	 *             'value_3' => 'i',
	 *         ),
	 *     );
	 *
	 *     $invariants = array(
	 *         'id_element' => 12,
	 *         'id_name'    => 17,
	 *     );
	 *
	 * @return bool
	 */
	public function addBy(array $variants, array $invariants) : bool
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['start']);

		if (count($variants) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['no_variants']);
			return False;
		}
		foreach ($variants as $key => $variant)
		{
			$variants[$key] = $this->cleanAttributes($variant);
			if (count($variants[$key]) === 0)
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['no_variant']);
				return False;
			}
		}
		$invariants = $this->cleanAttributes($invariants);
		if (count($invariants) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['no_invariants']);
			return False;
		}

		$attributes = array_merge(array_keys($variants[\array_key_first($variants)]), array_keys($invariants));

		foreach ($variants as $variant)
		{
			$query = 'INSERT INTO ' . $this::TABLE . '(' . implode(',', $attributes) . ') VALUES (' . implode(',', array_fill(0, count($attributes), '?')) . ')';

			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['query'], array('query' => $query));

			$request = $this->bdd->prepare($query);
			$request->execute(array_merge($variant, $invariants)); // Order is important here
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['core']['LinkManager']['addBy']['end']);
		return True;
	}
}

?>
