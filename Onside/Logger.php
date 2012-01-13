<?php
namespace Onside;

class Logger implements Log
{
    private $filelog;
    private $dblog;
    
    public function __construct(Config $config)
    {
	$this->filelog = new \Onside\Log\File($config);
	$this->dblog = new \Onside\Log\Db($config);
    }
    
    public function write($message, $level = null)
    {
	$this->filelog->write($message, $level);
	$this->dblog->write($message, $level);
    }
}