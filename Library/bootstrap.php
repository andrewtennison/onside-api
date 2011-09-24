<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', false);

// Constants
define('APPLICATION_BASE', __DIR__);

// Autoloading
set_include_path(APPLICATION_BASE . PATH_SEPARATOR . get_include_path());
