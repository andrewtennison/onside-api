<?php
namespace Onside\Log;
use \Onside\Log;
use \Onside\Config;

class Db implements Log
{
    protected $db;
    protected $config;
    
    public function __construct(Config $config)
    {
	$this->config = $config;
    }
    
    public function write($message)
    {
        if (is_null($this->db)) $this->connect();
        $stmt = $this->db->prepared('INSERT INTO `logs` (message) VALUES(?)', array($message));
	return ($stmt === false) ? false : true;
    }
    
    private function connect()
    {
        $this->db = new \Onside\Db($this->config->log->db->dsn, $this->config->log->db->username, $this->config->log->db->passwd);
	$this->db->setAttribute(\Onside\Db::ATTR_ERRMODE, \Onside\Db::ERRMODE_EXCEPTION);
	$this->db->exec('use ' . $this->config->log->db->dbname);
    }
}
