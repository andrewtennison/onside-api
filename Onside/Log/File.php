<?php
namespace Onside\Log;
use \Onside\Log;
use \Onside\Config;

class File implements Log
{
    protected $config;
    protected $fh;
    
    public function __construct(Config $config)
    {
	$this->config = $config;
    }
    
    public function __destruct()
    {
        if ($this->fh !== null)
            fclose($this->fh);
    }

    public function write($message)
    {
        if ($this->fh === null) $this->open();
        fwrite($this->fh, date('Y-m-d H:i:s') . " - " . $message . "\n");
	
	return true;
    }
    
    private function open()
    {
        $this->fh = fopen(APPLICATION_BASE . '/' . $this->config->log->file, 'a');
	if ($this->fh === false) {
	    throw new \Exception("Can't open logfile for appending", 1001);
	}
    }
}
