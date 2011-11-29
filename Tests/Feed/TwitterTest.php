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
	    '@mcfc',
	    '@Liam_Stirrup',
	    '@mcfcblurbs',
	    '@dan_mancity',
	    '@OliverKayTimes',
	    '@ManCity_FFC',
	    
	    '@LFCTV',
	    '@JakeLFCTV',
	    '@LFCTransferSpec',
	    '@MicroLFC',
	    '@AnfieldOpinion',
	    '@anfieldonline',
	    
	    '@Owlstalk',
	    '@wednesdayite',
	    '@mark_hazell',
	    '@KivoLee',
	    '@Robert_swfc',
	    '@OwlsAlive',
	    
	    '@WayneRooney',
	    '@manchesterunews',
	    '@UnitedsRedArmy',
	    '@unitednights',
	    '@GG_ManUtd',
	    '@ViewFromTier3',
	    
	    '@MarkCavendish',
	    '@taylorphinney',
	    '@GregLemond',
	    '@RobbieHunter',
	    '@ChristianVDV',
	    '@Mark_Renshaw',
	    
	    '@BADMNTONWorld',
	    '@BADMlNTONEnglnd',
	    '@bwfmedia',
	    '@markphelanGPM',
	    '@DeLoong',
	    
	    '@GolfTodayCoUk',
	    '@Golf_Naked',
	    '@RyanBallengeeGC',
	    '@RandallMellGC',
	    '@GolfweekWildMan',
	    '@JeffShain',
	);
	$twitter = new Twitter();
	foreach ($users as $user) {
	    $twitter->addUser($user);
	}
//echo print_r($twitter, true) . "\n";
	$result = $twitter->getFeeds();
    }
}
