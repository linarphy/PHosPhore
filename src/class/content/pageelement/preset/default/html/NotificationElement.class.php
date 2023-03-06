<?php

namespace content\pageelement\preset\default\html;

/**
 * Simple html notification element
 */
class NotificationElement extends \content\pageelement\PageElement
{
	/**
	 * constructor
	 *
	 * @param array $attributes Attributes of this object
	 *
	 * @throws \exception\class\content\pageelement\preset\default\html\NotificationElementException
	 */
	public function __construct(array $attributes)
	{
		try
		{
			if (\key_exists('template', $attributes))
			{
				$GLOBALS['Logger']->log(
					[
						'class',
						'core',
						\core\LoggerTypes::INFO,
					],
					$this->lang(
						'preset',
						'already_template',
						'content\\pageelement',
					),
					[
						'template' => $attributes['template'],
					],
				);
			}

			$attributes['template'] = $this->config(
				'preset',
				'template_folder',
				'content\\pageelement'
			) . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR .
			'html' . DIRECTORY_SEPARATOR . 'NotificationElement.html';

			parent::__construct($attributes);
		}
		catch (\exception\class\content\pageelement\PageElementException $exception)
		{
			throw new \exception\class\content\pageelement\preset\default\html\NotificationElementException(
				message:  $this->lang(
					'__construct',
					'error',
					'content\\pageelement\\preset\\default\\html\\NotificationElement'
				),
				tokens:   [
					'class'     => \get_class($this),
					'exception' => $exception->getMessage(),
				],
				previous: $exception,
			);
		}
	}
}


?>
