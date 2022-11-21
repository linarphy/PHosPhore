<?php

namespace user;

/**
 * notification for users
 */
class Notification extends \core\Managed
{
	use \core\Base
	{
		\core\Base::display as display_;
	}
	/**
	 * notification content
	 *
	 * @var string
	 */
	protected ?string $content = null;
	/**
	 * notification date
	 *
	 * @var string
	 */
	protected ?string $date = null;
	/**
	 * index of the notification in the database
	 *
	 * @var int
	 */
	protected ?int $id = null;
	/**
	 * index of the content of the notification
	 *
	 * @var int
	 */
	protected ?int $id_content = null;
	/**
	 * substitution array to complete the notification with dynamics values
	 *
	 * @var array
	 */
	protected ?array $substitution = null;
	/**
	 * notification type
	 *
	 * @var string
	 */
	protected mixed $type = null;
	/**
	 * Attributes with type
	 *
	 * @var array
	 */
	const ATTRIBUTE = [
		'content'      => 'string',
		'date'         => 'string',
		'id'           => 'int',
		'id_content'   => 'int',
		'substitution' => 'string',
		'type'         => 'string',
	];
	/**
	 * unique index
	 *
	 * @var array
	 */
	const INDEX = [
		'id',
	];
	/**
	 * vanilla possible types
	 *
	 * @var array
	 */
	const TYPES = [
		'debug'       => 'debug',
		'error'       => 'error',
		'fatal_error' => 'fatal_error',
		'info'        => 'info',
		'notice'      => 'notice',
		'success'     => 'success',
		'warning'     => 'warning',
	];
	/**
	 * add notification of this user to the session
	 *
	 * @return bool
	 */
	public function addToSession() : bool
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

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['addToSession']['success']);

		$_SESSION['__notifications__'][] = $this->table();

		return True;
	}
	/**
	 * create a notification
	 *
	 * @param array $id_users List of the index of the user concerned by the notification
	 *
	 * @return bool
	 */
	public function create(array $id_users) : bool
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

		$variants = [];
		foreach ($id_users as $id_user)
		{
			$variants[] = ['id_user' => $id_user]; // can be optimized for sure
		}

		$this->set('id', $this->Manager()->add($this->table()));

		$linkNotificationUser->addBy($variants, [
			'id_notification' => $this->get('id'),
		]);

		return True;
	}
	/**
	 * delete notification
	 *
	 * @return bool
	 */
	public function delete() : bool
	{
		if ($this->id_content === null || $this->id === null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['delete']['missing_attributes']);

			return False;
		}

		$id = $this->get('id');

		if (!$this->Manager()->delete(['id' => $id]))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['delete']['not_exist'], ['id' => $id]);

			return False;
		}

		$linkNotificationUser = new \user\LinkNotificationUser();
		$number = $LinkNotificationUser->deleteBy([
			'id_notification' => $id,
		]);

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['delete']['success'], ['number' => $number]);

		return True;
	}
	/**
	 * delete notifications you can get with getNotifications method
	 *
	 * @return int
	 */
	public static function deleteNotifications()
	{
		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['start']);
		$number = 0;
		if (\key_exists('__notifications__', $_SESSION)) // there is at least one notification stored in the session
		{
			if (\is_array($_SESSION['__notifications__']))
			{
				$number += \count($_SESSION['__notifications__']);
				$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['session'], ['number' => \count($_SESSION['__notifications__'])]);
				unset($_SESSION['__notifications__']);
			}
		}

		$id_user = $GLOBALS['config']['core']['login']['guest']['id'];
		if ($GLOBALS['Visitor'] !== null)
		{
			$id_user = $GLOBALS['Visitor']->get('id');
		}

		$LinkNotificationUser = new \user\LinkNotificationUser();
		$notifications_from_db = $LinkNotificationUser->getBy([
			'id_user' => $id_user,
		]);
		if (!empty($notifications_from_db))
		{
			$number += \count($notifications_from_db);
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['db'], ['number' => \count($notifications_from_db)]);
			$LinkNotificationUser->deleteBy([
				'id_user' => $id_user,
			]);
		}

		$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['deleteNotifications']['end'], ['number' => $number]);
		return $number;
	}
	/**
	 * display notification with a friendly and safe way
	 *
	 * @param ?string $attribute Attribute to display (entire object if null).
	 *                           Default to null.
	 *
	 * @return string
	 */
	public function display(?string $attribute = null) : string
	{
		if ($attribute === null)
		{
			return $this->display('type') . ': ' . $this->display('content');
		}
		return $this->display_($attribute);
	}
	/**
	 * display notification type
	 *
	 * @return string
	 */
	public function displayType() : string
	{
		if ($this->type === null)
		{
			return '';
		}
		if (\is_string($this->type))
		{
			return \htmlspecialchars($this->type);
		}
		else
		{
			return \htmlspecialchars($this->type->value);
		}
	}
	/**
	 * display notification content
	 *
	 * @return string
	 */
	public function displayContent() : string
	{
		if ($this->content !== null)
		{
			return \htmlspecialchars($this->get('content'));
		}

		$Content = $this->retrieveContent();
		if ($Content === False)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['displayContent']['no_content']);

			return '';
		}

		$tokens = \preg_split('/({(?:\\}|[^\\}])+})/Um', $Content->display('text'), -1, PREG_SPLIT_DELIM_CAPTURE);

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
		return \htmlspecialchars(\implode($tokens));
	}
	/**
	 * retrieve notification to display in this request
	 *
	 * @param \content\pageelement\PageElement $element Notifications element
	 *
	 * @return array
	 */
	public static function getNotifications(\content\pageelement\PageElement $element) : array
	{
		if ($element->getElement('content') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_content'], ['content' => $element->getElement('content')]);
		}
		if ($element->getElement('date') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_date'], ['date' => $element->getElement('date')]);
		}
		if  ($element->getElement('type') !== null)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['info'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['already_type'], ['type' => $element->getElement('type')]);
		}

		$notifications = [];
		if (\key_exists('__notifications__', $_SESSION)) // there is at least one notification stored in the session
		{
			if (\is_array($_SESSION['__notifications__']))
			{
				$notifications = [];
				foreach ($_SESSION['__notifications__'] as $notification)
				{
					$Notification = new \user\Notification($notification);
					$notifications[] = $Notification;
				}
			}
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_session'], ['number' => \count($_SESSION['__notifications__'])]);
		}

		$id_user = $GLOBALS['config']['core']['login']['guest']['id'];
		if ($GLOBALS['Visitor'] !== null)
		{
			$id_user = $GLOBALS['Visitor']->get('id');
		}

		$LinkNotificationUser = new \user\LinkNotificationUser();
		$notifications_from_db = $LinkNotificationUser->retrieveBy([
			'id_user' => $id_user,
		], '=', class_name: '\user\Notification', attributes_conversion: ['id_notification' => 'id']);

		if (!empty($notifications_from_db))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['debug'], $GLOBALS['lang']['class']['user']['Notification']['getNotifications']['in_db'], ['number' => \count($notifications_from_db)]);
			$notifications = \array_merge($notifications, $notifications_from_db);
		}

		$Notifications = [];

		foreach ($notifications as $notification)
		{
			$class = get_class($element);
			$elements = [];
			if ($notification->get('date') === null)
			{
				$date = new \DateTime('now');
				$elements['date'] = $date->format('Y-m-d H:i:s');
			}
			else
			{
				$elements['date'] = $notification->display('date');
			}
			$elements['type'] = $notification->display('type');

			if ($notification->get('id') === null) // notification in session
			{
				$elements['content'] = $notification->get('content');
			}
			else
			{
				/* retrieve content */
				$Content = new \content\Content(['id' => $notification->get('id_content')]);
				$Content->retrieveText();

				$elements['content'] = $Content->display();
			}

			$Notification = new $class([
				'elements' => $elements,
			]);


			$Notifications[] = $Notification;
		}

		return $Notifications;
	}
	/**
	 * retrieve the associated \content\Content
	 *
	 * @return \content\Content|null
	 */
	public function retrieveContent() : ?\content\Content
	{
		$locale = $GLOBALS['locale']['core']['locale'];

		$contentManager = new \content\ContentManager();

		$Contents = $contentManager->retrieveBy([
			'id'     => $this->get('id_content'),
			'locale' => $locale,
		]);
		if (empty($Contents))
		{
			$Contents = $contentManager->retrieveBy([
				'id' => $this->get('id_content'),
			]);
		}
		if (empty($Contents))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['user']['Notification']['retrieveContent']['no_content']);

			return null;
		}

		return $Contents[0];
	}
	/**
	 * retrieve users concerned by this notification
	 *
	 * @return array
	 */
	public function retrieveUsers() : array
	{
		$userManager = new \user\UserManager();
		return $userManager->retrieveBy([
			'id' => $this->get('id_users'),
		], [
			'id' => 'IN',
		]);
	}
}

?>
