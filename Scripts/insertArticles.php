<?php
include_once __DIR__ . '/../bootstrap.php';

$all = count($argv) === 1;

if ($all || in_array('rss', $argv)) {
    $rss = new \Onside\Feed\Rss();
    $result = $rss->getFeed();
    $rss->parseJson($result);
}

if ($all || in_array('twitter', $argv)) {
    $twitter = new \Onside\Feed\Twitter();
    $result = $twitter->getFeed();
    $twitter->parseJson($result);
}

if ($all || in_array('youtube', $argv)) {
    $youtube = new \Onside\Feed\Youtube();
    $result = $youtube->getFeed();
    $youtube->parseJson($result);
}
