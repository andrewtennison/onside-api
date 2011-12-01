<?php
namespace Onside\Feed;

abstract class Map
{
    protected $object;
    
    public function __construct($json = null)
    {
	assert('$json !== null');
//echo '$json: ' . $json . "\n";
	$this->object = json_decode($json);
    }
    
    public function getArticles()
    {
	$articles = array();
	if (isset($this->object->channel)) {
	    if (isset($this->object->channel->item) && is_array($this->object->channel->item)) {
		foreach ($this->object->channel->item as $article) {
		    $articles[] = $this->decodeArticle($article);
		}
	    }
	}
	
	return $articles;
    }
    
    /**
    abstract public function getId() {}
    abstract public function getAuthor() {}
    abstract public function getTitle() {}
    abstract public function getContent() {}
    abstract public function getImages() {}
    abstract public function getVideos() {}
    */
}