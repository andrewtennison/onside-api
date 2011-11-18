<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Twitter;

class TwitterTest extends Test
{
    public function testInitialisation()
    {
	$twitter = new Twitter();
	$this->assertInstanceOf('\Onside\Feed', $twitter);
	$result = $twitter->getFeed();
	$twitter->parseJson($result);
//echo print_r($result, true) . "\n";
    }
    
    public function testFormat()
    {
	$twitter = new Twitter();
	$this->assertFalse($twitter->isXmlFormat());
	$this->assertTrue($twitter->isJsonFormat());
    }
}
