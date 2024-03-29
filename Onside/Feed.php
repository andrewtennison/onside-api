<?php
namespace Onside;

abstract class Feed
{
    protected $isJson = false;
    protected $isXml = false;
    
    protected $baseUrl;
    
    abstract public function getFeed();
//    public function addSource($options);
//    public function storeToFile($filename = null);
//    public function saveToDb();
    
    public function isJsonFormat() { return $this->isJson; }
    public function isXmlFormat() { return $this->isXml; }
    
    protected function xmlToJson($xml)
    {
	$sxml = simplexml_load_string($xml);
//die(json_encode($sxml));
	return json_encode($sxml);
    }

    protected function sendCurlRequest($url)
    {
	$curl = curl_init($url);
//curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $feed = curl_exec($curl);
	
	// TODO: handle CURL errors
	
//	$xml = simplexml_load_string($feed);
//	if ($this->isXml || $xml !== false) {
	if ($this->isXml) {
	    $json = $this->xmlToJson($feed);
	    return $json;
	}
	return $feed;
    }
    
    protected function associateWithChannel($article, $channel)
    {
//echo "associateWithChannel($article, $channel)\n";
	global $db;
	
	// Lookup channel id from name
	$model = \Onside\Model\Channel::getModelFromArray(array());
	$model->setWhere('name', $channel);
	$sql = $model->getSelectSQL();
        $args = $model->getValues();
	$c = $db->prepared($sql, $args)->fetchAll(\PDO::FETCH_CLASS, '\Onside\Model\Channel');

	$model = \Onside\Model\Carticle::getModelFromArray(array('article' => $article, 'channel' => $c[0]->id));
	$carticle = $db->prepared($model->getInsertSQL(), $model->getValues());
    }
}
