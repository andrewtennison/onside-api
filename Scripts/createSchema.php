<?php
include_once __DIR__ . '/../bootstrap.php';

$model = \Onside\Model\Article::getModelFromArray(array());
$sql = $model->getCreateSQL() . ";\n";
$model = \Onside\Model\Channel::getModelFromArray(array());
$sql .= $model->getCreateSQL() . ";\n";
$model = \Onside\Model\Discussion::getModelFromArray(array());
$sql .= $model->getCreateSQL() . ";\n";
$model = \Onside\Model\Event::getModelFromArray(array());
$sql .= $model->getCreateSQL() . ";\n";
$model = \Onside\Model\User::getModelFromArray(array());
$sql .= $model->getCreateSQL() . ";\n";
$model = \Onside\Model\Follower::getModelFromArray(array());
$sql .= $model->getCreateSQL() . ";\n";

$db->exec($sql);