<?php
include_once __DIR__ . '/../bootstrap.php';

$sql = '';
$all = count($argv) === 1;

if ($all || in_array('auth', $argv)) {
    $model = \Onside\Model\Auth::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('article', $argv)) {
    $model = \Onside\Model\Article::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('channel', $argv)) {
    $model = \Onside\Model\Channel::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('comment', $argv)) {
    $model = \Onside\Model\Comment::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('event', $argv)) {
    $model = \Onside\Model\Event::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('user', $argv)) {
    $model = \Onside\Model\User::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('follower', $argv)) {
    $model = \Onside\Model\Follower::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}
if ($all || in_array('logging', $argv)) {
    $model = \Onside\Model\Logging::getModelFromArray(array());
    $sql .= $model->getCreateSQL() . ";\n";
}

$db->exec($sql);