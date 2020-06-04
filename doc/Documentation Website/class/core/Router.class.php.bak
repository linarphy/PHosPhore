<?php

namespace core;

/**
 * Router that manages internal url generation and recovery
 *
 * @author gugus2000
 **/
class Router
{
	/* Attribute */

		/**
		* Operating mode of the router
		* 
		* @var int
		*/
		protected $mode;
	
	/* Constant */

		/**
		* Operating mode of the router with GET
		*
		* @var int
		*/
		const MODE_GET=0;
		/**
		* Operating mode of the router with /
		*
		* @var int
		*/
		const MODE_ROUTE=1;
		/**
		* Operating mode of the router with / only
		*
		* @var int
		*/
		const MODE_FULL_ROUTE=2;

	/* Method */

		/* Getter */

			/**
			* mode accessor
			* 
			* @return int
			*/
			public function getMode()
			{
				return $this->mode;
			}

		/* Setter */

			/**
			* mode setter
			*
			* @param int $mode Operating mode of the router
			*
			* @return void
			*/
			protected function setMode($mode)
			{
				$this->mode=$mode;
			}

		/**
		* Returns an array containing application, action and parameters transmitted by the url
		*
		* @param string $url Page URL
		* 
		* @return array
		*/
		public function decodeRoute($url)
		{
			switch ($this->getMode())
			{
				case $this::MODE_GET:
					return $this->retrieveWithGet();
					break;
				case $this::MODE_ROUTE:
					return $this->retrieveWithRoute($url);
					break;
				case $this::MODE_FULL_ROUTE:
					return $this->retrieveWithFullRoute($url);
					break;
				default:
					return array(
						'application' => $GLOBALS['config']['default_application'],
						'action'      => $GLOBALS['config'][$GLOBALS['config']['default_application']]['default_action'],
					);
			}
		}
		/**
		* Returns an array containing application, action and parameters transmitted by the url from GET
		* 
		* @return array
		*/
		public function retrieveWithGet()
		{
			$lists=$this->generateApplicationAndAction();
			if (isset($_GET['application']))
			{
				if (in_array($_GET['application'], $lists[0]))
				{
					$application=$_GET['application'];
					unset($_GET['application']);
				}
			}
			if (isset($_GET['action']))
			{
				if (in_array($_GET['action'], $lists[1]))
				{
					$action=$_GET['action'];
					unset($_GET['action']);
					if (!isset($application))
					{
						$application=$lists[2][$action];
					}
				}
			}
			if (!isset($application))
			{
				$application=$GLOBALS['config']['default_application'];
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
					{
						include($GLOBALS['config']['path_config'].$application.'/config.php');
					}
				}
				$action=$GLOBALS['config'][$application]['default_action'];
			}
			$parameters=$this->manageParameters($_GET, $application, $action);
			return array(
				'application'                         => $application,
				'action'                              => $action,
				$GLOBALS['config']['route_parameter'] => $parameters,
			);
		}
		/**
		* Returns an array containing application, action and parameters transmitted by the url from classic route with get
		*
		* @param string $url Page URL
		* 
		* @return mixed
		*/
		public function retrieveWithRoute($url)
		{
			$lists=$this->generateApplicationAndAction();
			$path=parse_url($url, PHP_URL_PATH);
			preg_match('#\/([\w]+)\/([\w]+)#', $path, $matches);
			if($matches)
			{
				if (in_array($matches[1],$lists[1]))
				{
					$application=$matches[1];
				}
				if (in_array($matches[2], $lists[1]))
				{
					$action=$matches[2];
					if (!isset($application))
					{
						$application=$lists[2][$action];
					}
				}
			}
			else
			{
				preg_match('#\/([\w]+)#', $path, $matches);
				if ($matches)
				{
					if (in_array($matches[1], $lists[0]))
					{
						$application=$matches[1];
					}
				}
			}
			if (!isset($application))
			{
				$application=$GLOBALS['config']['default_application'];
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
					{
						include($GLOBALS['config']['path_config'].$application.'/config.php');
					}
				}
				$action=$GLOBALS['config'][$application]['default_action'];
			}
			$parameters=$this->manageParameters($_GET, $application, $action);
			return array(
				'application'                         => $application,
				'action'                              => $action,
				$GLOBALS['config']['route_parameter'] => $parameters,
			);
		}
		/**
		* Returns an array containing application, action and parameters transmitted by the url from classic route only
		*
		* @param string $url Url de la page
		* 
		* @return array
		*/
		public function retrieveWithFullRoute($url)
		{
			$lists=$this->generateApplicationAndAction();
			$list=explode('/', trim(strtok(getenv('REQUEST_URI'), '?'), '/'));
			$possible_parameters=array();
			foreach ($list as $element)
			{
				if (!empty($element))
				{
					if (in_array($element, $lists[0]) & !isset($application))
					{
						$application=$element;
					}
					else if (in_array($element, $lists[1]) & !isset($action))
					{
						$action=$element;
					}
					else
					{
						$possible_parameters[]=$element;
					}
				}
			}
			if (!isset($application))
			{
				if (isset($action))
				{
					$application=$lists[2][$action];
				}
				else
				{
					$application=$GLOBALS['config']['default_application'];
				}
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
					{
						include($GLOBALS['config']['path_config'].$application.'/config.php');
					}
				}
				$action=$GLOBALS['config'][$application]['default_action'];
			}
			$parameters=$this->manageParameters($possible_parameters, $application, $action);
			return array(
				'application'                         => $application,
				'action'                              => $action,
				$GLOBALS['config']['route_parameter'] => $parameters,
			);
		}
		/**
		* Manage additionnal parameters
		*
		* @param array $possible_parameters Possible parameters usefull in this page
		*
		* @param string $application Application
		*
		* @param string $action Action
		* 
		* @return mixed
		*/
		public function manageParameters($possible_parameters, $application, $action)
		{
			$parameters=array();
			$expected_parameters=array();
			if (isset($GLOBALS['config']['general_parameters']))
			{
				$expected_parameters=$GLOBALS['config']['general_parameters'];
			}
			if (isset($GLOBALS['config'][$application.'_parameters']))
			{
				$expected_parameters=array_merge($expected_parameters, $GLOBALS['config'][$application.'_parameters']);
			}
			if (isset($GLOBALS['config'][$application.'_'.$action.'_parameters']))
			{
				$expected_parameters=array_merge($expected_parameters, $GLOBALS['config'][$application.'_'.$action.'_parameters']);
			}
			$keys=array_keys($possible_parameters);
			foreach ($expected_parameters as $name => $params)
			{
				if (in_array($name, $keys, true))
				{
					if (!preg_match('#'.$params['regex'].'#', $possible_parameters[$name]))
					{
						throw new \Exception($GLOBALS['lang']['class_router_argument_content_mismatch']);
					}
					$parameters[$name]=$possible_parameters[$name];
					unset($possible_parameters[$name]);
				}
				else
				{
					foreach ($possible_parameters as $key => $possible_parameter)
					{
						if (preg_match('#'.$params['regex'].'#', $possible_parameter))
						{
							$parameters[$name]=$possible_parameter;
							unset($possible_parameters[$key]);
							break;
						}
					}
				}
				if ($params['necessary'])
				{
					if (!isset($parameters[$name]))
					{
						throw new \Exception($GLOBALS['lang']['class_core_router_missing_parameter']);
					}
				}
			}
			if (isset($possible_parameters))
			{
				if (!empty($possible_parameters))
				{
					throw new \Exception($GLOBALS['lang']['class_core_router_too_much_parameters']);
				}
			}
			return $parameters;
		}
		/**
		* Generate applications and actions lists
		* 
		* @return array
		*/
		public function generateApplicationAndAction()
		{
			global $Visitor;
			$Permissions=$Visitor->getRole()->getPermissions();
			$list_applications=array();
			$list_actions=array();
			$list=array();
			foreach($Permissions as $Permission)
			{
				if (!in_array($Permission->getApplication(), $list_applications))
				{
					$list_applications[]=$Permission->getApplication();
				}
				if (!in_array($Permission->getAction(), $list_actions))
				{
					$list_actions[]=$Permission->getAction();
				}
				$list[$Permission->getAction()]=$Permission->getApplication();
			}
			return [$list_applications, $list_actions, $list];
		}
		/**
		* Create a link with an array containing an application, action and parameters
		*
		* @param array $parameters array containing an application, action and parameters
		* 
		* @return string
		*/
		public function createLink($parameters)
		{
			switch ($this->getMode())
			{
				case $this::MODE_GET:
					return $this->createLinkGet($parameters);
					break;
				case $this::MODE_ROUTE:
					return $this->createLinkRoute($parameters);
					break;
				case $this::MODE_FULL_ROUTE:
					return $this->createLinkFullRoute($parameters);
					break;
				default:
					return '/';
			}
		}
		/**
		* Create a link with an array containing an application, action and parameters in GET mode
		*
		* @param array $parameters array containing an application, action and parameters
		* 
		* @return string
		*/
		public function createLinkGet($parameters)
		{
			$additionnal_parameters='';
			if (isset($parameters[$GLOBALS['config']['route_parameter']]))
			{
				foreach ($parameters[$GLOBALS['config']['route_parameter']] as $nom => $valeur)
				{
					$additionnal_parameters.='&'.(string)$nom.'='.(string)$valeur;
				}
			}
			if (isset($parameters['application']))
			{
				if (isset($parameters['action']))
				{
					return '?application='.$parameters['application'].'&action='.$parameters['action'].$additionnal_parameters;
				}
				else
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$parameters['application'].'/config.php'))
					{
						include($GLOBALS['config']['path_config'].$parameters['application'].'/config.php');
					}
					return '?application='.$parameters['application'].'&action='.$GLOBALS['config'][$parameters['application']]['default_action'].$additionnal_parameters;
				}
			}
			else
			{
				if (stream_resolve_include_path($GLOBALS['config']['path_config'].$GLOBALS['config']['default_application'].'/config.php'))
				{
					include($GLOBALS['config']['path_config'].$GLOBALS['config']['default_application'].'/config.php');
				}
				return '?application='.$GLOBALS['config']['default_application'].'&action='.$GLOBALS['config'][$GLOBALS['config']['default_application']]['default_action'].$additionnal_parameters;
			}
		}
		/**
		* Create a link with an array containing an application, action and parameters in classic route mode with GET
		*
		* @param array $parameters array containing an application, action and parameters
		* 
		* @return string
		*/
		public function createLinkRoute($parameters)
		{
			$additionnal_parameters='';
			if (isset($parameters[$GLOBALS['config']['route_parameter']]))
			{
				foreach ($parameters[$GLOBALS['config']['route_parameter']] as $nom => $valeur)
				{
					$additionnal_parameters.='&'.(string)$nom.'='.(string)$valeur;
				}
			}
			if (strlen($additionnal_parameters)>0)
			{
				$additionnal_parameters=substr($additionnal_parameters, 1);
				$additionnal_parameters='?'.$additionnal_parameters;
			}
			if (isset($parameters['application']))
			{
				if (isset($parameters['action']))
				{
					return '/'.$parameters['application'].'/'.$parameters['action'].'/'.$additionnal_parameters;
				}
				else
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$parameters['application'].'/config.php'))
					{
						include($GLOBALS['config']['path_config'].$parameters['application'].'/config.php');
					}
					return '/'.$parameters['application'].'/'.$GLOBALS['config'][$parameters['application']]['default_action'].'/'.$additionnal_parameters;
				}
			}
			else
			{
				if (stream_resolve_include_path($GLOBALS['config']['path_config'].$GLOBALS['config']['default_application'].'/config.php'))
				{
					include($GLOBALS['config']['path_config'].$GLOBALS['config']['default_application'].'/config.php');
				}
				return '/'.$GLOBALS['config']['default_application'].'/'.$GLOBALS['config'][$GLOBALS['config']['default_application']]['default_action'].'/'.$additionnal_parameters;
			}
		}
		/**
		* Create a link with an array containing an application, action and parameters in classic route mode
		*
		* @param array $parameters array containing an application, action and parameters
		* 
		* @return string
		*/
		public function createLinkFullRoute($parameters)
		{
			if (isset($parameters['application']))
			{
				$application=$parameters['application'];
			}
			else
			{
				$application=$GLOBALS['config']['default_application'];
			}
			if (isset($parameters['action']))
			{
				$action=$parameters['action'];
			}
			else
			{
				if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
				{
					include($GLOBALS['config']['path_config'].$application.'/config.php');
				}
				$action=$GLOBALS['config'][$application]['default_action'];
			}
			if (isset($parameters[$GLOBALS['config']['route_parameter']]))
			{
				$parameters_string=implode('/', $parameters[$GLOBALS['config']['route_parameter']]);
			}
			else
			{
				$parameters_string='';
			}
			return '/'.$application.'/'.$action.'/'.$parameters_string;
		}
		/**
		* Fills incomplete parameters of a link if necessary
		*
		* @param array $parameters array containing an application, action and parameters
		* 
		* @return array
		*/
		public function fill($parameters)
		{
			$lists=$this->generateApplicationAndAction();
			if (!isset($parameters['application']))
			{
				if (isset($parameters['action']))
				{
					$parameters['application']=$lists[2][$parameters['action']];				
				}
				else
				{
					$parameters['application']=$GLOBALS['config']['default_application'];
				}
			}
			if (!isset($parameters['action']))
			{
				if (stream_resolve_include_path($GLOBALS['config']['path_config'].$parameters['application'].'/config.php'))
				{
					include($GLOBALS['config']['path_config'].$parameters['application'].'/config.php');
				}
				$parameters['action']=$GLOBALS['config'][$parameters['application']]['default_action'];
			}
			return $parameters;
		}
		/**
		* Create a \core\Router instance
		*
		* @param int $mode Router mode
		* 
		* @return void
		*/
		public function __construct($mode)
		{
			$this->setMode($mode);
		}
} // END class Router

?>