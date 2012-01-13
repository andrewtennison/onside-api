<?php
namespace Onside\Feed;

class Source
{
    private $source;
    private $mapFields;
    private $mapLookups;
    
    public function __construct(\Onside\Model\Source $source)
    {
	$this->mapFields = array();
	$this->mapLookups = array();
	$this->source = $source;
	$this->decodeMappings();
    }
    
    private function decodeMappings()
    {
	$reflect = new \ReflectionClass($this->source);
	$this->mapFields = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
//echo print_r($this->mapFields, true) . "\n";
	foreach ($this->mapFields as $mapField) {
	    $name = $mapField->getName();
	    $value = $this->source->$name;
echo "\$name=$name\n";
echo print_r($value, true) . "\n";
	    if (!preg_match('/^map/', $name)) continue;
	    $this->mapLookups[$name] = array('isLiteral' => true, 'value' => $value);
	    $this->mapLookups[$name]['value'] = strpos($value, '|') === false ? $value : explode('|', $value);
	    if (strpos($value, '->') !== false) $this->mapLookups[$name]['isLiteral'] = false;
	}
echo print_r($this->mapLookups, true) . "\n";
    }
    
    private function parseJson()
    {}
    
    /**
     * @return array \Onside\Model\Article
     */
    public function getArticles()
    {
	$articles = array();
	
	return $articles;
    }
}