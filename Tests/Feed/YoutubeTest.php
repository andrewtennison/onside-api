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
	    'Manchester City Football Club' => 'mcfcofficial',
	    'Liverpool Football Club' => 'LiverpoolFC',
	    'Sheffield Wednesday Football Club' => 'SwfcHighlights',
	    'Wayne Rooney' => 'ProductionsWazza',
	    'UK Cycling' => 'wwwcyclingtv',
	    'Badminton' => 'badmintonpassion',
	    'Golf' => 'playgolf'
	);
	$youtube = new Youtube();
	foreach ($users as $channel => $user) {
	    $youtube->addUser($user, $channel);
	}
//echo print_r($youtube, true) . "\n";
	$result = $youtube->getFeeds();
    }
}
