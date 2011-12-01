<?php
include_once __DIR__ . '/../bootstrap.php';

$all = count($argv) === 1;

if ($all || in_array('rss', $argv)) {
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
//		'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml',
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
    $rss = new \Onside\Feed\Rss();
    foreach ($feeds as $channel => $maps) {
	foreach ($maps as $map => $urls) {
	    foreach ($urls as $url) {
		$rss->addRss($url, $channel, $map);
	    }
	}
    }
    $rss->getFeeds();
//    $result = $rss->getFeed();
//    $rss->parseJson($result);
}

if ($all || in_array('twitter', $argv)) {
    $users = array(
	'Manchester City Football Club' => array('@mcfc', '@Liam_Stirrup', '@mcfcblurbs', '@dan_mancity', '@OliverKayTimes', '@ManCity_FFC',
	    ),
	    
	    'Liverpool Football Club' => array('@LFCTV', '@JakeLFCTV', '@LFCTransferSpec', '@MicroLFC', '@AnfieldOpinion', '@anfieldonline',
	    ),
	    
	    'Sheffield Wednesday Football Club' => array('@Owlstalk', '@wednesdayite', '@mark_hazell', '@KivoLee', '@Robert_swfc', '@OwlsAlive',
	    ),
	    
	    'Wayne Rooney' => array('@WayneRooney', '@manchesterunews', '@UnitedsRedArmy', '@unitednights', '@GG_ManUtd', '@ViewFromTier3'),
	    
	    'UK Cycling' => array('@MarkCavendish', '@taylorphinney', '@GregLemond', '@RobbieHunter', '@ChristianVDV', '@Mark_Renshaw'),
	    
	    'Badminton' => array('@BADMNTONWorld', '@BADMlNTONEnglnd', '@bwfmedia', '@markphelanGPM', '@DeLoong'),
	    
	    'Golf' => array('@GolfTodayCoUk', '@Golf_Naked', '@RyanBallengeeGC', '@RandallMellGC', '@GolfweekWildMan', '@JeffShain'),
    );
    $twitter = new \Onside\Feed\Twitter();
    foreach ($users as $channel => $userlist) {
	foreach ($userlist as $user) {
	    $twitter->addUser($user, $channel);
	}
    }
    $twitter->getFeeds();
}

if ($all || in_array('youtube', $argv)) {
    $youtube = new \Onside\Feed\Youtube();
    $users = array(
	    'Manchester City Football Club' => 'mcfcofficial',
	    'Liverpool Football Club' => 'LiverpoolFC',
	    'Sheffield Wednesday Football Club' => 'SwfcHighlights',
	    'Wayne Rooney' => 'ProductionsWazza',
	    'UK Cycling' => 'wwwcyclingtv',
	    'Badminton' => 'badmintonpassion',
	    'Golf' => 'playgolf'
    );
    foreach ($users as $channel => $user) {
	$youtube->addUser($user, $channel);
    }
    $youtube->getFeeds();
}
