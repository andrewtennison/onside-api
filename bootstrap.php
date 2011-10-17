<?php
use \Onside\Autoloader;

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', false);

// Constants
define('APPLICATION_BASE', __DIR__);
defined('APPLICATION_ENV') or define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
define('APPLICATION_CONFIG', APPLICATION_BASE . '/Config');

// Autoloading
set_include_path(APPLICATION_BASE . PATH_SEPARATOR . get_include_path());

require_once APPLICATION_BASE . '/Onside/Autoloader.php';
spl_autoload_register(array(new Autoloader(), 'loader'), true);
