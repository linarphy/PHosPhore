<?php

namespace user;

/**
 * Manage link between pages and parameters
 */
class LinkPageParameter extends \core\LinkManager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'phosphore_link_page_page_parameter';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id_page',
		'id_parameter',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id_page',
		'id_parameter',
	];
}

?>
