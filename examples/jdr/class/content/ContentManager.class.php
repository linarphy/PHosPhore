<?php

namespace content;

/**
 * Manager of \content\Content
 *
 * @author gugus2000
 **/
class ContentManager extends \core\Manager
{
	/* Constant */

		/**
		* table used by content\Content
		*
		* @var string
		*/
		const TABLE='content';
		/**
		* Index used (primary key)
		*
		* @var string
		*/
		const INDEX='text';
		/**
		* Attributes
		*
		* @var array
		*/
		const ATTRIBUTES=array(
			0 => 'id_content',
			1 => 'lang',
			2 => 'text',
			3 => 'date_creation',
		);
} // END class ContentManager extends \core\Manager

?>