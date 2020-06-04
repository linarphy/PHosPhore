<?php

namespace character;

/**
 * Attributes
 *
 * @author gugus2000
 **/
class Attributes extends \core\Managed
{
	/* constant */

		/**
		* Available attributes
		*
		* @var array
		*/
		const AV_ATTR=array('str', 'dex', 'con', 'int_', 'cha', 'agi', 'mag', 'acu');
	/* attribute */

		/**
		* If of the attributes
		* 
		* @var int
		*/
		protected $id;
		/**
		* Strength
		* 
		* @var int
		*/
		protected $str;
		/**
		* Dexterity
		* 
		* @var int
		*/
		protected $dex;
		/**
		* Constitution
		* 
		* @var int
		*/
		protected $con;
		/**
		* Intelligence
		* 
		* @var int
		*/
		protected $int_;
		/**
		* Charisma
		* 
		* @var int
		*/
		protected $cha;
		/**
		* Agility
		* 
		* @var int
		*/
		protected $agi;
		/**
		* Magic
		* 
		* @var int
		*/
		protected $mag;
		/**
		* Acuity
		* 
		* @var int
		*/
		protected $acu;

	/* method */

		/* getter */

			/**
			* id getter
			* 
			* @return int
			*/
			public function getId()
			{
				return $this->id;
			}
			/**
			* str getter
			* 
			* @return int
			*/
			public function getStr()
			{
				return $this->str;
			}
			/**
			* dex getter
			* 
			* @return int
			*/
			public function getDex()
			{
				return $this->dex;
			}
			/**
			* con getter
			* 
			* @return int
			*/
			public function getCon()
			{
				return $this->con;
			}
			/**
			* int getter
			* 
			* @return int
			*/
			public function getInt_()
			{
				return $this->int_;
			}
			/**
			* cha getter
			* 
			* @return int
			*/
			public function getCha()
			{
				return $this->cha;
			}
			/**
			* agi getter
			* 
			* @return int
			*/
			public function getAgi()
			{
				return $this->agi;
			}
			/**
			* mag getter
			* 
			* @return int
			*/
			public function getMag()
			{
				return $this->mag;
			}
			/**
			* acu getter
			* 
			* @return int
			*/
			public function getAcu()
			{
				return $this->acu;
			}

		/* setter */

			/**
			* id setter
			*
			* @param int id Id of the attributes
			* 
			* @return void
			*/
			protected function setId($id)
			{
				$this->id=(int)$id;
			}
			/**
			* str setter
			*
			* @param int str Strength
			* 
			* @return void
			*/
			protected function setStr($str)
			{
				$this->str=(int)$str;
			}
			/**
			* dex setter
			*
			* @param int dex Dexterity
			* 
			* @return void
			*/
			protected function setDex($dex)
			{
				$this->dex=(int)$dex;
			}
			/**
			* con setter
			*
			* @param int con Constitution
			* 
			* @return void
			*/
			protected function setCon($con)
			{
				$this->con=(int)$con;
			}
			/**
			* int setter
			*
			* @param int int_ Intelligence
			* 
			* @return void
			*/
			protected function setInt_($int_)
			{
				$this->int_=(int)$int_;
			}
			/**
			* cha setter
			*
			* @param int cha Charisma
			* 
			* @return void
			*/
			protected function setCha($cha)
			{
				$this->cha=(int)$cha;
			}
			/**
			* agi setter
			*
			* @param int agi Agility
			* 
			* @return void
			*/
			protected function setAgi($agi)
			{
				$this->agi=(int)$agi;
			}
			/**
			* mag setter
			*
			* @param int mag Magic
			* 
			* @return void
			*/
			protected function setMag($mag)
			{
				$this->mag=(int)$mag;
			}
			/**
			* acu setter
			*
			* @param int acu Acuity
			* 
			* @return void
			*/
			protected function setAcu($acu)
			{
				$this->acu=(int)$acu;
			}

		/* display */

			/**
			* id display
			* 
			* @return string
			*/
			public function displayId()
			{
				return htmlspecialchars((string)$this->id);
			}
			/**
			* str display
			* 
			* @return string
			*/
			public function displayStr()
			{
				return htmlspecialchars((string)$this->str);
			}
			/**
			* dex display
			* 
			* @return string
			*/
			public function displayDex()
			{
				return htmlspecialchars((string)$this->dex);
			}
			/**
			* con display
			* 
			* @return string
			*/
			public function displayCon()
			{
				return htmlspecialchars((string)$this->con);
			}
			/**
			* int display
			* 
			* @return string
			*/
			public function displayInt_()
			{
				return htmlspecialchars((string)$this->int_);
			}
			/**
			* cha display
			* 
			* @return string
			*/
			public function displayCha()
			{
				return htmlspecialchars((string)$this->cha);
			}
			/**
			* agi display
			* 
			* @return string
			*/
			public function displayAgi()
			{
				return htmlspecialchars((string)$this->agi);
			}
			/**
			* mag display
			* 
			* @return string
			*/
			public function displayMag()
			{
				return htmlspecialchars((string)$this->mag);
			}
			/**
			* acu display
			* 
			* @return string
			*/
			public function displayAcu()
			{
				return htmlspecialchars((string)$this->acu);
			}

		/**
		* Calculate roll for an attribute
		*
		* @param string attribute Name of the attribute
		* 
		* @return array
		*/
		public function calcRoll($attribute)
		{
			$method=$this->getGet($attribute);
			$value=$this->$method();
			$roll=array(
				'critical_failure' => 0,
			);
			if ($value<-36)
			{
				$roll['failure']=20+floor(-(36+$value)/8);
				$roll['success']=80;
				$roll['critical_success']=99;
			}
			else if ($value<-20)
			{
				$roll['failure']=20;
				$roll['success']=80;
				$roll['critical_success']=90+floor((-$value)/4);
			}
			else if ($value<0)
			{
				$roll['failure']=15+floor(-$value/4);
				$roll['success']=80;
				$roll['critical_success']=100;
			}
			else if ($value<10)
			{
				$roll['failure']=10+floor((10-$value)/2);
				$roll['success']=80;
				$roll['critical_success']=95;
			}
			else if ($value<20)
			{
				$roll['failure']=10;
				$roll['success']=80;
				$roll['critical_success']=90+floor((20-$value)/2);
			}
			else if ($value<80)
			{
				$roll['failure']=10;
				$roll['success']=100-$value;
				$roll['critical_success']=90;
			}
			else if ($value<90)
			{
				$roll['failure']=10-floor(($value-80)/2);
				$roll['success']=20;
				$roll['critical_success']=90;
			}
			else if ($value<100)
			{
				$roll['failure']=5;
				$roll['success']=20;
				$roll['critical_success']=90-floor(($value-90)/2);
			}
			else if ($value<120)
			{
				$roll['failure']=5;
				$roll['success']=20;
				$roll['critical_success']=85-floor(($value-100)/4);
			}
			else if ($value<136)
			{
				$roll['failure']=5-floor(($value-120)/4);
				$roll['success']=20;
				$roll['critical_success']=80;
			}
			else
			{
				$roll['failure']=1;
				$roll['success']=20;
				$roll['critical_success']=80-(($value-136)/8);
			}
			return $roll;
		}
} // END class Attributes extends \core\Managed

?>