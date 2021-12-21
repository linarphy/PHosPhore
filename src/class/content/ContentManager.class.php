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
	const TABLE = 'phosphore_content';
	/**
	 * index used
	 *
	 * @var array
	 */
	const INDEX = [
		'id_content',
		'lang',
	];
	/**
	 * attributes
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id_content',
		'lang',
		'text',
		'date_creation',
	];
}

?>
