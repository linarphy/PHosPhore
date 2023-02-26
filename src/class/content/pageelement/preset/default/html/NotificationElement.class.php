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
					\core\LoggerTypes::INFO,
					$GLOBALS
					['lang']
					['class']
					['content']
					['pageelement']
					['preset']
					['already_template'],
					[
						'template' => $attributes['template'],
					],
				);
			}

			$attributes['template'] = $GLOBALS
									  ['config']
									  ['class']
									  ['content']
									  ['pageelement']
									  ['preset']
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
				message:      $GLOBALS
				              ['lang']
				              ['class']
				              ['content']
				              ['pageelement']
				              ['preset']
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
					'content' => $GLOBALS
				                 ['locale']
					             ['class']
				                 ['content']
				                 ['pageelement']
				                 ['preset']
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
