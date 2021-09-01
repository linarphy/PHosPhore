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
	const TABLE = 'link_page_parameter';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_page',
		'id_parameter',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_page',
		'id_parameter',
	);
}

?>
