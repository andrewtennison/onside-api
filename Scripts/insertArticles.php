<?php
include_once __DIR__ . '/../bootstrap.php';

$rss = new \Onside\Feed\Rss();
$result = $rss->getFeed();
$rss->parseJson($result);

$twitter = new \Onside\Feed\Twitter();
$result = $twitter->getFeed();
$twitter->parseJson($result);

$youtube = new \Onside\Feed\Youtube();
$result = $youtube->getFeed();
$youtube->parseJson($result);
