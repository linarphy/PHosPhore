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
	protected $id_content;
	/** Code corresponding to a language ()
	 *
	 * @var string
	 **/
	protected $lang;
	/**
	 * Content (which is found with the id_content and the lang, or defined without)
	 *
	 * @var string
	 */
	protected $text;
	/**
	 * Date of the content creation
	 *
	 * @var string
	 **/
	protected $date_creation;
	/** Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTES = array(
		'id_content'    => 'int',
		'lang'          => 'string',
		'text'          => 'string',
		'date_creation' => 'string',
	);
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
	 */
	public function retrieveText()
	{
		$Manager = $this->Manager();

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['start']);

		if ($this->exist())
		{
			$this->retrieve();
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success']);
		}
		else if ($Manager->existBy(array('id_content' => $this->id_content)))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['warning']);
			if ($Manager->exist(array('id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang'])))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_user_lang']);
				$this->hydrate($Manager->get(array('id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang'])));
			}
			else if ($Manager->exist(array('id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['locale']['default'])))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_default_lang']);
				$this->hydrate($Manager->get(array('id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['lang'])));
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['success_any']);
				$this = $this->retrieveBy(array('id_content' => $this->id_content))[0];
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['Content']['retrieveText']['failure']);

			$Notification = new \user\Notification(array(
				'text' => $GLOBALS['locale']['class']['content']['Content']['retrieveText']['failure'],
				'type' => \user\Notification::TYPE_WARNING,
			));
			$Notification->addToSession();

			$this->text = $GLOBALS['locale']['class']['content']['Content']['retrieveText']['default'];
			$this->date_creation = $GLOBALS['locale']['class']['content']['content']['default_date_creation'];
		}

		return $this->text;
	}
}

?>
