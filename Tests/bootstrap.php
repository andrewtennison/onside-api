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
