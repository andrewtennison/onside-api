<?php
namespace Onside\Feed;
use \Onside\Feed;

class Rss extends Feed
{
    protected $isXml = true;
    protected $type = 'rss';
    
    protected $urls = array();
    protected $maps = array();
    
    public function getFeed()
    {
	$url = 'http://newsrss.bbc.co.uk/rss/sportplayer_uk_edition/football/rss.xml';
	
	return $this->sendCurlRequest($url);
    }
    
    public function addRss($url, $channel = null, $map = null)
    {
	$this->urls[$url] = $channel;
	$this->maps[] = $map;
    }

    public function getFeeds()
    {
	$i = 0;
	foreach ($this->urls as $url => $channel) {
	    $json = $this->sendCurlRequest($url);
	    $this->parseJson($json, $channel, $this->maps[$i]);
	    $i++;
	}
    }
    
    public function parseJson($json, $channel = null, $map = null)
    {
	global $db;
	$mapper = new \Onside\Mapper\Article($db);
	
	if (null === $map) $map = '\Onside\Feed\Map\Rss';
	$feedmap = new $map($json);
	$articles = $feedmap->getArticles();
	foreach ($articles as $article) {
//echo print_r($article, true) . "\n";
	    $result = $mapper->addItem($article);
if (!isset($result[0]->id)) {
    echo print_r($result, true) . "\n";
} else {
	    $this->associateWithChannel($result[0]->id, $channel);
}
	}
	/**
	$object = json_decode($json);
//	$image = $object->channel->image->url;
	$source = 'bbc.co.uk';
//	$link = $object->channel->link;
	foreach ($object->channel->item as $article) {
	    $author = 'unknown';
	    $title = $article->title;
	    $date = date_parse_from_format('D, j M Y H:i:s e', $article->pubDate);
	    $publish = "{$date['year']}-{$date['month']}-{$date['day']} {$date['hour']}:{$date['minute']}:{$date['second']}";
//echo '$publish: ' . $publish . "\n";
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
//		'images' => $image,
		'original' => json_encode($article),
	    );
	    $article = $mapper->addItem($data);
	    $this->associateWithChannel($article[0]->id, $channel);
	}
	 */
    }
}
