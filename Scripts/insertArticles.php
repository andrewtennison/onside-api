<?php
include_once __DIR__ . '/../bootstrap.php';

$all = count($argv) === 1;

if ($all || in_array('rss', $argv)) {
    $rss = new \Onside\Feed\Rss();
    $result = $rss->getFeed();
    $rss->parseJson($result);
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
