<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Youtube;

class YoutubeTest extends Test
{
    public function testInitialisation()
    {
	$youtube = new Youtube();
	$this->assertInstanceOf('\Onside\Feed', $youtube);
	$result = $youtube->getFeed();
	$youtube->parseJson($result);
//echo print_r($result, true) . "\n";
    }
    
    public function testFormat()
    {
	$youtube = new Youtube();
	$this->assertTrue($youtube->isXmlFormat());
	$this->assertFalse($youtube->isJsonFormat());
    }
}
