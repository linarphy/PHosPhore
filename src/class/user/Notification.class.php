<?php

namespace user;

/**
 * notification for users
 */
class Notification extends \core\Managed
{
	/**
	 * notification content
	 *
	 * @var string
	 */
	protected $content;
	/**
	 * notification date
	 *
	 * @var string
	 */
	protected $date;
	/**
	 * index of the notification in the database
	 *
	 * @var int
	 */
	protected $id;
	/**
	 * index of the content of the notification
	 *
	 * @var int
	 */
	protected $id_content;
	/**
	 * substitution array to complete the notification with dynamics values
	 *
	 * @var array
	 */
	protected $substitution;
	/**
	 * notification type
	 *
	 * @var string
	 */
	protected $type;
	/**
	 * vanilla possible types
	 *
	 * @var array
	 */
	const TYPES = array(
		'debug',
		'info',
		'notice',
		'warning',
		'error',
		'fatal_error',
	);
	/**
	 * add notification of this user to the session
	 *
	 * @return bool
	 */
	public function addToSession()
	{
		if ($this->id_content === null && $this->content === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['addToSession']['content']);

			return False;
		}
		if ($this->id_content !== null && $this->id === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['addToSession']['id']);

			return False;
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['success']);

		/** NOT SURE ABOUT SERIALIZE (no connection) **/
		$_SESSION['__notifications__'][] = serialize($this);

		return True;
	}
	/**
	 * create a notification
	 *
	 * @param array $id_users List of the index of the user concerned by the notification
	 *
	 * @return bool
	 */
	public function create($id_users)
	{
		if ($this->id_content === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['create']['id_content']);

			return False;
		}
		if (empty($id_users))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['create']['id_users']);

			return False;
		}

		$linkNotificationUser = new \user\LinkNotificationUser();

		$variants = array();
		foreach ($id_users as $id_user)
		{
			$variants[] = array('id_user' => $id_user); // can be optimized for sure
		}

		$this->set('id', $this->Manager()->add($this->table()));

		$linkNotificationUser->addBy($variants, array(
			'id_notification' => $this->get('id'),
		));

		return True;
	}
	/**
	 * delete notification
	 *
	 * @return bool
	 */
	public function delete()
	{
		if ($this->id_content === null || $this->id === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['delete']['missing_attributes']);

			return False;
		}

		$id = $this->get('id');

		if (!$this->Manager()->delete(array('id' => $id)))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['delete']['not_exist'], array('id' => $id));

			return False;
		}

		$linkNotificationUser = new \user\LinkNotificationUser();
		$number = $LinkNotificationUser->deleteBy(array(
			'id_notification' => $id,
		));

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['delete']['success'], array('number' => $number);

		return True;
	}
	/**
	 * display notification with a friendly and safe way
	 *
	 * @return string
	 */
	public function display()
	{
		return $this->displayer('type') . ': ' . $this->displayer('content');
	}
	/**
	 * display notification content
	 *
	 * @return string
	 */
	public function displayContent()
	{
		if ($this->content !== null)
		{
			return htmlspecialchars($this->get('content'));
		}

		$Content = $this->retrieveContent();
		if ($Content === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['displayContent']['no_content']);

			return '';
		}

		$tokens = preg_split('/({(?:\\}|[^\\}])+})/Um', $Content->displayer('text'), -1, PREG_SPLIT_DELIM_CAPTURE);

		foreach ($tokens as $key => $token)
		{
			foreach ($this->get('substitution') as $subs_key => $substitution)
			{
				if ($token === '{' . $subs_key . '}')
				{
					$token[$key] = $substitution;
					break; // no need to wait for every possibilities
				}
			}
		}
		return htmlspecialchars(implode($tokens));
	}
	/**
	 * retrieve notification to display in this request
	 *
	 * @param \content\pageelement\PageElement $element Notifications element
	 *
	 * @return array
	 */
	public static function getNotifications(\content\pageelement\PageElement $element)
	{
		if ($element->getElement('content') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_content'], array('content' => $content->getElement('content')));
		}
		if ($element->getElement('date') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['alrady_date'], array('date' => $content->getElement('date'));
		}
		if  ($element->getElement('type') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPRD['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['alrady_type'], array('type' => $element->getElement('type'));
		}

		$notifications = array();
		if ($_SESSION['__notifications__'] !== null) // there is at least one notification stored in the session
		{
			$notifications = $_SESSION['__notifications__'];
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_session'], array('number' => count($_SESSION['__notifications__'])));
		}

		$id_user = $GLOBALS['config']['core']['login']['guest']['id'];
		if ($GLOBALS['Visitor'] !== null)
		{
			$id_user = $GLOBALS['Visitor']->get('id');
		}

		$LinkNotificationUser = new \user\LinkNotificationUser();
		$notifications_from_db = $LinkNotificationUser->retrieveBy(array(
			'id_user' => $id_user,
		), '=', class_name: get_class_name(self), attributes_conversion: array('id_notification' => 'id'));

		if (!empty($notifications_from_db))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_db'], array('number' => count($notifications_from_db)));
			$notifications = array_merge($notifications, $notifications_from_db);
		}

		$Notifications = array();

		foreach ($notifications as $notification)
		{
			$Notification = $element->clone();

			$Notification->setElement('date', $notification->get('date'));
			$Notification->setElement('type', $notification->get('type'));

			if ($notification->get('id') === null) // notification in session
			{
				$Notification->setElement('content', $Notification->get('content'));
			}
			else
			{
				/* retrieve content */
				$Content = new \content\Content(array('id' => $notification->get('id_content')));
				$Content->retrieveText();

				$Notification->setElement('content', $Content->display());
			}

			$Notifications[] = $Notification;
		}

		return $Notifications;
	}
	/**
	 * retrieve the associated \content\Content
	 *
	 * @return \content\Content|False
	 */
	public function retrieveContent()
	{
		$locale = $GLOBALS['locale']['core']['locale'];

		$contentManager = new \content\ContentManager();

		$Contents = $contentManager->retrieveBy(array(
			'id'     => $this->get('id_content'),
			'locale' => $locale,
		));
		if (empty($Contents))
		{
			$Contents = $contentManager->retrieveBy(array(
				'id' => $this->get('id_content'),
			));
		}
		if (empty($Contents))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['retrieveContent']['no_content']);

			return False;
		}

		return $Contents[0];
	}
	/**
	 * retrieve users concerned by this notification
	 *
	 * @return array
	 */
	public function retrieveUsers()
	{
		$userManager = new \user\UserManager();
		return $userManager->retrieveBy(array(
			'id' => $this->get('id_users'),
		), array(
			'id' => 'IN',
		));
	}
}

?>
