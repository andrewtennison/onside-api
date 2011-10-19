<?php
namespace Onside\Log;
use \Onside\Log;

class File extends Log
{
    protected $fh;
    
    public function __destruct()
    {
        if ($this->fh !== null)
            fclose($this->fh);
    }

    public function write($message)
    {
        if ($this->fh === null) $this->open();
        fwrite($this->fh, $message);
    }
    
    private function open()
    {
        $this->fh = fopen('/tmp/onside.log', '+a');
    }
}
