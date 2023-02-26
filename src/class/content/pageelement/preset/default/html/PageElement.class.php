<?php

namespace content\pageelement\preset\default\html;

$CONFIG = $GLOBALS
          ['config']
          ['class']
          ['content']
          ['pageelement']
          ['preset'];

$LANG = $GLOBALS
        ['lang']
        ['class']
        ['content']
        ['pageelement']
        ['preset'];

/**
 * Simple html PageElement
 */
class PageElement extends \content\pageelement\PageElement
{
	/**
	 * constructor
	 *
	 * @param array $attributes Attributes of this object
	 *
	 * @throws \exception\class\content\pageelement\preset\default\html\PageElementException
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
						\core\Logger::TYPES['info'],
					],
					$LANG
					['already_template'],
					[
						'template' => $attributes['template']
					]
				);
			}

			$attributes['template'] = $CONFIG
									  ['template_folder'] .
									  DIRECTORY_SEPARATOR .
									  'default' .
									  DIRECTORY_SEPARATOR .
									  'html' .
									  DIRECTORY_SEPARATOR .
									  'PageElement.html';

			header('Content-Type: text/html');

			parent::__construct($attributes);
		}
	}
	catch (
		\exception\class\content\pageelement\PageElementException |
		\Throwable $exception
	)
	{
		throw new \exception\class\content\pageelement\preset\default\html\PageElementException(
			message:      $LANG
			              ['default']
			              ['html']
			              ['PageElement']
			              ['__construct']
			              ['error'],
			tokens:       [
				'class'     => \get_class($this),
				'exception' => $exception->getMessage(),
			],
			notification: new \user\Notification([
				'content' => $LOCALE
				             ['default']
				             ['html']
				             ['PageElement']
				             ['__construct']
				             ['error'],
				'type'    => \user\NotificationTypes::WARNING,
			]),
			previous:     $exception,
		);
	}
}

?>
