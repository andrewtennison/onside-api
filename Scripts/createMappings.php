<?php
include_once __DIR__ . '/../bootstrap.php';

$feeds = array(
    1 => array(
	'http://www.mcfc.co.uk/Handlers/Rss.ashx',
	'http://www.bluemoon-mcfc.co.uk/Blog/index.php/feed/',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/m/man_city/rss.xml',
	'http://www.skysports.com/rss/0,,11679,00.xml',
    ),
    2 => array(
	'http://www.liverpoolfc.tv/rss/news/media-watch',
	'http://www.liverpoolfc.tv/rss/news/latest',
	'http://www.skysports.com/rss/0,,11669,00.xml',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/l/liverpool/rss.xml',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml',
//	'http://feeds.feedburner.com/Kopblog', // Feedburner
    ),
    3 => array(
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/s/sheff_wed/rss.xml',
	'http://www.sheffieldtelegraph.co.uk/cmlink/1.1893300',
	'http://www.skysports.com/rss/0,,11703,00.xml',
	'http://sheffwed.footballblog.co.uk/feed',
	'http://www.teamtalk.com/rss/1829',
	'http://www.guardian.co.uk/football/sheffieldwednesday/rss',
    ),
    4 => array(
	'http://www.manutd.com/en/Feeds/NewsAndFeaturesRSS.aspx',
	'http://www.guardian.co.uk/football/wayne-rooney/rss',
	'http://newsrss.bbc.co.uk/rss/sportonline_world_edition/football/teams/m/man_utd/rss.xml',
	'http://rss.starpulse.com/rss/topic.news.rss.php?topic_path=Athletes/Rooney,_Wayne/&topic_name=Wayne+Rooney',
//	'http://www.gazettelive.co.uk/topics/wayne-rooney/rss.xml', // Gazettelive
    ),
    5 => array(
	'http://www.guardian.co.uk/sport/tourdefrance/rss',
	'http://www.skysports.com/rss/0,,15264,00.xml',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/cycling/rss.xml',
	'http://www.guardian.co.uk/sport/olympics-2012-cycling/rss',
	'http://www.ecf.com/feed/',
	'http://feeds2.feedburner.com/cyclingnews/race/results',
	'http://feeds2.feedburner.com/cyclingnews/news',
    ),
    6 => array(
	'http://bwfbadminton.org/feed/news.aspx?id=4',
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/badminton/rss.xml',
	'http://www.guardian.co.uk/sport/olympics-2012-badminton/rss',
	'http://www.badmintonfreak.com/feed/',
	'http://www.badminton.tv/files/rss/content.html',
	'http://www.badminton.tv/files/rss/blogs.html',
	'http://usabadminton.org/news/rss',
    ),
    7 => array(
	'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/golf/rss.xml',
	'http://www.skysports.com/rss/0,,12176,00.xml',
	'http://www.golf365.com/rss/0,16039,9786,00.xml',
	'http://www.golf.co.uk/rss.xml',
	'http://www.theopen.com/en/Rss/Rss.aspx',
	'http://www.pgatour.com/rss/feedburner/latest/r.rss',
	'http://blogs.orlandosentinel.com/sports-golf/feed/',
    ),
);
$cmd = '/usr/bin/curl -d "frequency=86400&map_type=->type&map_article=->channel->item&map_title=->title&map_content=->description&map_images=&map_videos=&map_author=&map_source=&map_link=->guid|->link&map_extended=&map_publish=->pubDate&map_keywords=&channels=|channels|&url=|url|" http://onside.localhost/source';

foreach ($feeds as $channel => $urls) {
    foreach ($urls as $url) {
	$uri = $cmd;
	$uri = str_replace('|channels|', $channel, $uri);
	$uri = str_replace('|url|', $url, $uri);
//	echo "$uri\n";
	exec($uri);
    }
}