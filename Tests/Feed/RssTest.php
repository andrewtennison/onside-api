<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Rss;

class RssTest extends Test
{
    public function testInitialisation()
    {
	$rss = new Rss();
	$this->assertInstanceOf('\Onside\Feed', $rss);
	$result = $rss->getFeed();
	$rss->parseJson($result);
//echo print_r($result, true) . "\n";
    }
    
    public function testFormat()
    {
	$rss = new Rss();
	$this->assertTrue($rss->isXmlFormat());
	$this->assertFalse($rss->isJsonFormat());
    }
}
