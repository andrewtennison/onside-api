<?php
namespace Onside\Feed;
use \Onside\Feed;

class Twitter extends Feed
{
    protected $isJson = true;
    protected $type = 'twitter';
    
    protected $baseUrl = 'http://search.twitter.com/search.json?q=';
    protected $urls = array();
    
    public function addUser($user)
    {
	$this->urls[] = $this->baseUrl . $user;
    }
    
    public function getFeeds()
    {
	foreach ($this->urls as $url) {
//echo '$url: ' . $url . "\n";
	    $json = $this->sendCurlRequest($url);
	    $this->parseJson($json);
	}
    }
    
    public function getFeed()
    {
	$url = 'http://search.twitter.com/search.json?q=football';
	
	return $this->sendCurlRequest($url);
    }

    public function parseJson($json)
    {
	global $db;
	$mapper = new \Onside\Mapper\Article($db);
	
	$object = json_decode($json);
	$source = 'twitter';
	foreach ($object->results as $article) {
	    $author = $article->from_user_name;
	    $title = 'unmatched';
	    $date = date_parse_from_format('D, j M Y H:i:s O', $article->created_at);
	    $publish = "{$date['year']}-{$date['month']}-{$date['day']} {$date['hour']}:{$date['minute']}:{$date['second']}";
	    $content = $article->text;
	    $link = html_entity_decode($article->source); // extract url only
	    $image = isset($article->profile_image_url) ? $article->profile_image_url : '';
	    $data = array(
		'type' => $this->type,
		'author' => $author,
		'title' => $title,
		'images' => $image,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
		'link' => $link,
		'original' => json_encode($article),
	    );
	    $article = $mapper->addItem($data);
	}
    }
}
