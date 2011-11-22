<?php
include_once __DIR__ . '/../bootstrap.php';
include_once __DIR__ . '/tables.php';

$sql = '';
$all = count($argv) === 1;

foreach ($tables as $table) {
    if ($all || in_array($table, $argv)) {
	$class = '\Onside\Model\\' . ucfirst($table);
	$model = $class::getModelFromArray(array());
	$sql .= $model->getDropSQL() . ";\n";
    }
}

$db->exec($sql);