<?php
namespace Onside\Feed;
use \Onside\Feed;

class Rss extends Feed
{
    protected $isXml = true;
    
    public function getFeed()
    {
	$url = 'http://newsrss.bbc.co.uk/rss/sportplayer_uk_edition/football/rss.xml';
	
	return $this->sendCurlRequest($url);
    }

    public function parseJson($json)
    {
	global $db;
	$mapper = new \Onside\Mapper\Article($db);
	
	$object = json_decode($json);
	$image = $object->channel->image->url;
	foreach ($object->channel->item as $article) {
	    $author = 'unknown';
	    $title = $article->title;
	    $publish = $article->pubDate;
	    $content = $article->description;
	    $source = $article->guid;
	    $data = array(
		'author' => $author,
		'title' => $title,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
		'images' => $image,
	    );
	    $article = $mapper->addItem($data);
	}
    }
}
