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

$LOCALE = $GLOBALS
          ['locale']
          ['class']
          ['content']
          ['pageelement']
          ['preset'];

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
					$LANG
					['already_template'],
					[
						'template' => $attributes['template'],
					],
				);
			}

			$attributes['template'] = $CONFIG
									  ['template_folder'] .
									  DIRECTORY_SEPARATOR .
									  'default' .
									  DIRECTORY_SEPARATOR .
									  'html' .
									  DIRECTORY_SEPARATOR .
			                         'NotificationElement.html';

			parent::__construct($attributes);
		}
		catch (
			\exception\class\content\pageelement\PageElementException |
			\Throwable $exception
		)
		{
			throw new \exception\class\content\pageelement\preset\default\html\NotificationElementException(
				message:      $LANG
				              ['default']
				              ['html']
				              ['NotificationElement']
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
				                 ['NotificationElement']
					             ['__construct']
					             ['error'],
					'type'    => \user\NotificationTypes::WARNING,
				]),
				previous:     $exception,
			);
		}
	}
}


?>
