<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    function xmlToArray($xml, $options = array()) {
        $defaults = array(
            'namespaceSeparator' => ':',//you may want this to be something other than a colon
            'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
            'alwaysArray' => array(),   //array of xml tag names which should always become arrays
            'autoArray' => true,        //only create arrays for tags which appear more than once
            'textContent' => '$',       //key used for the text content of elements
            'autoText' => true,         //skip textContent key if node has no attributes or child nodes
            'keySearch' => false,       //optional search and replace on tag and attribute names
            'keyReplace' => false       //replace values for above search values (as passed to str_replace())
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; //add base (empty) namespace
     
        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch']) $attributeName =
                        str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                        . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                        . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }
     
        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = $this->xmlToArray($childXml, $options);
                $childTagName = key($childArray);
                $childProperties = current($childArray);
     
                //replace characters in tag name
                if ($options['keySearch']) $childTagName =
                        str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                //add namespace prefix, if any
                if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
     
                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] =
                            in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }
     
        //get text content of node
        $textContentArray = array();
        $plainText = trim((string)$xml);
        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
     
        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
                ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
     
        //return node as array
        return array(
            $xml->getName() => $propertiesArray
        );
    }

    public function getForecastData($xml){
        $xml = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-'.$xml.'.xml';
        // $xml = 'Contoh.xml';
        $xmlNode = simplexml_load_file($xml);
        $arrayData = $this->xmlToArray($xmlNode);
        $forecasts['date'] = $arrayData['data']['forecast']['issue'];
        $forecasts['data'] = collect($arrayData['data']['forecast']['area']);

        return $forecasts;
    }

    public function getForecastParam($param, $hours, $forecast){ 
        if ($param=='weather') {
            $weatherCode = [
                '0' => 'Cerah',
                '1' => 'Cerah Berawan',
                '2' => 'Cerah Berawan',
                '3' => 'Berawan',
                '4' => 'Berawan Tebal',
                '5' => 'Udara Kabur',
                '10' => 'Asap',
                '45' => 'Kabut',
                '60' => 'Hujan Ringan',
                '61' => 'Hujan Sedang',
                '63' => 'Hujan Lebat',
                '80' => 'Hujan Lokal',
                '95' => 'Hujan Petir',
                '97' => 'Hujan Petir'
            ];
            
            $weatherCode = collect($weatherCode);
            $value = $forecast;

            if (!is_string($forecast)) {
                $value = collect($forecast['parameter'][6]['timerange']);
                $value = $value->where('@h', '>=', $hours)->first()['value']['$'];                
            }            
            
            $value = $weatherCode[$value];
        }

        if ($param=='temp') {  
            $value = collect($forecast['parameter'][5]['timerange']);
            $value = $value->where('@h', '>=', $hours)->first()['value'][0]['$'];
        }

        if ($param=='wind') {
            $value = collect($forecast['parameter'][8]['timerange']);
            $value = $value->where('@h', '>=', $hours)->first()['value'][3]['$'];
            $value = round($value, 2);
        }

        if ($param=='humid') {
            $value = collect($forecast['parameter'][0]['timerange']);
            $value = $value->where('@h', '>=', $hours)->first()['value']['$'];
        }        
        
        return $value;
    }
}
