<?php

namespace content\pageelement\html;

/**
 * An HTML Notification
 *
 * @author gugus2000
 * 
 **/
class HTMLNotification extends \content\PageElement
{
	/* Method */

		/**
		* Create a \content\pageelement\html\HTMLNotification instance
		* 
		* @return void
		*/
		public function __construct()
		{
			parent::__construct(array(
				'template' => $GLOBALS['config']['path_template'].'pageelement/html/htmlnotification/template.html',
				'elements' => array(),
			));
		}

		/**
		* Set CSS et Javascripts link in the head
		*
		* @param \content\PageElement $PageElement The PageElement which contains the head
		* 
		* @return void
		*/
		public function setHead($PageElement)
		{
			if (isset($GLOBALS['config']['notification_css']))
			{
				foreach ($GLOBALS['config']['notification_css'] as $notification_css)
				{
					$PageElement->getElement('head')->addValueElement('css', $notification_css);
				}
			}
			if (isset($GLOBALS['config']['notification_js']))
			{
				foreach ($GLOBALS['config']['notification_js'] as $notification_js)
				{
					$PageElement->getElement('head')->addValueElement('javascripts', $notification_js);
				}
			}
		}
} // END class HTMLNotification extends \content\PageElement

?>