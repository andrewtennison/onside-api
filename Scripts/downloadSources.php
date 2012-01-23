<?php
include_once __DIR__ . '/../bootstrap.php';

$model = \Onside\Model\Source::getModelFromArray(array());
$rows = $db->prepared($model->getSelectSQL())->fetchAll(\PDO::FETCH_CLASS, '\Onside\Model\Source');
foreach ($rows as $row) {
    $curl = curl_init($row->url);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $feed = curl_exec($curl);
    
    file_put_contents(__DIR__ . '/../tmp/' . $row->id . '.feed', $feed);
}