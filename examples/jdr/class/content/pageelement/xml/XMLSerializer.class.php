<?php

namespace content\pageelement\xml;

/**
 * A simple XML Serializer
 *
 * @author gugus2000
 **/
class XMLSerializer
{
    /* constant */

        /**
        * Name of the attribute conataining a class name for an object
        *
        * @var string
        */
        const ATTR_OBJ='obj';
        /**
        * Name of the attribute containing a index for an indexed array
        *
        * @var string
        */
        const ATTR_IND='index';
        /**
        * Default name for a node in an indexed array
        *
        * @var string
        */
        const DEF_NAME_IND='node';

    /* method */

        /**
        * Generate XML from "things"
        *
        * @param mixed thing Thing to serialize
        *
        * @param string node_name Name of the node
        *
        * @param array attributes Attributes of the nodes
        * 
        * @return string
        */
        public static function generateXml($thing, string $node_name='node', array $attributes=array())
        {
            $attributes_content = '';
            if (!empty($attributes))
            {
                foreach ($attributes as $name => $value)
                {
                    $attributes_content .= ' '.$name.'="'.$value.'"';
                }
            }
            if (is_array($thing))
            {
                return '<'.$node_name.$attributes_content.'>'.self::generateXmlArr($thing).'</'.$node_name.'>';
            }
            else if (is_object($thing))
            {
                return '<'.$node_name.$attributes_content.'>'.self::generateXmlObj($thing).'</'.$node_name.'>';
            }
            else
            {
                return '<'.$node_name.$attributes_content.'>'.htmlspecialchars((string)$thing).'</'.$node_name.'>';
            }
        }
        /**
        * Generate XML from array
        *
        * @param array arr Array to serialize
        * 
        * @return string
        */
        public static function generateXmlArr(array $arr)
        {
            $xml = '';
            foreach ($arr as $key => $val)
            {
                $attributes=array();
                if (is_object($val))
                {
                    $attributes[self::ATTR_OBJ] = get_class($val);
                }
                if (is_numeric($key))
                {
                    $attributes[self::ATTR_IND] = $key;
                    $key = self::DEF_NAME_IND;
                }
                $xml .= self::generateXml($val, $key, $attributes);
            }
            return $xml;
        }
        /**
        * Generate XML from object
        *
        * @param mixed obj Oject to serialize
        * 
        * @return string
        */
        public static function generateXmlObj($obj)
        {
            if (method_exists($obj, 'obj2arr'))
            {
                $result = $obj->obj2arr();
            }
            else
            {
                $result = get_object_vars($obj);
            }
            return self::generateXmlArr($result);
        }
} // END class XMLSerializer


?>