<?php

namespace user;

/**
 * Page viewed by the user
 *
 * @author gugus2000
 **/
class Page
{
	/* Attribute */

		/**
		* Page application
		*
		* @var string
		*/
		protected $application;
		/**
		* Page action
		*
		* @var string
		*/
		protected $action;
		/**
		* Additional page parameters
		* 
		* @var array
		*/
		protected $parameters;
		/**
		* Element representing the content of the page
		* 
		* @var PageElement
		*/
		protected $pageElement;

	/* Method */

		/* Getter */

			/**
			* application accessor
			*
			* @return string
			*/
			public function getApplication()
			{
				return $this->application;
			}
			/**
			* action accessor
			*
			* @return string
			*/
			public function getAction()
			{
				return $this->action;
			}
			/**
			* parameters accessor
			* 
			* @return array
			*/
			public function getParameters()
			{
				return $this->parameters;
			}
			/**
			* pageElement accessor
			* 
			* @return \content\PageElement
			*/
			public function getPageElement()
			{
				return $this->pageElement;
			}

		/* Setter */

			/**
			* application setter
			*
			* @param string $application Page application
			*
			* @return void
			*/
			protected function setApplication($application)
			{
				$this->application=(string)$application;
			}
			/**
			* action setter
			*
			* @param string $action Page action
			*
			* @return void
			*/
			protected function setAction($action)
			{
				$this->action=(string)$action;
			}
			/**
			* parameters setter
			*
			* @param array $parameters Additional page parameters
			* 
			* @return void
			*/
			protected function setParameters($parameters)
			{
				$this->parameters=$parameters;
			}
			/**
			* pageElement setter
			*
			* @param \content\PageElement $pageElement Element representing the content of the page
			* 
			* @return void
			*/
			protected function setPageElement($pageElement)
			{
				$this->pageElement=$pageElement;
			}

		/* Display */

			/**
			* application display
			*
			* @return string
			*/
			public function displayApplication()
			{
				return htmlspecialchars((string)$this->application);
			}
			/**
			* action display
			*
			* @return string
			*/
			public function displayAction()
			{
				return htmlspecialchars((string)$this->action);
			}
			/**
			* parameters display
			* 
			* @return string
			*/
			public function displayParameters()
			{
				return htmlspecialchars((string)$this->parameters);
			}
			/**
			* pageElement display
			* 
			* @return string
			*/
			public function displayPageElement()
			{
				return $this->pageElement->display();
			}

		/**
		* \user\Page display
		* 
		* @return string
		*/
		public function display()
		{
			global $Visitor;
			switch (strtolower(trim($this->getParameters()['config_perso']['content_type'])))
			{
				case 'html':
					if ($this->getPageElement()->getElement('head'))
					{
						if ($this->getPageElement()->getElement('head')->getElement('metas'))
						{
							$this->getPageElement()->getElement('head')->addValueElement('metas', array(
								'charset' => 'utf-8',
								'lang'    => $Visitor->getConfiguration('lang'),
							));
						}
						if ($this->getPageElement()->getElement('head')->getElement('title'))
						{
							$this->getPageElement()->getElement('head')->addValueElement('title', $GLOBALS['lang']['html_title_prefix']);
						}
					}
					else
					{
						$this->getPageElement()->addElement('head', '');
					}
					if (!$this->getPageElement()->getElement('notifications'))
					{
						$this->getPageElement()->addElement('notifications', '');
					}
					if (!$this->getPageElement()->getElement('body'))
					{
						$this->getPageElement()->addElement('body', '');
					}
					break;
				default:
					break;
			}
			return $this->displayPageElement();
		}
		/**
		* Sends notifications in the session
		*
		* @param \content\pageelement\Notification $Notification Notification to be sent within the session
		* 
		* @return void
		*/
		static public function addNotificationSession($Notification)
		{
			if (isset($_SESSION['notifications']))
			{
				$_SESSION['notifications'][]=serialize($Notification);
			}
			else
			{
				$_SESSION['notifications']=array(serialize($Notification));
			}
		}
		/**
		* Gets the path of the definition file of the page to display
		*
		* @return string
		*/
		public function getPath()
		{
			return $GLOBALS['config']['path_page_definition_root'].$this->getApplication().'/'.$this->getAction().'/'.$GLOBALS['config']['path_page_definition_filename'];
		}
		/**
		* Gives the path of the page template file
		* 
		* @return string
		*/
		public function getTemplatePath()
		{
			return $GLOBALS['config']['path_template'].$this->getApplication().'/'.$this->getAction().'/'.$GLOBALS['config']['path_template_filename'];
		}
		/**
		* Add a parameter in the page
		*
		* @param string $name Parameter name (key)
		*
		* @param mixed $value Parameter value
		* 
		* @return void
		*/
		public function ajouterParametre($name, $value)
		{
			$this->setParametres(array_merge($this->getParameters(), array($name => $value)));
		}
		/**
		* Loading the page config
		* 
		* @return array
		*/
		public function loadPageConfig()
		{
			$array=$GLOBALS['config']['default_config'];
			if (isset($GLOBALS['config'][$this->getApplication().'_config']))
			{
				$array=array_merge($array, $GLOBALS['config'][$this->getApplication().'_config']);
			}
			if (isset($GLOBALS['config'][$this->getApplication().'_'.$this->getAction().'_config']))
			{
				$array=array_merge($array, $GLOBALS['config'][$this->getApplication().'_'.$this->getAction().'_config']);
			}
			return $array;
		}
		/**
		* Create a \user\Page instance
		*
		* @param array $attributes Page attributes
		*
		* @return void
		*/
		public function __construct($attributes)
		{
			global $Visitor;
			foreach ($attributes as $key => $value)
			{
				$method='set'.ucfirst($key);
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
			$pageConfig=$this->loadPageConfig();
			$parameters=$this->getParameters();
			if (isset($parameters['config_perso']))
			{
				$pageConfig=array_merge($parameters['config_perso'], $pageConfig);
			}
			$parameters['config_perso']=$pageConfig;
			$this->setParameters($parameters);
			switch (strtolower(trim($pageConfig['content_type'])))
			{
				case 'html':
					$PageElement=new \content\pageelement\HTML();
					$NotificationElement=new \content\pageelement\html\HTMLNotification();
					break;
				default:
					$PageElement=new \content\pageElement($pageConfig['content']);
					$NotificationElement=new \content\pageelement\Notification($pageConfig['notification']);
					break;
			}
			if ($pageConfig['notification'])
			{
				$Notifications=$Visitor->retrieveNotifications();
				if (isset($_SESSION['notification']))
				{
					foreach ($_SESSION['notification'] as $notification_serialized)
					{
						$Notification=unserialize($notification_serialized);
						$Notification->sendNotification($PageElement, $NotificationElement);
					}
					unset($_SESSION['notification']);
				}
				foreach ($Notifications as $Notification)
				{
					$Notification->sendNotification($PageElement, $NotificationElement);
				}
			}
			$this->setPageElement($PageElement);
		}
} // END class Page

?>