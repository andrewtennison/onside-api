<?php
namespace Onside\Feed\Map\Rss;
use \Onside\Feed\Map\Rss;

class Gazettelive extends Rss
{
    public function getArticles()
    {
	$articles = array();
	if (isset($this->object->channel))
	    $articles[] = $this->decodeArticle($this->object->channel);
	
	return $articles;
    }
    
    protected function decodeArticle($article)
    {
	$data = array();
	$data['author'] = 'unknown';
	if (isset($article->title))
	    $data['title'] = $article->title;
//	$data['date'] = date('Y-m-y H:i:s'); // defaulted because liverpoolfc don't provide date/time
	if (isset($article->lastBuildDate))
	    $data['date'] = $this->parseDate($article->lastBuildDate);
	if (isset($article->description))
	    $data['content'] = $article->description;
	if (isset($article->link))
	    $data['link'] = $article->link;
	
	$data['original'] = json_encode($article);
	$data['source'] = ''; // TODO: pass in
	
//	echo print_r($data, true) . "\n";
	
	// TODO: return model rather than array
	return $data;
    }
}
