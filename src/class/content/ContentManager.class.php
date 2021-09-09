<?php

namespace content;

/**
 * Manager of \content\Content
 */
class ContentManager extends \core\Manager
{
	/**
	 * table used
	 *
	 * @var string
	 */
	const TABLE = 'content';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = array(
		'id_content',
		'lang',
	);
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_content',
		'lang',
		'text',
		'date_creation',
	);
}

?>
