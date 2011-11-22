<?php
use \Onside\Autoloader;
use \Tests\DatabaseTest;
use \Tests\Test;

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../Scripts/tables.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Constants

// Autoloading
set_include_path(APPLICATION_BASE . '/Tests' . PATH_SEPARATOR . get_include_path());
set_include_path(APPLICATION_BASE . '/Tests/Api' . PATH_SEPARATOR . get_include_path());

// Reset database
use \Onside\Db;
$db = new Db('mysql:host=127.0.0.1;user=onside;pass=On2011Side;dbname=onside_unittest', 'onside', 'On2011Side');
$db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);

foreach ($tables as $table) {
    $class = '\Onside\Model\\' . ucfirst($table);
    $model = $class::getModelFromArray(array());
    $sql = $model->getDropSQL() . ";\n";
    $sql .= $model->getCreateSQL() . ";\n";
}

$db->exec($sql);

$sql = <<<SQL
INSERT INTO `channel` (`name`, `description`, `sport`, `type`, `level`) VALUES
    ('Manchester United', 'Everything about manchester united', 'football', 'club', 1) ;
SQL;
$db->exec($sql);

/**
echo '$sql: ' . $sql;
*/
