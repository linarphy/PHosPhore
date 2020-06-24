<?php

namespace content\pageelement\documentation;

/**
 * An Header for \content\pageelement\html\Documentation
 *
 * @author gugus2000
 * 
 **/
class Header extends \content\PageElement
{
	/* Method */

		/**
		* Create a \content\pageelement\html\Header instance
		* 
		* @return void
		*/
		public function __construct()
		{
			global $Router, $Visitor;
			$GLOBALS['config']['class']['content']['pageelement']['html']['htmlhead']['default_css'][]=$GLOBALS['config']['path_asset'].'css/doc/header.css';
			$li=array();
			$li[]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/li.html',
				'elements' => array(
					'href'  => '#',
					'title' => $GLOBALS['lang']['class']['content']['pageelement']['documentation']['header']['first']['title'],
					'link'  => $GLOBALS['lang']['class']['content']['pageelement']['documentation']['header']['first']['link'],
				),
			));
			foreach ($GLOBALS['lang']['class']['content']['pageelement']['documentation']['header']['list'] as $key => $element)
			{
				$li[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/li.html',
					'elements' => array(
						'href'  => $Router->createLink($GLOBALS['config']['page']['doc']['links'][$element['href']]),
						'title' => $element['title'],
						'link'  => $element['link'],
					),
				));
			}
			foreach ($GLOBALS['config']['lang_available'] as $key => $language)
			{
				if ($key!==$Visitor->getConfiguration('lang'))
				{
					$li[]=new \content\PageElement(array(
						'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/li.html',
						'elements' => array(
							'href'  => $Router->createLink(array_merge($Router->decodeRoute($_SERVER['REQUEST_URI']),array($GLOBALS['config']['route_parameter'] => array('lang' => $key)))),
							'title' => $language['full'],
							'link'  => $language['abbr'],
						),
					));
				}
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/template.html',
				'elements' => array(
					'section' => $GLOBALS['lang']['class']['content']['pageelement']['documentation']['header']['title'],
					'li'      => $li,
				),
			));
		}
} // END class Header extends \content\PageElement

?>