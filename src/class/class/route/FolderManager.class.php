<?php

namespace route;

/**
 * Manager of \core\Folder
 */
class FolderManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'folder';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id',
		'name',
		'id_parent',
	);
}

?>
