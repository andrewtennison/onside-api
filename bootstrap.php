<?php
use \Onside\Autoloader;
use \Onside\Db;

// Error handling
function exceptionErrorHandler($errno, $errstr, $errfile, $errline) {
//function exceptionErrorHandler($message, $code = 500, $previous = null) {
    // error_reporting check is required to make @ operator work
    if (error_reporting()) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
//        throw new ErrorException($message, $code, $previous);
    }
}
set_error_handler('exceptionErrorHandler', E_ALL | E_STRICT);

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Constants
define('APPLICATION_BASE', __DIR__);
//define('APPLICATION_ENV', 'development');
defined('APPLICATION_ENV') or define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
define('APPLICATION_CONFIG', APPLICATION_BASE . '/Config');

// Autoloading
set_include_path(APPLICATION_BASE . PATH_SEPARATOR . get_include_path());

require_once APPLICATION_BASE . '/Onside/Autoloader.php';
spl_autoload_register(array(new Autoloader(), 'loader'), true);

// Load required config
$commonConfig = new \Onside\Config(APPLICATION_ENV, 'Common.ini');
$queueConfig = new \Onside\Config(APPLICATION_ENV, 'Queue.ini');
$sourcesConfig = new \Onside\Config\Common(APPLICATION_ENV, 'Sources.ini');

//die(print_r($commonConfig, true));
//echo '$commonConfig->db->default->dsn: ' . $commonConfig->db->default->dsn . "\n";
//echo '$commonConfig->db->default->username: ' . $commonConfig->db->default->username . "\n";
//echo '$commonConfig->db->default->passwd: ' . $commonConfig->db->default->passwd . "\n";
$db = new Db($commonConfig->db->default->dsn, $commonConfig->db->default->username, $commonConfig->db->default->passwd);
