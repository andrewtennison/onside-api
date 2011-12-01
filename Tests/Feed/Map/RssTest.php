<?php
namespace Tests\Feed\Map;
use \Tests\Test;

class RssTest extends Test
{
    public function provideRssTypes()
    {
	return array(
	    array(file_get_contents(__DIR__ . '/Rss/badminton.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/badmintonfreak.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/bbc.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/bwfbadminton.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/ecf.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/feedburner.json'), '\Onside\Feed\Map\Rss\Feedburner'),
	    array(file_get_contents(__DIR__ . '/Rss/footballblog.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/gazettelive.json'), '\Onside\Feed\Map\Rss\Gazettelive'),
	    array(file_get_contents(__DIR__ . '/Rss/golf.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/golf365.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/guardian.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/liverpoolfc.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/manutd.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/mcfc.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/orlandosentinel.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/pgatour.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/sheffieldtelegraph.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/skysports.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/teamtalk.json'), '\Onside\Feed\Map\Rss'),
	    array(file_get_contents(__DIR__ . '/Rss/theopen.json'), '\Onside\Feed\Map\Rss'),
	);
    }
    
    /**
     * @dataProvider provideRssTypes
     */
    public function testInitialisation($json, $class)
    {
	$map = new $class($json);
	$this->assertInstanceOf('\Onside\Feed\Map', $map);
	
	$result = $map->getArticles();
	$this->assertInternalType('array', $result);
	$this->assertGreaterThan(0, count($result), 'Count or result not greater than zero');
	foreach ($result as $article) {
	    $this->assertArrayHasKey('author', $article, 'Missing field: author');
	    $this->assertNotEmpty($article['author'], 'Empty required field: author');
	    
	    $this->assertArrayHasKey('title', $article, 'Missing field: title');
	    $this->assertNotEmpty($article['title'], 'Empty required field: title');
	    
	    $this->assertArrayHasKey('date', $article, 'Missing field: date');
	    $this->assertNotEmpty($article['date'], 'Empty required field: date');
	    
	    $this->assertArrayHasKey('content', $article, 'Missing field: content');
//	    $this->assertNotEmpty($article['content'], 'Empty required field: content');
	    $this->assertInternalType('string', $article['content'], 'Invalid data for field: content');
	    
	    $this->assertArrayHasKey('source', $article, 'Missing field: source');
//	    $this->assertNotEmpty($article['source'], 'Empty required field: source');
	    
	    $this->assertArrayHasKey('link', $article, 'Missing field: link');
	    $this->assertNotEmpty($article['link'], 'Empty required field: link');
	    
	    $this->assertArrayHasKey('original', $article, 'Missing field: original');
	    $this->assertNotEmpty($article['original'], 'Empty required field: original');
	}
//echo '$result: ' . print_r($result, true) . "\n";
    }
}

/**
 * 
 */