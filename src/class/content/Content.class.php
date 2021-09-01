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

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['start_retrieve']);

		if ($this->exist())
		{
			$this->retrieve();
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['success_retrieve']);
		}
		else if ($Manager->existBy(array('id_content' => $this->id_content)))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['warning_retrieve']);
			if ($Manager->exist(array('id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang'])))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['success_user_retrieve']);
				$this->hydrate($Manager->get(array('id_content' => $this->id_content, 'lang' => $GLOBALS['Visitor']->getConfigurations()['lang'])));
			}
			else if ($Manager->exist(array('id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['lang'])))
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['success_default_retrieve']);
				$this->hydrate($Manager->get(array('id_content' => $this->id_content, 'lang' => $GLOBALS['config']['core']['lang'])));
			}
			else
			{
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['success_any_retrieve']);
				$this = $this->retrieveBy(array('id_content' => $this->id_content))[0];
			}
		}
		else
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['content']['content']['failure_retrieve']);

			$Notification = new \user\Notification(array(
				'text' => $GLOBALS['locale']['class']['content']['content']['failure_retrieve'],
				'type' => \user\Notification::TYPE_WARNING,
			));
			$Notification->addToSession();

			$this->text = $GLOBALS['locale']['class']['content']['content']['default_text'];
			$this->date_creation = $GLOBALS['locale']['class']['content']['content']['default_date_creation'];
		}
	}
}

?>
