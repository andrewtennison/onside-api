<?php
namespace Onside\Feed;
use \Onside\Feed;

class Youtube extends Feed
{
    protected $isXml = true;
    
    public function getFeed()
    {
	$url = 'http://gdata.youtube.com/feeds/api/users/LiverpoolFC/uploads?orderby=updated';
	return $this->sendCurlRequest($url);
    }
    
    public function parseJson($json)
    {
	global $db;
	$mapper = new \Onside\Mapper\Article($db);
	
	$object = json_decode($json);
	foreach ($object->entry as $article) {
	    $author = $article->author->name;
	    $title = $article->title;
	    $publish = $article->published;
	    $content = $article->content;
	    $source = $article->id;
	    $data = array(
		'author' => $author,
		'title' => $title,
		'publish' => $publish,
		'content' => $content,
		'source' => $source,
	    );
	    $article = $mapper->addItem($data);
	}
    }
}
