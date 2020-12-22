<?php

namespace content;

/**
 * A content in a specific language
 *
 * @author gugus2000
 **/
class Content extends \core\Managed
{
	/* Attribute */

		/**
		* Content Id (not unique)
		* 
		* @var int
		*/
		protected $id_content;
		/**
		* Language of the text
		* 
		* @var string
		*/
		protected $lang;
		/**
		* Content Text
		* 
		* @var string
		*/
		protected $text;
		/**
		* Date of content creation
		* 
		* @var string
		*/
		protected $date_creation;

	/* Method */

		/* Getter */

			/**
			* id_content accessor
			* 
			* @return int
			*/
			public function getId_content()
			{
				return $this->id_content;
			}
			/**
			* lang accessor
			* 
			* @return string
			*/
			public function getLang()
			{
				return $this->lang;
			}
			/**
			* text accessor
			* 
			* @return string
			*/
			public function getText()
			{
				return $this->text;
			}
			/**
			* date_creation accessor
			* 
			* @return string
			*/
			public function getDate_creation()
			{
				return $this->date_creation;
			}

		/* Setter */

			/**
			* id_content setter
			*
			* @param int $id_content Content Id (not unique)
			* 
			* @return void
			*/
			protected function setId_content($id_content)
			{
				$this->id_content=(int)$id_content;
			}
			/**
			* lang setter
			*
			* @param string $lang Language of the text
			* 
			* @return void
			*/
			protected function setLang($lang)
			{
				$this->lang=(string)$lang;
			}
			/**
			* text setter
			*
			* @param string $text Content Text
			* 
			* @return void
			*/
			protected function setText($text)
			{
				$this->text=(string)$text;
			}
			/**
			* date_creation setter
			*
			* @param string $date_creation Date of content creation
			* 
			* @return void
			*/
			protected function setDate_creation($date_creation)
			{
				$this->date_creation=(string)$date_creation;
			}

		/* Display */

			/**
			* id_content display
			* 
			* @return string
			*/
			public function displayId_content()
			{
				return htmlspecialchars((string)$this->id_content);
			}
			/**
			* lang display
			* 
			* @return string
			*/
			public function displayLang()
			{
				return htmlspecialchars((string)$this->lang);
			}
			/**
			* text display
			* 
			* @return string
			*/
			public function displayText()
			{
				return htmlspecialchars((string)$this->text);
			}
			/**
			* date_creation
			* 
			* @return string
			*/
			public function displayDate_creation()
			{
				return htmlspecialchars((string)$this->date_creation);
			}

		/**
		* Retrieves the content according to its language (returns whether or not the content corresponds to the language)
		*
		* @param string $lang Desired language
		* 
		* @return void
		*/
		public function retrieveLang($lang)
		{
			$Manager=$this->Manager();
			$results=$Manager->getBy(array(
				'id_content' => $this->getId_content(),
			), array(
				'id_content' => '=',
			));
			if (!(bool)$results)
			{
				throw new \Exception($GLOBALS['lang']['class_content_content_no_result']);
			}
			foreach ($results as $result)
			{
				if ($result['lang']==$lang)
				{
					$this->hydrate($result);
					return True;
				}
				else if (!isset($this->texte) & $result['lang']==$GLOBALS['config']['user_config']['lang'])
				{
					$this->hydrate($result);
				}
			}
			if (!isset($this->text))
			{
				$this->hydrate($results[0]);
			}
			return False;
		}
		/**
		* \content\Content display
		* 
		* @return string
		*/
		public function display()
		{
			return $this->displayText();
		}
		/**
		* Determines the next content id not taken
		* 
		* @return int
		*/
		static public function determineNewId()
		{
			$Manager=new \content\ContentManager(\core\DBFactory::MysqlConnection());
			if ((bool)$Manager->getBy(array(
				'id_content' => '-1',
			), array(
				'id_content' => '!=',
			), array(
				'order' => 'id_content',
				'end'   => 0,
			)))
			{
				return (int)$Manager->getBy(array(
					'id_content' => '-1',
				), array(
					'id_content' => '!=',
				), array(
					'order' => 'id_content',
					'end'   => 0,
				))[0]['id_content']+1;
			}
			return 1;
		}
} // END class Content extends \core\Managed

?>