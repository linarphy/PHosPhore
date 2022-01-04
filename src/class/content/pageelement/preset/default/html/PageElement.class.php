<?php

namespace content\pageelement\preset\default\html;

/**
 * Simple html PageElement
 */
class PageElement extends \content\pageelement\PageElement
{
	/**
	 * Constructor
	 *
	 * @param array $attributes Attributes of this object
	 */
	public function __construct(array $attributes)
	{
		if (\key_exists('template', $attributes))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['content']['pageelement']['preset']['already_template'], array('template' => $attributes['template']));
		}

		$attributes['template'] = $GLOBALS['config']['class']['content']['pageelement']['preset']['template_folder'] . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'PageElement.html';

		parent::__construct($attributes);
	}
}

?>
