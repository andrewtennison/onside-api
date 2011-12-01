<?php
namespace Onside\Feed\Map\Rss;
use \Onside\Feed\Map\Rss;

class Feedburner extends Rss
{
    public function getArticles()
    {
	$articles = array();
	if (isset($this->object->entry) && is_array($this->object->entry)) {
	    foreach ($this->object->entry as $article) {
		    $articles[] = $this->decodeArticle($article);
	    }
	}
	
	return $articles;
    }
    
    protected function decodeArticle($article)
    {
	$data = array();
	if (isset($article->author->name))
	    $data['author'] = $article->author->name;
	if (isset($article->title))
	    $data['title'] = 'unknown';
	    //$data['title'] = $article->title;
//	$data['date'] = date('Y-m-y H:i:s'); // defaulted because liverpoolfc don't provide date/time
	if (isset($article->published))
	    $data['date'] = $article->published;
	if (isset($article->content))
	    $data['content'] = $this->parseContent($article->content);
	if (isset($article->id))
	    $data['link'] = $article->id;
	$data['link'] = '';
	if (isset($article->link) && (string)$article->link == $article->link)
	    $data['link'] = $article->link;
	
	$data['original'] = json_encode($article);
	$data['type'] = $this->type;
	$data['source'] = ''; // TODO: pass in
	
//	echo print_r($data, true) . "\n";
	
	// TODO: return model rather than array
	return $data;
    }
}
