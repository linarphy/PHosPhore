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
			$lang=$GLOBALS['lang']['class']['content']['pageelement']['documentation']['header'];
			$config=$GLOBALS['config']['class']['content']['pageelement']['documentation']['header'];
			$li=array();
			$li[]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/li.html',
				'elements' => array(
					'href'  => '#',
					'title' => $lang['first']['title'],
					'link'  => $lang['first']['link'],
				),
			));
			foreach ($lang['page'] as $key => $element)
			{
				$li[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'pageelement/documentation/header/li.html',
					'elements' => array(
						'href'  => $Router->createLink($config['links'][$key]),
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
					'section' => $lang['title'],
					'li'      => $li,
				),
			));
		}
} // END class Header extends \content\PageElement

?>
