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
	protected $parent_id;
	/**
	 * Display the folder. Only use to display ('/' as directory separator is not a FULL standard, badly)
	 *
	 * @return string
	 */
	public function display()
	{
		if ($this->parent_id === -1)
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
		return $GLOBALS['config']['core']['path']['config'] . 'page' . $this->getPath() . $GLOBALS['config']['core']['file']['config'];
	}
	/**
	 * get the locale file
	 *
	 * @return string
	 */
	public function getLocaleFile()
	{
		return $GLOBALS['config']['core']['path']['locale'] . 'page' . $this->getPath() . $GLOBALS['locale']['core']['lang']['abbr'] . GLOBALS['config']['core']['file']['locale'];
	}
	/**
	 * get the lang file
	 *
	 * @return string
	 */
	public function getLangFile()
	{
		return $GLOBALS['config']['core']['path']['lang'] . 'page' . $this->getPath() . $GLOBALS['lang']['core']['lang']['abbr'] . $GLOBALS['config']['core']['file']['lang'];
	}
	/**
	 * get the parent folder
	 *
	 * @var \route\Folder
	 */
	public function getParent()
	{
		$Folder = new \route\Folder(array(
			'id' => $this->parent_id,
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
		if ($this->parent_id === -1)
		{
			return DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR;
		}
		return $this->getParent()->get('name') . $this->name . DIRECTORY_SEPARATOR;
	}
}

?>
