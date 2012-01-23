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
	$sxml = simplexml_load_string($xml);
	return json_encode($sxml);
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
	$json = json_decode($json);
//die(print_r($json, true));
//	$parts = explode('->', substr($this->mapLookups['map_article']['value'], 2));
//	foreach ($parts as $part) {
//	    $json = $this->getElement($json, $part);
//	}
//die(print_r($json, true));
	
	$lookup = '$items = $json' . $this->mapLookups['map_article']['value'] . ';';
//echo "$lookup\n";
	eval($lookup);
//echo print_r($items, true) . "\n";	
	foreach ($items as $article) {
//echo print_r($article, true) . "\n\n";
	    $this->parseArticle($article);
	}
    }
    
    private function parseArticle($object)
    {
	/**
	 * author
	 * date
	 * title
	 * content
	 * link
	 * original
	 * type
	 * source
	 */
	$data = array();
	$data['source'] = $this->source->url;
	$data['original'] = json_encode($object);
	$data['type'] = $this->parseType($this->getElementMap($object, 'map_type'));
	$data['author'] = $this->parseAuthor($this->getElementMap($object, 'map_author'));
	$data['title'] = $this->parseTitle($this->getElementMap($object, 'map_title'));
	$data['date'] = $this->parseDate($this->getElementMap($object, 'map_publish'));
	$data['content'] = $this->parseContent($this->getElementMap($object, 'map_content'));
	$data['link'] = $this->parseLink($this->getElementMap($object, 'map_link'));
	$data['images'] = $this->parseImages($this->getElementMap($object, 'map_images'));
//echo print_r($data, true) . "\n\n";
//die();
	$this->articles[] = Article::getModelFromArray($data);
    }
        
    private function getElementMap($object, $lookup)
    {
	if ($this->mapLookups[$lookup]['isLiteral']) {
	    return $this->mapLookups[$lookup]['value'];
	} else {
	    $fields = is_array($this->mapLookups[$lookup]['value']) ? $this->mapLookups[$lookup]['value'] : array($this->mapLookups[$lookup]['value']);
//echo 'getElementMap: ' . print_r($fields, true) . "\n\n";
	    foreach ($fields as $field) {
		$field = substr($field, 2);
		$parts = explode('->', $field);
//echo 'getElementMap: ' . print_r($parts, true) . "\n\n";
		if (strpos($field, '@') !== false) {
//    echo "manual: " . $object->enclosure->@attributes->url . "\n\n";
		    $array = (array)$object->$parts[0];
//echo "->enclosure->@attributes->url: " . print_r($array, true) . "\n\n";
		    for($i = 1; $i < count($parts); $i++) {
			if (is_array($array)) {
			    $array = $array[$parts[$i]];
			} else {
			    $array = $array->$parts[$i];
			}
		    }
//echo 'final $array: ' . $array . "\n\n";
		    return $array;
		}
		if (isset($object->$field))
			return $object->$field;
	    }
	}
    }
    
    private function parseAuthor($value) { return $value; }
    private function parseType($value) { return $value; }
    private function parseTitle($value)
    {
	// TODO: source ID=12
//echo 'parseTitle($value): ' . print_r($value, true) . "\n\n";
	
	if (is_object($value)) {
	    $value = (array)$value;
	    if (empty($value))
		return;
	    // TODO: handle when content exists
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
	    $value = (array)$value;
	    if (empty($value))
		return;
	    // TODO: handle when content exists
	}
	
	return $value;
    }
    private function parseLink($value) { return $value; }
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
}