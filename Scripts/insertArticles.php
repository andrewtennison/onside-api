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
	'@mcfc', '@Liam_Stirrup', '@mcfcblurbs', '@dan_mancity', '@OliverKayTimes', '@ManCity_FFC',

	'@LFCTV', '@JakeLFCTV', '@LFCTransferSpec', '@MicroLFC', '@AnfieldOpinion', '@anfieldonline',

	'@Owlstalk', '@wednesdayite', '@mark_hazell', '@KivoLee', '@Robert_swfc', '@OwlsAlive',

	'@WayneRooney', '@manchesterunews', '@UnitedsRedArmy', '@unitednights', '@GG_ManUtd', '@ViewFromTier3',

	'@MarkCavendish', '@taylorphinney', '@GregLemond', '@RobbieHunter', '@ChristianVDV', '@Mark_Renshaw',

	'@BADMNTONWorld', '@BADMlNTONEnglnd', '@bwfmedia', '@markphelanGPM', '@DeLoong',

	'@GolfTodayCoUk', '@Golf_Naked', '@RyanBallengeeGC', '@RandallMellGC', '@GolfweekWildMan', '@JeffShain',
    );
    $twitter = new \Onside\Feed\Twitter();
    foreach ($users as $user) {
	$twitter->addUser($user);
    }
    $twitter->getFeeds();
}

if ($all || in_array('youtube', $argv)) {
    $youtube = new \Onside\Feed\Youtube();
    $users = array(
	'mcfcofficial',
	'LiverpoolFC',
	'SwfcHighlights',
	'ProductionsWazza',
	'wwwcyclingtv',
	'badmintonpassion',
	'playgolf'
    );
    foreach ($users as $user) {
	$youtube->addUser($user);
    }
    $youtube->getFeeds();
}
