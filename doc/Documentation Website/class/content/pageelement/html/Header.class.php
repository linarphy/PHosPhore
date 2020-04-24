<?php

namespace content\pageelement\html;

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
			global $Router;
			$li=array();
			$li[]=new \content\PageElement(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/header/li.html',
				'elements' => array(
					'href'  => '#',
					'title' => $GLOBALS['lang']['doc']['documentation_header_first']['title'],
					'link'  => $GLOBALS['lang']['doc']['documentation_header_first']['link'],
				),
			));
			foreach ($GLOBALS['lang']['doc']['documentation_header_li'] as $key => $element)
			{
				$li[]=new \content\PageElement(array(
					'template' => $GLOBALS['config']['path_template'].'pageelement/html/header/li.html',
					'elements' => array(
						'href'  => $Router->createLink($GLOBALS['config']['doc'][$element['href']]),
						'title' => $element['title'],
						'link'  => $element['link'],
					),
				));
			}
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/header/template.html',
				'elements' => array(
					'section' => $GLOBALS['lang']['doc']['documentation_header_title'],
					'li'      => $li,
				),
			));
		}
} // END class Header extends \content\PageElement

?>