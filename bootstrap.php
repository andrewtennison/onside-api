<?php
use \Onside\Autoloader;
use \Onside\Db;

error_reporting(E_ALL & E_STRICT);
ini_set('display_errors', false);

// Constants
define('APPLICATION_BASE', __DIR__);
define('APPLICATION_ENV', 'development');
//defined('APPLICATION_ENV') or define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
define('APPLICATION_CONFIG', APPLICATION_BASE . '/Config');

/**
 * Application-wise error handler
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline)
{
    // error_reporting check is required to make @ operator work
    if (error_reporting()) {
echo "ERROR: $errno $errfile $errno $errline\n";
die();
//        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}

// Autoloading
set_include_path(APPLICATION_BASE . PATH_SEPARATOR . get_include_path());

require_once APPLICATION_BASE . '/Onside/Autoloader.php';
spl_autoload_register(array(new Autoloader(), 'loader'), true);

// Load required config
$commonConfig = new \Onside\Config(APPLICATION_ENV, 'Common.ini');
$sourcesConfig = new \Onside\Config\Common(APPLICATION_ENV, 'Sources.ini');

//die(print_r($commonConfig, true));
//echo '$commonConfig->db->default->dsn: ' . $commonConfig->db->default->dsn . "\n";
//echo '$commonConfig->db->default->username: ' . $commonConfig->db->default->username . "\n";
//echo '$commonConfig->db->default->passwd: ' . $commonConfig->db->default->passwd . "\n";
$db = new Db($commonConfig->db->default->dsn, $commonConfig->db->default->username, $commonConfig->db->default->passwd);
