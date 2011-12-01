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
    
    public function testGetFeeds()
    {
	$feeds = array(
	    'Manchester City Football Club' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://www.mcfc.co.uk/Handlers/Rss.ashx',
		    'http://www.bluemoon-mcfc.co.uk/Blog/index.php/feed/',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/m/man_city/rss.xml',
		    'http://www.skysports.com/rss/0,,11679,00.xml',
		),
	    ),
	    'Liverpool Football Club' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://www.liverpoolfc.tv/rss/news/media-watch',
		    'http://www.liverpoolfc.tv/rss/news/latest',
		    'http://www.skysports.com/rss/0,,11669,00.xml',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/l/liverpool/rss.xml',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml',
		),
		'\Onside\Feed\Map\Rss\Feedburner' => array(
		    'http://feeds.feedburner.com/Kopblog', // Feedburner
		),
	    ),
	    'Sheffield Wednesday Football Club' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/s/sheff_wed/rss.xml',
		    'http://www.sheffieldtelegraph.co.uk/cmlink/1.1893300',
		    'http://www.skysports.com/rss/0,,11703,00.xml',
		    'http://sheffwed.footballblog.co.uk/feed',
		    'http://www.teamtalk.com/rss/1829',
		    'http://www.guardian.co.uk/football/sheffieldwednesday/rss',
		),
	    ),
	    'Wayne Rooney' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://www.manutd.com/en/Feeds/NewsAndFeaturesRSS.aspx',
		    'http://www.guardian.co.uk/football/wayne-rooney/rss',
		    'http://newsrss.bbc.co.uk/rss/sportonline_world_edition/football/teams/m/man_utd/rss.xml',
	//	    'http://rss.starpulse.com/rss/topic.news.rss.php?topic_path=Athletes/Rooney,_Wayne/&topic_name=Wayne+Rooney',
		),
		'\Onside\Feed\Map\Rss\Gazettelive' => array(
		    'http://www.gazettelive.co.uk/topics/wayne-rooney/rss.xml', // Gazettelive
		),
	    ),
	    'UK Cycling' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://www.guardian.co.uk/sport/tourdefrance/rss',
		    'http://www.skysports.com/rss/0,,15264,00.xml',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/cycling/rss.xml',
		    'http://www.guardian.co.uk/sport/olympics-2012-cycling/rss',
		    'http://www.ecf.com/feed/',
		    'http://feeds2.feedburner.com/cyclingnews/race/results',
		    'http://feeds2.feedburner.com/cyclingnews/news',
		),
	    ),
	    'Badminton' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://bwfbadminton.org/feed/news.aspx?id=4',
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/badminton/rss.xml',
		    'http://www.guardian.co.uk/sport/olympics-2012-badminton/rss',
		    'http://www.badmintonfreak.com/feed/',
		    'http://www.badminton.tv/files/rss/content.html',
		    'http://www.badminton.tv/files/rss/blogs.html',
		    'http://usabadminton.org/news/rss',
		),
	    ),
	    'Golf' => array(
		'\Onside\Feed\Map\Rss' => array(
		    'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/golf/rss.xml',
		    'http://www.skysports.com/rss/0,,12176,00.xml',
		    'http://www.golf365.com/rss/0,16039,9786,00.xml',
		    'http://www.golf.co.uk/rss.xml',
		    'http://www.theopen.com/en/Rss/Rss.aspx',
		    'http://www.pgatour.com/rss/feedburner/latest/r.rss',
		    'http://blogs.orlandosentinel.com/sports-golf/feed/',
		),
	    ),
	);
	$rss = new Rss();
	foreach ($feeds as $channel => $maps) {
	    foreach ($maps as $map => $urls) {
		foreach ($urls as $url) {
		    $rss->addRss($url, $channel, $map);
		}
	    }
	}
	$rss->getFeeds();
    }
}
