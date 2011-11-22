<?php
namespace Onside\Feed;
use \Onside\Feed;

class Twitter extends Feed
{
    protected $isJson = true;
    protected $type = 'twitter';
    
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
	    $link = $article->source;
	    $data = array(
		'type' => $this->type,
		'author' => $author,
		'title' => $title,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
		'link' => $link,
	    );
	    $article = $mapper->addItem($data);
	}
    }
}
