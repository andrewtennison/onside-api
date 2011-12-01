<?php
namespace Onside\Feed\Map;
use \Onside\Feed\Map;

class Rss extends Map
{
    protected $type = 'rss';
    
    protected function decodeArticle($article)
    {
	$data = array();
	$data['author'] = 'unknown';
	if (isset($article->title))
	    $data['title'] = $article->title;
	if (!is_string($data['title']))
	    $data['title'] = '';
	$data['date'] = date('Y-m-y H:i:s'); // defaulted because liverpoolfc don't provide date/time
	if (isset($article->pubDate))
	    $data['date'] = $this->parseDate($article->pubDate);
	if (isset($article->description))
	    $data['content'] = $this->parseContent($article->description);
	if (isset($article->guid))
	    $data['link'] = $article->guid;
	if (isset($article->link))
	    $data['link'] = $article->link;
	
	$data['original'] = json_encode($article);
	$data['type'] = $this->type;
	$data['source'] = ''; // TODO: pass in
	
//	echo print_r($data, true) . "\n";
	
	// TODO: return model rather than array
	return $data;
    }
    
    protected function parseContent($content)
    {
	if (is_string($content)) return $content;
//echo 'parseContent: ' . print_r($content, true) . "\n";
//	if ($content instanceof stdClass) {
//echo '$content found to be stdClass' . "\n";
//echo 'parseContent: ' . print_r($content, true) . "\n";
//	    return '';
//	}
//	return (string)$content;
	return '';
    }
    
    protected function parseDate($date)
    {
	$date = date_parse_from_format('D, j M Y H:i:s e', $date);
	return "{$date['year']}-{$date['month']}-{$date['day']} {$date['hour']}:{$date['minute']}:{$date['second']}";
    }
}
