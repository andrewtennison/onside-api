<?php
use Onside\Config\Common;
use Onside\Config\Queue;
use Onside\Config\Sources;
use Onside\Db;
use Onside\Log;
use Onside\Queue;

include_once 'bootstrap.php';

declare(ticks = 1);

function sig_handler($signo)
{
    switch ($signo) {
        case SIGTERM:
            // handle shutdown tasks
            exit;
        break;
        case SIGHUP:
            // handle restart tasks
        break;
        default:
            // handle all other signals
    }
}

$pid = pcntl_fork();
if ($pid == -1) {
    die("could not fork");
} else if ($pid) {
    exit(); // we are the parent
} else {
    // we are the child
}

// detatch from the controlling terminal
if (posix_setsid() == -1) {
    die("could not detach from terminal");
}

$posid=posix_getpid();
$fp = fopen("/var/run/process.pid", "w");
fwrite($fp, $posid);
fclose($fp);

// setup signal handlers
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP, "sig_handler");

// Store required objects
$config_common = new Common(APPLICATION_ENV);
$config_queue = new Queue(APPLICATION_ENV);
$config_sources = new Sources(APPLICATION_ENV);
$db = new Db($config->db->dsn, $config->db->username, $config->db->passwd);
$db->init();
$log = new Log($config->log);

// loop forever performing tasks
while (1) {
    // check db
    
    // pull new source
    
    // process pulled source
}
