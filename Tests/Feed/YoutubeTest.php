<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Youtube;

class YoutubeTest extends Test
{
    public function testInitialisation()
    {$this->markTestSkipped();
	$youtube = new Youtube();
	$this->assertInstanceOf('\Onside\Feed', $youtube);
	$result = $youtube->getFeed();
	$youtube->parseJson($result);
//echo print_r($result, true) . "\n";
    }
    
    public function testFormat()
    {$this->markTestSkipped();
	$youtube = new Youtube();
	$this->assertTrue($youtube->isXmlFormat());
	$this->assertFalse($youtube->isJsonFormat());
    }
    
    public function testGetFeeds()
    {
	$users = array(
	    'mcfcofficial',
	    'LiverpoolFC',
	    'SwfcHighlights',
	    'ProductionsWazza',
	    'wwwcyclingtv',
	    'badmintonpassion',
	    'playgolf'
	);
	$youtube = new Youtube();
	foreach ($users as $user) {
	    $youtube->addUser($user);
	}
//echo print_r($youtube, true) . "\n";
	$result = $youtube->getFeeds();
    }
}
