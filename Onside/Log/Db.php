<?php
namespace Onside\Log;
use \Onside\Log;

class Db extends Log
{
    protected $db;
    
    public function write($message)
    {
        if (is_null($this->db)) $this->connect();
        $stmt = $this->db->prepared('INSERT INTO logs (message), VALUES(?)', array($message));
    }
    
    private function connect()
    {
        $this->db = new \Onside\Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
    }
}
