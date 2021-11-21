<?php

namespace \content\pageelement\preset\default\html;

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
	public function __construct($attributes)
	{
		if ($attributes['template'] !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['content']['pageelement']['preset']['already_template'], array('template' => $attributes['template']));
		}

		$attributes['template'] = $GLOBALS['config']['core']['path']['template'] . $GLOBALS['config']['class']['content']['pageelement']['preset']['template_folder'] . 'default' . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'PageElement.html';

		parent->__construct($attributes);
	}
}

?>
