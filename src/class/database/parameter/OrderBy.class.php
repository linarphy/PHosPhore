<?php

namespace database\parameter;

/**
 * order by part
 */
class OrderBy
{
	use \core\Base;

	/**
	 * available types
	 *
	 * @var array
	 */
	const TYPES = [
		'ASC',
		'DESC',
	];
	/**
	 * column to order by
	 *
	 * @var ?\database\parameter\Column
	 */
	protected ?\database\parameter\Column $column;
	/**
	 * sub order by structure
	 *
	 * @var ?array
	 */
	protected ?array $order_by;
	/**
	 * type of the order by
	 *
	 * @var ?string
	 */
	protected ?string $type = null;
	/**
	 * set the type
	 *
	 * @param string $type
	 *
	 * @return bool
	 */
	public function setType(string $type) : bool
	{
		if (!\in_array($type, $this::TYPES))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['database']['parameter']['OrderBy']['setType']['unknown'], ['type' => $type]);
			throw new \Exception($GLOBALS['locale']['class']['database']['parameter']['OrderBy']['setType']['unknown']);
		}

		$this->type = $type;

		return True;
	}
}

?>
