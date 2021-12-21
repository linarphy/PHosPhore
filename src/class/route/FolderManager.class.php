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
	const TABLE = 'phosphore_folder';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id',
		'name',
		'id_parent',
	];
}

?>
