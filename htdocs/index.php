<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

try {

    header('HTTP/1.1 500 fatal error');
    header('Content-Type:text/plain;charset=UTF-8');
    header('X-Content-Type-Options:nosniff');

    require_once __DIR__ . '/../bootstrap.php';

    $a = new \Api\Api();
    $res = $a->run();
    $res->sendResponse();

} catch (Exception $e) {
    if (!headers_sent()) {
        header("HTTP/1.1 500 error");
        header('Content-Type:application/javascript;charset=UTF-8');
    }
    echo json_encode(array('Code' => $e->getCode(), 'Message' => 'something bad has happened', 'Trace' => $e->getTraceAsString()));
    exit(1);
}