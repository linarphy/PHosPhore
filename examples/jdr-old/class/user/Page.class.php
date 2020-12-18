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
			return $this->displayPageElement();
		}
		/**
		* Sends notifications in the session
		*
		* @param \user\Notification $Notification Notification to be sent within the session
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
		public function addParameter($name, $value)
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
			if (isset($GLOBALS['config'][$this->getApplication()]['config']))
			{
				$array=array_merge($array, $GLOBALS['config'][$this->getApplication()]['config']);
			}
			if (isset($GLOBALS['config'][$this->getApplication()][$this->getAction()]['config']))
			{
				$array=array_merge($array, $GLOBALS['config'][$this->getApplication()][$this->getAction()]['config']);
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
			if ($this->getApplication()!==null)
			{
				if (stream_resolve_include_path($GLOBALS['config']['path_config'].$this->getApplication().'/config.php'))
				{
					include($GLOBALS['config']['path_config'].$this->getApplication().'/config.php');
					if ($this->getAction()!==null)
					{
						if (stream_resolve_include_path($GLOBALS['config']['path_config'].$this->getApplication().'/'.$this->getAction().'/config.php'))
						{
							include($GLOBALS['config']['path_config'].$this->getApplication().'/'.$this->getAction().'/config.php');
						}
					}
				}
				if (stream_resolve_include_path($GLOBALS['config']['path_lang'].$this->getApplication().'/'.$Visitor->getConfiguration('lang').'.lang.php'))
				{
					include($GLOBALS['config']['path_lang'].$this->getApplication().'/'.$Visitor->getConfiguration('lang').'.lang.php');
					if ($this->getAction()!==null)
					{
						if (stream_resolve_include_path($GLOBALS['config']['path_lang'].$this->getApplication().'/'.$this->getAction().'/'.$Visitor->getConfiguration('lang').'.lang.php'))
						{
							include($GLOBALS['config']['path_lang'].$this->getApplication().'/'.$this->getAction().'/'.$Visitor->getConfiguration('lang').'.lang.php');
						}
					}
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
			$name_class='\content\pageelement\\';
			foreach ($GLOBALS['config']['default_content_type'] as $content_type)
			{
				if (strtolower(trim($pageConfig['content_type'])) === $content_type['name'])
				{
					$name_class_content=$name_class.$content_type['content'];
					$PageElement=new $name_class_content();
					$name_class_notification=$name_class.$content_type['notification'];
					$NotificationElement=new $name_class_notification();
					break;
				}
			}
			if (!isset($PageElement) && !isset($NotificationElement))
			{
				if (isset($pageConfig['content']))
				{
					$PageElement=new \content\pageelement\Page($pageConfig['content']);
				}
				else
				{
					$PageElement=new \content\pageelement\Page(array());
				}
				if (isset($pageConfig['notification_element']))
				{
					$NotificationElement=new \content\pageelement\Notification($pageConfig['notification_element']);
				}
				else
				{
					$NotificationElement=new \content\pageelement\Notification(array());
				}
			}
			if ($pageConfig['notification'])
			{
				$Notifications=$Visitor->retrieveNotifications();
				if (isset($_SESSION['notifications']))
				{
					foreach ($_SESSION['notifications'] as $notification_serialized)
					{
						$Notification=unserialize($notification_serialized);
						$Notification->sendNotification($PageElement, $NotificationElement);
					}
					unset($_SESSION['notifications']);
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