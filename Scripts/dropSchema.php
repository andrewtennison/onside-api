<?php
include_once __DIR__ . '/../bootstrap.php';

$mapper = new \Onside\Mapper\Article($db);
$model = \Onside\Model\Article::getModelFromArray(array());
$sql = $model->getDropSQL() . ";\n";
$mapper = new \Onside\Mapper\Channel($db);
$model = \Onside\Model\Channel::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$mapper = new \Onside\Mapper\Discussion($db);
$model = \Onside\Model\Discussion::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$mapper = new \Onside\Mapper\Event($db);
$model = \Onside\Model\Event::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$mapper = new \Onside\Mapper\User($db);
$model = \Onside\Model\User::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";

$db->exec($sql);