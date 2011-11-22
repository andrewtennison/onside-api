<?php
namespace Onside\Feed;
use \Onside\Feed;

class Rss extends Feed
{
    protected $isXml = true;
    protected $type = 'rss';
    
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
	$source = 'bbc.co.uk';
//	$link = $object->channel->link;
	foreach ($object->channel->item as $article) {
	    $author = 'unknown';
	    $title = $article->title;
	    $publish = $article->pubDate;
	    $content = $article->description;
	    $link = $article->guid;
	    $data = array(
		'type' => $this->type,
		'author' => $author,
		'title' => $title,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
		'link' => $link,
		'images' => $image,
	    );
	    $article = $mapper->addItem($data);
	}
    }
}
