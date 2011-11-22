<?php
namespace Onside\Feed;
use \Onside\Feed;

class Youtube extends Feed
{
    protected $isXml = true;
    protected $type = 'youtube';
    
    public function getFeed()
    {
	$url = 'http://gdata.youtube.com/feeds/api/users/LiverpoolFC/uploads?orderby=updated';
	return $this->sendCurlRequest($url);
    }
    
    public function parseJson($json)
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
	    );
	    $article = $mapper->addItem($data);
	}
    }
}