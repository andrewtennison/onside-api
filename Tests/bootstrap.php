<?php
use \Onside\Autoloader;
use \Tests\DatabaseTest;
use \Tests\Test;

require_once __DIR__ . '/../bootstrap.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Constants

// Autoloading
set_include_path(APPLICATION_BASE . '/Tests' . PATH_SEPARATOR . get_include_path());
set_include_path(APPLICATION_BASE . '/Tests/Api' . PATH_SEPARATOR . get_include_path());

// Reset database
/**
use \Onside\Db;
$db = new Db('mysql:host=127.0.0.1;user=onside;pass=On2011Side;dbname=onside_unittest', 'onside', 'On2011Side');
$db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);

$mapper = new \Onside\Mapper\Article($db);
$model = \Onside\Model\Article::getModelFromArray(array());
$sql = $model->getDropSQL() . ";\n";
$sql .= $model->getCreateSQL() . ";\n";
$mapper = new \Onside\Mapper\Channel($db);
$model = \Onside\Model\Channel::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$sql .= $model->getCreateSQL() . ";\n";
$mapper = new \Onside\Mapper\Discussion($db);
$model = \Onside\Model\Discussion::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$sql .= $model->getCreateSQL() . ";\n";
$mapper = new \Onside\Mapper\Event($db);
$model = \Onside\Model\Event::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$sql .= $model->getCreateSQL() . ";\n";
$mapper = new \Onside\Mapper\User($db);
$model = \Onside\Model\User::getModelFromArray(array());
$sql .= $model->getDropSQL() . ";\n";
$sql .= $model->getCreateSQL() . ";\n";

echo '$sql: ' . $sql;
*/
