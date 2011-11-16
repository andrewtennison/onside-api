<?php
include_once __DIR__ . '/../bootstrap.php';

$model = \Onside\Model\Article::getModelFromArray(array());
$sql = $model->getDropSQL() . ";\n";
$model = \Onside\Model\Channel::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$model = \Onside\Model\Comment::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$model = \Onside\Model\Event::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$model = \Onside\Model\User::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$model = \Onside\Model\Follower::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";

$db->exec($sql);