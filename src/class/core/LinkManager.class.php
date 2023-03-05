<?php

namespace core;

$LANG = $GLOBALS
        ['lang']
        ['class']
        ['core']
        ['LinkManager'];

$LOCALE = $GLOBALS
          ['locale']
          ['class']
          ['core']
          ['LinkManager'];

/**
 * Manage a table which link two tables (manage a many to many table)
 */
class LinkManager extends \core\Manager
{
	/**
	 * Add entries to the table with variant and non variant parameters
	 *
	 * @param array $variants An array of n array (where n is the
	 *                        number of entries) of x values (with x
	 *                        the number of variant attributes of each
	 *                        entry).
	 *
	 * @param array $invariants An array of invariants values for each
	 *                          entry
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
		try
		{
			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$LANG
				['addBy']
				['start'],
				[
					'class' => \get_class($this),
				],
			);

			if (\count($variants) === 0)
			{
				throw new \exception\class\core\LinkManagerException(
					message: $LANG
					         ['addBy']
					         ['no_variants'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			foreach ($variants as $key => $variant)
			{
				$variants[$key] = $this->cleanAttributes($variant);

				if (\count($variants[$key]) === 0)
				{
					throw new \exception\class\core\LinkManagerException(
						message: $LANG
						         ['addBy']
						         ['no_variant'],
						tokens:  [
							'class' => \get_class($this),
						],
					);
				}
			}

			$invariants = $this->cleanAttributes($invariants);

			if (\count($invariants) === 0)
			{
				throw new \exception\class\core\LinkManagerException(
					message: $LANG
					         ['addBy']
					         ['no_invariants'],
					tokens:  [
						'class' => \get_class($this),
					],
				);
			}

			$attributes = \array_merge(
				\array_keys($variants[\array_key_first($variants)]),
				\array_keys($invariants),
			);

			$table = new \database\parameter\Table([
				'name' => $this::TABLE,
			]);

			foreach ($variants as $variant)
			{
				$values           = \array_merge($variant, $invariants);
				$query_attributes = [];
				$query_parameters = [];
				$query_values     = [];
				$position         = 0;
				foreach ($attributes as $key => $name)
				{
					$query_attributes[] = new \database\parameter\Attribute([
						'name'  => $name,
						'table' => $table,
					]);
					$query_parameters[] = new \database\parameter\Parameter([
						'value'    => $values[$key],
						'position' => $position,
					]);
					$query_values[] = $values[$key];
					$position      += 1;
				}

				$Query = new \database\request\Insert([
					'parameters' => $query_attributes,
					'table'      => $table,
					'values'     => $query_values,
				]);

				$connection = \core\DBFactory::connection();

				$driver_class = '\\database\\' .
				                \ucwords(
					\strtolower(
						$connecion->getAttribute(PDO::ATTR_DRIVER_NAME),
					),
				                );

				try
				{
					$query   = $driver_class::displayQuery($Query);
					$request = $connection->prepare($query);
					$request->execute($query_values);
				}
				catch (\PDOException $exception)
				{
					throw new \exception\class\core\LinkManagerException(
						message:  $LANG
						          ['addBy']
						          ['PDO_error'],
						tokens:   [
							'class'     => \get_class($this),
							'exception' => $exception->getMessage(),
						],
						previous: $exception,
					);
				}
			}

			$GLOBALS['Logger']->log(
				[
					'class',
					'core',
					\core\LoggerTypes::DEBUG,
				],
				$LANG
				['addBy']
				['end'],
				[
					'class' => \get_class($this),
				],
			);

			return True;
		}
		catch (
			\exception\class\core\LinkManagerException |
			\Throwable $exception
		)
		{
			throw new \exception\class\core\LinkManagerException(
				message:      $LANG
				              ['addBy']
				              ['error'],
				tokens:       [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				notification: new \user\Notification([
					'content' => $LOCALE
					             ['addBy']
					             ['error'],
					'type'    => \user\NotificationTypes::ERROR,
				]),
				previous:     $exception,
			);
		}
	}
}

?>
