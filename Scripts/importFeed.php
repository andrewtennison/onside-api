#!/usr/bin/php -q
<?php
include_once __DIR__ . '/../bootstrap.php';

// Make sure the source is passed in
$logger = new \Onside\Log\File($commonConfig);
if (count($argv) != 2 || !is_numeric($argv[1])) {
    $logger->write('Import feed: Missing / invalid ID');
    exit;
}
$id = $argv[1];
$logger->write("Import feed: ID passed in $id");

// Set status to running
$model = \Onside\Model\Source::getModelFromArray(array('id' => $id));
$row = $db->prepared($model->getSelectSQL())->fetchAll();
$model->status = 'running';
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Start fetching and updated feed to running");
}

// Process the feed

// TODO: dedupe across sources only inserting if its unique
sleep(120);

// Set lastfetched and status to processed
$model->status = 'processed';
//$model->lastfetched = date('Y-m-d H:i:s');
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Finished fetching and updated feed to processed");
}
