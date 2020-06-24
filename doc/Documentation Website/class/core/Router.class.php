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
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['decode_mode_get'].' '.$url, 'router');
					return $this->retrieveWithGet();
					break;
				case $this::MODE_ROUTE:
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['decode_mode_route'].' '.$url, 'router');
					return $this->retrieveWithRoute($url);
					break;
				case $this::MODE_FULL_ROUTE:
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['decode_mode_fullroute'].' '.$url, 'router');
					return $this->retrieveWithFullRoute($url);
					break;
				default:
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknow_route_mode'], 'router');
					return array(
						'application' => $GLOBALS['config']['default_application'],
						'action'      => $GLOBALS['config']['page'][$GLOBALS['config']['default_application']]['default_action'],
					);
			}
			$this->__construct(init_router());
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
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknwon_application'].' '.$_GET['application'], 'router');
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
						new \exception\Warning($GLOBALS['lang']['class']['core']['router']['action_without_application'], 'router');
						$application=$lists[2][$action];
					}
				}
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknown_action'].' '.$_GET['action'], 'router');
				}
			}
			if (!isset($application))
			{
				$application=$GLOBALS['config']['default_application'];
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config']['page'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
					{
						include_once($GLOBALS['config']['path_config'].$application.'/config.php');
						include($GLOBALS['config']['path_config'].'config.php');
					}
				}
				$action=$GLOBALS['config']['page'][$application]['default_action'];
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
			}
			$parameters=$this->manageParameters($_GET, $application, $action);
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['application_used'].' '.$application.' '.$GLOBALS['lang']['class']['core']['router']['action_used'].' '.$action, 'router');
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
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknwon_application'], 'router');
				}
				if (in_array($matches[2], $lists[1]))
				{
					$action=$matches[2];
					if (!isset($application))
					{
						$application=$lists[2][$action];
					}
					else
					{
						new \exception\Warning($GLOBALS['lang']['class']['core']['router']['action_without_application'], 'router');
					}
				}
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknown_action'], 'router');
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
					else
					{
						new \exception\Warning($GLOBALS['lang']['class']['core']['router']['unknwon_application'], 'router');
					}
				}
			}
			if (!isset($application))
			{
				$application=$GLOBALS['config']['default_application'];
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config']['page'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].$application.'/config.php'))
					{
						include_once($GLOBALS['config']['path_config'].$application.'/config.php');
						include($GLOBALS['config']['path_config'].'config.php');
					}
				}
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
				$action=$GLOBALS['config']['page'][$application]['default_action'];
			}
			$parameters=$this->manageParameters($_GET, $application, $action);
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['application_used'].' '.$application.' '.$GLOBALS['lang']['class']['core']['router']['action_used'].' '.$action, 'router');
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
			$list=explode('/', trim(strtok($url, '?'), '/'));
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
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['action_without_application'], 'router');
				}
				else
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
					$application=$GLOBALS['config']['default_application'];
				}
			}
			if (!isset($action))
			{
				if (!isset($GLOBALS['config']['page'][$application]))
				{
					if (stream_resolve_include_path($GLOBALS['config']['path_config'].'page/'.$application.'/config.php'))
					{
						include_once($GLOBALS['config']['path_config'].'page/'.$application.'/config.php');
						include($GLOBALS['config']['path_config'].'config.php');
					}
				}
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
				$action=$GLOBALS['config']['page'][$application]['default_action'];
			}
			$parameters=$this->manageParameters($possible_parameters, $application, $action);
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['application_used'].' '.$application.' '.$GLOBALS['lang']['class']['core']['router']['action_used'].' '.$action, 'router');
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
			$this->loadFrom($application, $action);
			if (isset($GLOBALS['config']['page_general_parameters']))
			{
				$expected_parameters=$GLOBALS['config']['page_general_parameters'];
				new \exception\Notice($GLOBALS['lang']['class']['core']['router']['general_config_parameter_loaded'], 'router');
			}
			if (isset($GLOBALS['config']['page'][$application]['parameters']))
			{
				$expected_parameters=array_merge($expected_parameters, $GLOBALS['config']['page'][$application]['parameters']);
				new \exception\Notice($GLOBALS['lang']['class']['core']['router']['application_config_parameter_loaded'], 'router');
			}
			if (isset($GLOBALS['config']['page'][$application][$action]['parameters']))
			{
				$expected_parameters=array_merge($expected_parameters, $GLOBALS['config']['page'][$application][$action]['parameters']);
				new \exception\Notice($GLOBALS['lang']['class']['core']['router']['action_config_parameter_loaded'], 'router');
			}
			$keys=array_keys($possible_parameters);
			foreach ($expected_parameters as $name => $params)
			{
				new \exception\Notice($GLOBALS['lang']['class']['core']['router']['try_parameter'].' '.$name, 'router');
				if (in_array($name, $keys, true))
				{
					if (!preg_match('#'.$params['regex'].'#', $possible_parameters[$name]))
					{
						new \exception\Error($GLOBALS['lang']['class']['core']['router']['content_mismatch'], 'router');
					}
					else
					{
						$parameters[$name]=$possible_parameters[$name];
						unset($possible_parameters[$name]);
					}
				}
				else 		// Don't know the name of the parameters (full route mode only for now)
				{
					foreach ($possible_parameters as $key => $possible_parameter)
					{
						if (preg_match('#'.$params['regex'].'#', $possible_parameter))
						{
							$parameters[$name]=$possible_parameter;
							new \exception\Notice($GLOBALS['lang']['class']['core']['router']['found_parameter_name'].' '.$name.' '.$GLOBALS['lang']['class']['core']['router']['found_parameter_value'].' '.$possible_parameter, 'router');
							unset($possible_parameters[$key]);
							break;
						}
					}
				}
				if ($params['necessary'])
				{
					if (!isset($parameters[$name]))
					{
						new \exception\FatalError($GLOBALS['lang']['class']['core']['router']['missing_parameter'], 'router');
					}
				}
			}
			if (isset($possible_parameters))
			{
				if (!empty($possible_parameters))
				{
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['too_much_parameters'], 'router');
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
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['create_link_get'], 'router');
					return $this->createLinkGet($parameters);
					break;
				case $this::MODE_ROUTE:
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['create_link_route'], 'router');
					return $this->createLinkRoute($parameters);
					break;
				case $this::MODE_FULL_ROUTE:
					new \exception\Notice($GLOBALS['lang']['class']['core']['router']['create_link_fullroute'], 'router');
					return $this->createLinkFullRoute($parameters);
					break;
				default:
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['create_link_unknown'], 'router');
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
					$this->loadFrom($parameters['application']);
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
					return '?application='.$parameters['application'].'&action='.$GLOBALS['config']['page'][$parameters['application']]['default_action'].$additionnal_parameters;
				}
			}
			else
			{
				$this->loadFrom($GLOBALS['config']['default_application']);
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
				return '?application='.$GLOBALS['config']['default_application'].'&action='.$GLOBALS['config']['page'][$GLOBALS['config']['default_application']]['default_action'].$additionnal_parameters;
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
					$this->loadFrom($parameters['application']);
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
					return '/'.$parameters['application'].'/'.$GLOBALS['config']['page'][$parameters['application']]['default_action'].'/'.$additionnal_parameters;
				}
			}
			else
			{
				$this->loadFrom($GLOBALS['config']['default_application']);
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
				return '/'.$GLOBALS['config']['default_application'].'/'.$GLOBALS['config']['page'][$GLOBALS['config']['default_application']]['default_action'].'/'.$additionnal_parameters;
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
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
			}
			if (isset($parameters['action']))
			{
				$action=$parameters['action'];
			}
			else
			{
				$this->loadFrom($parameters['application']);
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
				$action=$GLOBALS['config']['page'][$application]['default_action'];
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
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['fill'], 'router');
			$lists=$this->generateApplicationAndAction();
			if (!isset($parameters['application']))
			{
				if (isset($parameters['action']))
				{
					$parameters['application']=$lists[2][$parameters['action']];				
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['action_without_application'], 'router');
				}
				else
				{
					$parameters['application']=$GLOBALS['config']['default_application'];
					new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_application'], 'router');
				}
			}
			if (!isset($parameters['action']))
			{
				$this->loadFrom($parameters['application']);
				$parameters['action']=$GLOBALS['config']['page'][$parameters['application']]['default_action'];
				new \exception\Warning($GLOBALS['lang']['class']['core']['router']['default_action'], 'router');
			}
			return $parameters;
		}
		/**
		* Load config or lang files for a specific application and action
		*
		* @param string application Application
		*
		* @param string action Action
		* 
		* @return void
		*/
		public function loadFrom(string $application, string $action='', string $file='config')
		{
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['load_from_start'].' '.$file, 'router');
			switch ($file)
			{
				case 'config':
					if (!empty($application))
					{
						if (stream_resolve_include_path($GLOBALS['config']['path_config'].'page/'.$application.'/config.php'))
						{
							include_once($GLOBALS['config']['path_config'].'page/'.$application.'/config.php');
							include($GLOBALS['config']['path_config'].'config.php');
							new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_config'].'page/'.$application.'/config.php', 'router');
						}
						if (!empty($action))
						{
							if (stream_resolve_include_path($GLOBALS['config']['path_config'].'page/'.$application.'/'.$action.'/config.php'))
							{
								include_once($GLOBALS['config']['path_config'].'page/'.$application.'/'.$action.'/config.php');
								include($GLOBALS['config']['path_config'].'config.php');
								new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_config'].'page/'.$application.'/'.$action.'/config.php', 'router');
							}
						}
					}
					break;
				case 'lang':
					global $Visitor;
					if (!empty($application))
					{
						if (stream_resolve_include_path($GLOBALS['config']['path_lang'].''.$application.'/lang.'.$Visitor->getConfiguration('lang').'.php'))
						{
							include_once($GLOBALS['config']['path_lang'].''.$application.'/lang.'.$Visitor->getConfiguration('lang').'.php');
							new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_lang'].''.$application.'/lang.'.$Visitor->getConfiguration('lang').'.php', 'router');
						}
						if (!empty($action))
						{
							if (stream_resolve_include_path($GLOBALS['config']['path_lang'].$application.'/'.$action.'/lang.'.$Visitor->getConfiguration('lang').'.php'))
							{
								include_once($GLOBALS['config']['path_lang'].$application.'/'.$action.'/lang.'.$Visitor->getConfiguration('lang').'.php');
								new \exception\Notice($GLOBALS['lang']['load_file'].' '.$GLOBALS['config']['path_lang'].$application.'/'.$action.'/lang.'.$Visitor->getConfiguration('lang').'.php', 'router');
							}
						}
					}
					break;
				default:
					new \exception\Error($GLOBALS['lang']['class']['core']['router']['unknown_type'], 'router');
			}
			new \exception\Notice($GLOBALS['lang']['class']['core']['router']['load_from_end'], 'router');
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