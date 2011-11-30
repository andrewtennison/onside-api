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
    
    public function testGetFeeds()
    {
	$users = array(
	    'Manchester City Football Club' => array(
		'@mcfc',
		'@Liam_Stirrup',
		'@mcfcblurbs',
		'@dan_mancity',
		'@OliverKayTimes',
		'@ManCity_FFC',
	    ),
	    
	    'Liverpool Football Club' => array(
		'@LFCTV',
		'@JakeLFCTV',
		'@LFCTransferSpec',
		'@MicroLFC',
		'@AnfieldOpinion',
		'@anfieldonline',
	    ),
	    
	    'Sheffield Wednesday Football Club' => array(
		'@Owlstalk',
		'@wednesdayite',
		'@mark_hazell',
		'@KivoLee',
		'@Robert_swfc',
		'@OwlsAlive',
	    ),
	    
	    'Wayne Rooney' => array(
		'@WayneRooney',
		'@manchesterunews',
		'@UnitedsRedArmy',
		'@unitednights',
		'@GG_ManUtd',
		'@ViewFromTier3',
	    ),
	    
	    'UK Cycling' => array(
		'@MarkCavendish',
		'@taylorphinney',
		'@GregLemond',
		'@RobbieHunter',
		'@ChristianVDV',
		'@Mark_Renshaw',
	    ),
	    
	    'Badminton' => array(
		'@BADMNTONWorld',
		'@BADMlNTONEnglnd',
		'@bwfmedia',
		'@markphelanGPM',
		'@DeLoong',
	    ),
	    
	    'Golf' => array(
		'@GolfTodayCoUk',
		'@Golf_Naked',
		'@RyanBallengeeGC',
		'@RandallMellGC',
		'@GolfweekWildMan',
		'@JeffShain',
	    ),
	);
	$twitter = new Twitter();
	foreach ($users as $channel => $userlist) {
	    foreach ($userlist as $user) {
		$twitter->addUser($user, $channel);
	    }
	}
//echo print_r($twitter, true) . "\n";
	$result = $twitter->getFeeds();
    }
}
