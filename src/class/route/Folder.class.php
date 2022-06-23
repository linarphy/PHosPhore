<?php

namespace route;

/**
 * A real folder
 */
class Folder extends \core\Managed
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
	/**
	 * Index of the folder in the database
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * Name of the folder
	 *
	 * @var string
	 */
	protected ?string $name = null;
	/**
	 * Index of the parent folder of this folder (-1 if root)
	 *
	 * @var int
	 */
	protected ?int $id_parent = null;
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * Display the folder. Only use to display ('/' as directory separator is not a FULL standard, badly)
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		if ($attribute === null)
		{
			if ($this->id_parent === -1)
			{
				return $this->display('name') . '/';
			}
			return $this->getParent()->display() . $this->display('name') . '/';
		}
		return $this->display_($attribute);
	}
	/**
	 * get the config file
	 *
	 * @return string
	 */
	public function getConfigFile() : string
	{
		return $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['config']['core']['config']['filename'];
	}
	/**
	 * get the locale file
	 *
	 * @return string
	 */
	public function getLocaleFile() : string
	{
		return $GLOBALS['config']['core']['path']['locale'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['locale']['core']['locale']['abbr'] . '.' . $GLOBALS['config']['core']['locale']['filename'];
	}
	/**
	 * get the lang file
	 *
	 * @return string
	 */
	public function getLangFile() : string
	{
		return $GLOBALS['config']['core']['path']['lang'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['lang']['core']['lang']['abbr'] . '.' . $GLOBALS['config']['core']['lang']['filename'];
	}
	/**
	 * get the parent folder
	 *
	 * @var \route\Folder
	 */
	public function getParent() : \route\Folder
	{
		if ($this->id_parent === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Folder']['getParent']['null']);
		}
		$Folder = new \route\Folder(array(
			'id' => $this->id_parent,
		));
		$Folder->retrieve();
		return $Folder;
	}
	/**
	 * Get the path to the folder
	 *
	 * @return string
	 */
	public function getPath() : string
	{
		if ($this->id_parent === -1)
		{
			return DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
		}
		if ($this->id_parent === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['error'], $GLOBALS['lang']['class']['route']['Folder']['getPath']['null']);
			throw new \Exception($GLOBALS['locale']['class']['route']['Folder']['getPath']['null']);
		}
		return $this->getParent()->getPath() . $this->name . DIRECTORY_SEPARATOR;
	}
}

?>
