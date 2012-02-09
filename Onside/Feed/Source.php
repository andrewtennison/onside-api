<?php
namespace Onside\Feed;
use \Onside\Model\Article;
 
class Source
{
    private $source;
    private $mapFields;
    private $mapLookups;
    private $articles;
    
    public function __construct(\Onside\Model\Source $source)
    {
	$this->articles = array();
	$this->mapFields = array();
	$this->mapLookups = array();
	$this->source = $source;
	$this->decodeMappings();
//	$json = $this->loadCurlResponse($source->id); // offline use
	$json = $this->sendCurlRequest($source->url); // online use
//echo "$json\n";
	$this->parseJson($json);
    }
    
    /**
     * @return array \Onside\Model\Article
     */
    public function getArticles()
    {
	return $this->articles;
    }
    
    private function decodeMappings()
    {
	$reflect = new \ReflectionClass($this->source);
	$this->mapFields = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
	foreach ($this->mapFields as $mapField) {
	    $name = $mapField->getName();
	    $value = $this->source->$name;
	    if (!preg_match('/^map/', $name)) continue;
	    $this->mapLookups[$name] = array('isLiteral' => true, 'value' => $value);
	    $this->mapLookups[$name]['value'] = strpos($value, '|') === false ? $value : explode('|', $value);
	    if (strpos($value, '->') !== false) $this->mapLookups[$name]['isLiteral'] = false;
	}
//echo print_r($this->mapLookups, true) . "\n";
    }
    
    private function xmlToJson($xml)
    {
//echo print_r($xml, true) . "\n";
	$sxml = @simplexml_load_string($xml);
	return $sxml ? $sxml : json_decode($xml);
	
	return $sxml ? json_encode($sxml) : $xml;
    }

    private function loadCurlResponse($id)
    {
	$feed = file_get_contents(APPLICATION_BASE . '/tmp/' . $id . '.feed');
	try
	{
	    $json = $this->xmlToJson($feed);
	    return $json;
	} catch (Exception $e) {}
	
	return $feed;
    }
    
    private function sendCurlRequest($url)
    {
	$curl = curl_init($url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $feed = curl_exec($curl);
	
	// TODO: handle CURL errors
	
	try
	{
	    $json = $this->xmlToJson($feed);
	    return $json;
	} catch (Exception $e) {}
	
	return $feed;
    }
    
    private function parseJson($json)
    {
//echo print_r($json, true) . "\n";
//	$json = json_decode($json);
//die(print_r($json, true));
	
	$lookup = '$items = $json' . $this->mapLookups['map_article']['value'] . ';';
//echo "$lookup\n";
	eval($lookup);
//echo print_r($items, true) . "\n";	
	foreach ($items as $article) {
//echo print_r($article, true) . "\n\n";
	    $this->parseArticle($json, $article);
	}
    }
    
    private function parseArticle($parent, $object)
    {
//echo print_r($object, true) . "\n";
	$data = array();
	$source = $this->parseSource($this->getElementMap($parent, $object, 'map_source'));
	$data['source'] = empty($source) ? 
		$this->source->url : $source;
	$data['original'] = json_encode($object);
	$data['type'] = $this->parseType($this->getElementMap($parent, $object, 'map_type'));
	$data['author'] = $this->parseAuthor($this->getElementMap($parent, $object, 'map_author'));
	$data['title'] = $this->parseTitle($this->getElementMap($parent, $object, 'map_title'));
	$data['publish'] = $this->parseDate($this->getElementMap($parent, $object, 'map_publish'));
	$data['content'] = $this->parseContent($this->getElementMap($parent, $object, 'map_content'));
	if (strlen($data['content']) > 250) {
	    $data['extended'] = $data['content'];
	    $data['content'] = substr($data['content'], 0, 250);
	}
	$data['link'] = $this->parseLink($this->getElementMap($parent, $object, 'map_link'));
	$data['images'] = $this->parseImages($this->getElementMap($parent, $object, 'map_images'));
//echo print_r($data, true) . "\n\n";
//die();
	$this->articles[] = Article::getModelFromArray($data);
    }
        
    private function getElementMap($parent, $object, $lookup)
    {
//echo print_r($parent, true) . "\n";
	if ($this->mapLookups[$lookup]['isLiteral']) {
	    return $this->mapLookups[$lookup]['value'];
	} else {
	    $fields = is_array($this->mapLookups[$lookup]['value']) ? 
		$this->mapLookups[$lookup]['value'] : 
		array($this->mapLookups[$lookup]['value']);
//echo 'getElementMap: ' . print_r($fields, true) . "\n\n";
	    foreach ($fields as $field) {
		$field = substr($field, 2);
		$parts = explode('->', $field);
		if (strpos($field, '@') !== false || count($parts) > 1) {
		    if (property_exists($object, $parts[0])) {
			$array = (array)$object->$parts[0];
		    }
		    if (property_exists($parent, $parts[0])) {
			$array = (array)$parent->$parts[0];
		    }
		    for($i = 1; $i < count($parts); $i++) {
			if (is_array($array)) {
			    $array = $array[$parts[$i]];
			} else {
			    $array = $array->$parts[$i];
			}
		    }
		    
		    return $array;
		}
//echo "\$field: $field\n";
		if (property_exists($object, $field)) {
//		if (isset($object->$field)) {
//echo "isset(\$object->$field): " . print_r($object->$field, true) . "\n";
			return $object->$field;
		}
		if (property_exists($parent, $field)) {
//		if (isset($parent->$field)) {
//echo "isset(\$parent->$field): " . print_r($parent->$field, true) . "\n";
			return $parent->$field;
		}
	    }
	}
    }
    
    private function parseAuthor($value)
    {
	if (is_object($value)) {
	    $strvalue = (string)$value;
	    if (!empty($strvalue))
		return $strvalue;
	    return;
	}
	return $value;
    }
    private function parseType($value) { return $value; }
    private function parseTitle($value)
    {
	// TODO: source ID=12
//echo 'parseTitle($value): ' . print_r($value, true) . "\n\n";
	
	if (is_object($value)) {
	    $strvalue = (string)$value;
	    if (!empty($strvalue))
		return $strvalue;
	    return;
	}

	return $value;
    }
    private function parseDate($value)
    {
	// If no date found default to now
	if (empty($value))
	    return date('Y-m-d H:i:s');
	
	if (strlen($value) == 25) {
	    $date = date_parse_from_format('D, j M Y H:i:s', $value); // without e
	} else {
	    $date = date_parse_from_format('D, j M Y H:i:s e', $value); // most common format
	}
//echo print_r($date, true) . "\n\n";
	if ($date['error_count'] > 0) {
	    if (strpos($value, 'T') !== false && strpos($value, '-') !== false) {
		list($d, $t) = explode('T', $value);
//echo print_r($d, true) . "\n\n";
//echo print_r($t, true) . "\n\n";
		list($date['year'], $date['month'], $date['day']) = explode('-', $d);
		list($date['hour'], $date['minute'], $date['second']) = explode(':', $t);
	    }
	}
	$date['month'] = sprintf('%02s', (int)$date['month']);
	$date['day'] = sprintf('%02s', (int)$date['day']);
	$date['hour'] = sprintf('%02s', (int)$date['hour']);
	$date['minute'] = sprintf('%02s', (int)$date['minute']);
	$date['second'] = sprintf('%02s', floor($date['second']));
	
	return "{$date['year']}-{$date['month']}-{$date['day']} {$date['hour']}:{$date['minute']}:{$date['second']}";
    }
    private function parseContent($value)
    {
	// TODO: source ID=14/25
	if (is_object($value)) {
	     $strvalue = (string)$value;
	    if (!empty($strvalue))
		return $strvalue;
	    return;
	}
	
	return $value;
    }
    private function parseLink($value)
    {
	if (is_object($value)) {
	     $strvalue = (string)$value;
	    if (!empty($strvalue))
		return $strvalue;
	    return;
	}
	
	return $value;
    }
    private function parseImages($value)
    {
	// TODO: source ID=8/13/36/37
//echo 'parseImages($value): ' . print_r($value, true) . "\n\n";
	if (is_object($value)) {
	    $value = (array)$value;
	    if (empty($value))
		return;
	    // TODO: handle when content exists
	}

	return $value;
    }
    private function parseSource($value)
    {
//echo 'parseSource($value): ' . print_r($value, true) . "\n\n";
	if (is_object($value)) {
	    $strvalue = (string)$value;
	    if (!empty($strvalue))
		return $strvalue;
	    return;
	}
	return $value;
    }
}