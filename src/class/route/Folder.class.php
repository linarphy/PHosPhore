<?php

namespace route;

/**
 * A real folder
 */
class Folder extends \core\Managed
{
	/**
	 * Index of the folder in the database
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * Name of the folder
	 *
	 * @var string
	 */
	protected $name;
	/**
	 * Index of the parent folder of this folder (-1 if root)
	 *
	 * @var int
	 */
	protected $id_parent;
	/**
	 * Display the folder. Only use to display ('/' as directory separator is not a FULL standard, badly)
	 *
	 * @return string
	 */
	public function display()
	{
		if ($this->id_parent === -1)
		{
			return $this->displayer('name') . '/';
		}
		return $this->getParent()->display() . $this->displayer('name') . '/';
	}
	/**
	 * get the config file
	 *
	 * @return string
	 */
	public function getConfigFile()
	{
		return $GLOBALS['config']['core']['path']['config'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['config']['core']['config']['filename'];
	}
	/**
	 * get the locale file
	 *
	 * @return string
	 */
	public function getLocaleFile()
	{
		return $GLOBALS['config']['core']['path']['locale'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['locale']['core']['locale']['abbr'] . '.' . $GLOBALS['config']['core']['locale']['filename'];
	}
	/**
	 * get the lang file
	 *
	 * @return string
	 */
	public function getLangFile()
	{
		return $GLOBALS['config']['core']['path']['lang'] . $GLOBALS['config']['core']['path']['page'] . $this->getPath() . $GLOBALS['lang']['core']['lang']['abbr'] . '.' . $GLOBALS['config']['core']['lang']['filename'];
	}
	/**
	 * get the parent folder
	 *
	 * @var \route\Folder
	 */
	public function getParent()
	{
		if ($this->id_parent === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['route']['Folder']['getParent']['null']);
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
	public function getPath()
	{
		if ($this->id_parent === -1)
		{
			return DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
		}
		return $this->getParent()->get('name') . $this->name . DIRECTORY_SEPARATOR;
	}
}

?>
