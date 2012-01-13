<?php
use \Onside\Autoloader;
use \Tests\DatabaseTest;
use \Tests\Test;

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../Scripts/tables.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Constants

// Autoloading
set_include_path(APPLICATION_BASE . '/Tests' . PATH_SEPARATOR . get_include_path());
set_include_path(APPLICATION_BASE . '/Tests/Api' . PATH_SEPARATOR . get_include_path());

// Reset database
use \Onside\Db;
$db = new Db('mysql:host=127.0.0.1;user=onside;pass=On2011Side;dbname=onside_unittest', 'onside', 'On2011Side');
$db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);

$sql = '';
foreach ($tables as $table) {
    $class = '\Onside\Model\\' . ucfirst($table);
    $model = $class::getModelFromArray(array());
    $sql .= $model->getDropSQL() . ";\n";
    $sql .= $model->getCreateSQL() . ";\n";
}

$db->exec($sql);

$sql = <<<SQL
INSERT INTO `channel` (`name`, `description`, `sport`, `type`, `level`) VALUES
    ('Manchester United', 'Everything about manchester united', 'football', 'club', 1) ;

INSERT INTO `source` (`id`, `status`, `lastfetched`, `url`, `channels`, `frequency`, `map_type`, `map_article`, `map_title`, `map_content`, `map_images`, `map_videos`, `map_author`, `map_source`, `map_link`, `map_extended`, `map_publish`, `map_keywords`) VALUES
(1, 'running', '2011-12-20 18:17:22', 'http://www.mcfc.co.uk/Handlers/Rss.ashx', '1', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(2, 'processed', '2011-12-20 18:17:22', 'http://www.bluemoon-mcfc.co.uk/Blog/index.php/feed/', '1', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(3, 'processed', '2011-12-20 18:17:22', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml', '1', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(4, 'processed', '2011-12-20 18:17:22', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/m/man_city/rss.xml', '1', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(5, 'processed', '2011-12-20 18:17:22', 'http://www.skysports.com/rss/0,,11679,00.xml', '1', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(6, 'processed', '2011-12-20 18:17:23', 'http://www.liverpoolfc.tv/rss/news/media-watch', '2', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(7, 'processed', '2011-12-20 18:17:23', 'http://www.liverpoolfc.tv/rss/news/latest', '2', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(8, 'processed', '2011-12-20 18:17:23', 'http://www.skysports.com/rss/0,,11669,00.xml', '2', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(9, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/l/liverpool/rss.xml', '2', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(10, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/eng_prem/rss.xml', '2', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(11, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/football/teams/s/sheff_wed/rss.xml', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(12, 'processed', '2011-12-20 18:17:23', 'http://www.sheffieldtelegraph.co.uk/cmlink/1.1893300', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(13, 'processed', '2011-12-20 18:17:23', 'http://www.skysports.com/rss/0,,11703,00.xml', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(14, 'processed', '2011-12-20 18:17:23', 'http://sheffwed.footballblog.co.uk/feed', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(15, 'processed', '2011-12-20 18:17:23', 'http://www.teamtalk.com/rss/1829', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(16, 'processed', '2011-12-20 18:17:23', 'http://www.guardian.co.uk/football/sheffieldwednesday/rss', '3', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(17, 'processed', '2011-12-20 18:17:23', 'http://www.manutd.com/en/Feeds/NewsAndFeaturesRSS.aspx', '4', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(18, 'processed', '2011-12-20 18:17:23', 'http://www.guardian.co.uk/football/wayne-rooney/rss', '4', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(19, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_world_edition/football/teams/m/man_utd/rss.xml', '4', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(20, 'processed', '2011-12-20 18:17:23', 'http://rss.starpulse.com/rss/topic.news.rss.php?topic_path=Athletes/Rooney,_Wayne/', '4', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(21, 'processed', '2011-12-20 18:17:23', 'http://www.guardian.co.uk/sport/tourdefrance/rss', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(22, 'processed', '2011-12-20 18:17:23', 'http://www.skysports.com/rss/0,,15264,00.xml', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(23, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/cycling/rss.xml', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(24, 'processed', '2011-12-20 18:17:23', 'http://www.guardian.co.uk/sport/olympics-2012-cycling/rss', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(25, 'processed', '2011-12-20 18:17:23', 'http://www.ecf.com/feed/', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(26, 'processed', '2011-12-20 18:17:23', 'http://feeds2.feedburner.com/cyclingnews/race/results', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(27, 'processed', '2011-12-20 18:17:23', 'http://feeds2.feedburner.com/cyclingnews/news', '5', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(28, 'processed', '2011-12-20 18:17:23', 'http://bwfbadminton.org/feed/news.aspx?id=4', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(29, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/other_sports/badminton/rss.xml', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(30, 'processed', '2011-12-20 18:17:23', 'http://www.guardian.co.uk/sport/olympics-2012-badminton/rss', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(31, 'processed', '2011-12-20 18:17:23', 'http://www.badmintonfreak.com/feed/', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(32, 'processed', '2011-12-20 18:17:23', 'http://www.badminton.tv/files/rss/content.html', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(33, 'processed', '2011-12-20 18:17:23', 'http://www.badminton.tv/files/rss/blogs.html', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(34, 'processed', '2011-12-20 18:17:23', 'http://usabadminton.org/news/rss', '6', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(35, 'processed', '2011-12-20 18:17:23', 'http://newsrss.bbc.co.uk/rss/sportonline_uk_edition/golf/rss.xml', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(36, 'processed', '2011-12-20 18:17:23', 'http://www.skysports.com/rss/0,,12176,00.xml', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(37, 'processed', '2011-12-20 18:17:23', 'http://www.golf365.com/rss/0,16039,9786,00.xml', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(38, 'processed', '2011-12-20 18:17:23', 'http://www.golf.co.uk/rss.xml', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(39, 'processed', '2011-12-20 18:17:23', 'http://www.theopen.com/en/Rss/Rss.aspx', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(40, 'processed', '2011-12-20 18:17:23', 'http://www.pgatour.com/rss/feedburner/latest/r.rss', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', ''),
(41, 'processed', '2011-12-20 18:17:23', 'http://blogs.orlandosentinel.com/sports-golf/feed/', '7', '86400', '->type', '->channel->item', '->title', '->description', '', '', '', '', '->guid|->link', '', '->pubDate', '');

SQL;
$db->exec($sql);

/**
echo '$sql: ' . $sql;
*/
