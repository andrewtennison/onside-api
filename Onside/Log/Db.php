<?php
namespace Onside\Log;
use \Onside\Log;
use \Onside\Config;

class Db implements Log
{
    protected $db;
    protected $config;
    protected $level;
    
    public function __construct(Config $config)
    {
	$this->config = $config;
	$this->level = 'error';
    }
    
    public function write($message, $level = null)
    {
        if (is_null($this->db)) $this->connect();
	if ($level == null) $level = $this->level;
        $stmt = $this->db->prepared('INSERT INTO `logs` (message, level) VALUES(?,?)', array($message, $level));
	return ($stmt === false) ? false : true;
    }
    
    private function connect()
    {
        $this->db = new \Onside\Db($this->config->log->db->dsn, $this->config->log->db->username, $this->config->log->db->passwd);
	$this->db->setAttribute(\Onside\Db::ATTR_ERRMODE, \Onside\Db::ERRMODE_EXCEPTION);
	$this->db->exec('use ' . $this->config->log->db->dbname);
    }
}
