#!/usr/bin/php -q
<?php
include_once __DIR__ . '/../bootstrap.php';

// Make sure the source is passed in
$logger = new \Onside\Logger($commonConfig);
if (count($argv) != 2 || !is_numeric($argv[1])) {
    $logger->write('Import feed: Missing / invalid ID', 'info');
    exit;
}
$id = $argv[1];
$logger->write("Import feed: ID passed in $id", 'info');

// Set status to running
$model = \Onside\Model\Source::getModelFromArray(array());
$model->setWhere('id', $id);
$row = $db->prepared($model->getSelectSQL())->fetchAll(\PDO::FETCH_CLASS, '\Onside\Model\Source');
$row = $row[0];
$model->status = 'running';
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Start fetching and updated feed to running", 'info');
}

// Process the feed
echo print_r($row, true) . "\n";

// TODO: dedupe across sources only inserting if its unique
sleep(120);

// Set lastfetched and status to processed
$model->status = 'processed';
//$model->lastfetched = date('Y-m-d H:i:s');
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Finished fetching and updated feed to processed", 'info');
}
