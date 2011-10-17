<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . '/../bootstrap.php';

$a = new Api\Api();
$res = $a->run();
$res->sendResponse();
