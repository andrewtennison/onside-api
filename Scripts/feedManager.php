#!/usr/bin/php -q
<?php
include_once __DIR__ . '/../bootstrap.php';

// Check for lock file
$logger = new \Onside\Log\File($commonConfig);
$lockfile = APPLICATION_BASE . "/{$queueConfig->lockfile}";
if (file_exists($lockfile)) {
    $logger->write('Feed manager: Lock file found exiting without processing anything');
    exit;
}

// Create lock file
touch($lockfile);
$logger->write('Feed manager: Lock file created starting feed fetching');

// For each process trigger new thread
$model = \Onside\Model\Source::getModelFromArray(array());
$model->setWhere('status', 'processed');
$model->setWhere('t.`lastfetched` + INTERVAL t.`frequency` SECOND ', date('Y-m-d H:i:s'), '<=');
$model->setLimit($queueConfig->maxchild);
$sql = $model->getSelectSQL();

$feeds = 0;
$rows = $db->prepared($sql)->fetchAll();
foreach ($rows as $row) {
    $pid = pcntl_fork();
    if ($pid != -1) {
	if ($pid) {
	    $logger->write("Feed manager: Child spawned PID is $pid");
	    $feeds++;
	} else {
	    // Fire off with ID
	    $cmd = APPLICATION_BASE . '/Scripts/importFeed.php ' . $row['id'];
	    exec($cmd);
	    exit;
	}
    } else {
	$logger->write('Feed manager: Fork failed!');
    }
}
$logger->write("Feed manager: $feeds number of feeds being fetched");

// Remove lock file
if (file_exists($lockfile)) {
    unlink($lockfile);
    $logger->write('Feed manager: Lock file removed finished feed fetching');
}
$logger->write('Feed manager: Run completed existing');