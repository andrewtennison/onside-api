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
if (count($row) == 0) {
    $logger->write("Import feed: $id no mapping source found, exiting", 'info');
    exit;
}
$row = $row[0];
$model = \Onside\Model\Source::getModelFromArray($row);
$model->status = 'running';
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Start fetching and updated feed to running", 'info');
}

// Check if it has basic mapping - sanity check
$error = '';
$fields = array('map_article', 'map_type', 'map_title', 'map_link', 'map_publish');
foreach ($fields as $field) {
    if (empty($row->$field) || is_null($row->$field)) {
	$error .= "required field '$field' is empty\n";
    }
}
if ($error !== '') {
    $logger->write("Problem with mapping source: $id will be flagged as 'failed'", 'warn');
    $model->status = 'failed';
    $model->id = $id;
    $model->failed_reason = $error;
    $sql = $model->getUpdateSQL();
    $args = $model->getValues();
    $result = $db->prepared($sql, $args);
    exit;
}

// Process the feed
//echo print_r($row, true) . "\n";
$source = new \Onside\Feed\Source($row);
$articles = $source->getArticles();
//echo print_r($articles, true) . "\n";

/**
if (count($articles) == 0) {
    $logger->write("No articles found from mapping source: $id will be flagged as 'failed'", 'warn');
    $model->status = 'failed';
    $model->id = $id;
    $model->failed_reason = 'unknown error';
    $sql = $model->getUpdateSQL();
    $args = $model->getValues();
    $result = $db->prepared($sql, $args);
    exit;
}
*/

// TODO: dedupe across sources only inserting if its unique
$inserted = 0;
foreach ($articles as $article) {
    $failed_reason = '';
    if (!$article->isValid()) {
	$failed_reason = $article->isValid(true);
    }
    $article1 = \Onside\Model\Article::getModelFromArray(array());
    $article1->setWhere('title', $article->title);
    $article1->setWhere('source', $article->source);
    if (!empty($article->publish))
        $article1->setWhere('publish', $article->publish);
//echo print_r($article, true) . "\n\n";
    $sql = $article1->getSelectSQL();
    $args = $article1->getValues();
//echo "$sql\n\n" . print_r($args, true) . "\n";
    try {
	$rows = $db->prepared($sql, $args)->fetchAll();
        if (count($rows) == 0) {
            $sql = $article->getInsertSQL();
            $args = $article->getValues();
            //echo "$sql\n\n" . print_r($args, true) . "\n";
            $result = $db->prepared($sql, $args);
            if (!$result) {
                // (incorrect fields)ID=12(title)/15(title)/38(title)/39(???)/40(title) (fatal)ID=20
                $logger->write("Problem inserting new article, source: $id will be flagged as 'failed'", 'warn');
                $model->status = 'failed';
                $model->id = $id;
                $model->failed_reason = $failed_reason;
                $sql = $model->getUpdateSQL();
                $args = $model->getValues();
                $result = $db->prepared($sql, $args);
                // Stop all processing and exit
                continue(1);
            }

            // Associate article with channel(s)
            $channels = strpos($row->channels, ',') === false ? array($row->channels) : explode(',', $row->channels);
            foreach ($channels as $c) {
                $carticle = \Onside\Model\Carticle::getModelFromArray(array('article' => $result, 'channel' => $c));
                $carticle = $db->prepared($carticle->getInsertSQL(), $carticle->getValues());
            }
            $inserted++;
        }
    } catch (Exception $e) {
	$logger->write($e->getMessage() . "\n",'error');
        $logger->write($e->getTraceAsString() . "\n",'error');
    }

}
$logger->write("Import feed $id: Imported $inserted / " . count($articles) . " articles from feed", 'info');

// Set lastfetched and status to processed
$model->id = $id;
$model->status = 'processed';
$model->lastfetched = date('Y-m-d H:i:s');
$model->failed_reason = null;
$sql = $model->getUpdateSQL();
$args = $model->getValues();
$result = $db->prepared($sql, $args);
if ($result) {
    $logger->write("Import feed $id: Finished fetching and updated feed to processed", 'info');
}
