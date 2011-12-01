<?php
namespace Onside\Feed;
use \Onside\Feed;

class Youtube extends Feed
{
    protected $isXml = true;
    protected $type = 'youtube';
    
    protected $baseUrl = 'http://gdata.youtube.com/feeds/api/users/{user}/uploads?orderby=updated';
    protected $urls = array();
    
    public function addUser($user, $channel = null)
    {
	$this->urls[preg_replace('/\{user\}/', $user, $this->baseUrl)] = $channel;
    }
    
    public function getFeeds()
    {
	foreach ($this->urls as $url => $channel) {
	    $json = $this->sendCurlRequest($url);
	    $this->parseJson($json, $channel);
	}
    }
    
    public function getFeed()
    {
	$url = 'http://gdata.youtube.com/feeds/api/users/LiverpoolFC/uploads?orderby=updated';
	return $this->sendCurlRequest($url);
    }
    
    public function parseJson($json, $channel = null)
    {
	global $db;
	$attr = '@attributes';
	$mapper = new \Onside\Mapper\Article($db);
	
	$object = json_decode($json);
	$source = 'youtube';
	foreach ($object->entry as $article) {
	    $author = $article->author->name;
	    $title = $article->title;
	    $publish = $article->published;
	    $content = $article->content;
	    $link = $article->id;
	    $videos = '';
	    
	    // get video
	    $feed = $this->sendCurlRequest($link);
	    $feedobj = json_decode($feed);
	    foreach ($feedobj->link as $lnk) {
		if ($lnk->$attr->rel == 'alternate') {
		    $videos = $lnk->$attr->href;
		}
	    }
	    
	    $data = array(
		'type' => $this->type,
		'author' => $author,
		'title' => $title,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
		'link' => $link,
		'videos' => $videos,
		'original' => json_encode($article),
	    );
	    // TODO: Fix
if (gettype($content) == 'object') {
//echo '$article: ' . json_encode($article) . "\n";
//echo print_r($data, true) . "\n";
} else {
	    $article = $mapper->addItem($data);
	    $this->associateWithChannel($article[0]->id, $channel);
}
	}
    }
}
