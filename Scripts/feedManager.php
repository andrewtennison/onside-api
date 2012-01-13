#!/usr/bin/php -q
<?php
include_once __DIR__ . '/../bootstrap.php';

// Check for lock file
$logger = new \Onside\Logger($commonConfig);
$lockfile = APPLICATION_BASE . "/{$queueConfig->lockfile}";
if (file_exists($lockfile)) {
    $logger->write('Feed manager: Lock file found exiting without processing anything', 'info');
    exit;
}

// Create lock file
touch($lockfile);
$logger->write('Feed manager: Lock file created starting feed fetching', 'info');

// For each process trigger new thread
$model = \Onside\Model\Source::getModelFromArray(array());
$model->setWhere('status', 'processed');
$model->setWhere('t.`lastfetched` + INTERVAL t.`frequency` SECOND ', date('Y-m-d H:i:s'), '<=');
$model->setLimit($queueConfig->maxchild);
$sql = $model->getSelectSQL();

$feeds = 0;
$rows = $db->prepared($sql)->fetchAll(\PDO::FETCH_CLASS, '\Onside\Model\Source');
foreach ($rows as $row) {
    $pid = pcntl_fork();
    if ($pid != -1) {
	if ($pid) {
	    $logger->write("Feed manager: Child spawned PID is $pid", 'info');
	    $feeds++;
	} else {
	    // Fire off with ID
	    $cmd = APPLICATION_BASE . '/Scripts/importFeed.php ' . $row->id;
	    exec($cmd);
	    exit;
	}
    } else {
	$logger->write('Feed manager: Fork failed!', 'info');
    }
}
$logger->write("Feed manager: $feeds feeds being fetched on this run", 'info');

// Remove lock file
if (file_exists($lockfile)) {
    unlink($lockfile);
    $logger->write('Feed manager: Lock file removed finished feed fetching', 'info');
}
$logger->write('Feed manager: Run completed existing', 'info');