<?php

namespace content\pageelement\xml;

/**
 * A simple XML unserializer
 *
 * @author gugus2000
 **/
class XMLUnserializer
{
	/**
	* Unserialize a "thing" serialized in xml
	*
	* @param \SimpleXMLElement xml XML
	* 
	* @return mixed
	*/
	public static function unserializeXml(\SimpleXMLElement $xml)
	{
		if (count($xml->children())>0)
		{
			if (isset($xml[\content\pageelement\xml\XMLSerializer::ATTR_OBJ]))
			{
				$obj=(string)$xml[\content\pageelement\xml\XMLSerializer::ATTR_OBJ];
				return new $obj(self::unserializeXmlArr($xml));
			}
			else
			{
				return self::unserializeXmlArr($xml);
			}
		}
		else
		{
			return (string)$xml;
		}
	}
	/**
	* Unserialize an array in xml
	*
	* @param \SimpleXMLElement xml XML array
	* 
	* @return array
	*/
	public function unserializeXmlArr(\SimpleXMLElement $xml)
	{
		$arr=array();
		foreach ($xml as $key => $val)
		{
			if (isset($val[\content\pageelement\xml\XMLSerializer::ATTR_IND]))
			{
				$key=(string)$val['index'];
			}
			$arr[$key]=self::unserializeXml($val);
		}
		return $arr;
	}
} // END class XMLunserializer

?>