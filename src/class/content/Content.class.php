<?php

namespace content;

/**
 * A content in a specific language
 */
class Content extends \core\Managed
{
	/**
	 * Content ID (not unique)
	 *
	 * @var int
	 */
	protected ?int $id_content = null;
	/** Code corresponding to a language ()
	 *
	 * @var string
	 **/
	protected ?string $lang = null;
	/**
	 * Content (which is found with the id_content and the lang, or defined without)
	 *
	 * @var string
	 */
	protected ?string $text = null;
	/**
	 * Date of the content creation
	 *
	 * @var string
	 **/
	protected ?string $date_creation = null;
	/** Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = [
		'id_content'    => 'int',
		'lang'          => 'string',
		'text'          => 'string',
		'date_creation' => 'string',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id_content',
		'lang',
	];
	/**
	 * Display the content within a readable and safe form
	 *
	 * @return string
	 */
	public function display()
	{
		return htmlspecialchars($this->displayer('text'));
	}
	/**
	 * Retrieves the text with its id and lang
	 *
	 * @return string
	 */
	public function retrieveText() : string
	{
		$GLOBALS['Hook']->load(['class', 'content', 'Content', 'retrieveText', 'start'], $this);
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['start']);

		$Manager = $this->Manager();

		if ($this->exist())
		{
			$this->retrieve();
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success']);
		}
		else if ($Manager->existBy(['id_content' => $this->id_content]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['warning']);
			if ($Manager->exist(['id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang']]))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_user_lang']);
				$this->hydrate($Manager->get(['id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang']]));
			}
			else if ($Manager->exist(['id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['locale']['default']]))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_default_lang']);
				$this->hydrate($Manager->get(['id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['lang']]));
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_any']);
				$this = $this->retrieveBy(['id_content' => $this->id_content])[0];
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['failure']);

			$Notification = new \user\Notification([
				'text' => $GLOBALS['locale']['class']['content']['Content']['retrieveText']['failure'],
				'type' => \user\Notification::TYPE_WARNING,
			]);
			$Notification->addToSession();

			$this->text = $GLOBALS['locale']['class']['content']['Content']['retrieveText']['default'];
			$this->date_creation = $GLOBALS['locale']['class']['content']['content']['default_date_creation'];
		}
		$GLOBALS['Hook']->load(['class', 'content', 'Content', 'retrieveText', 'end'], $this);

		return $this->text;
	}
}

?>
