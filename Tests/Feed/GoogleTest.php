<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Google;

class GoogleTest extends Test
{
    public function testInitialisation()
    {
	$google = new Google();
	$this->assertInstanceOf('\Onside\Feed', $google);
	$result = $google->getFeed();
//	$google->parseJson($result);
echo print_r($result, true) . "\n";
    }
}
