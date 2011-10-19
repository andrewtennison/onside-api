<?php
namespace Tests;
use \Tests\Test;
use Onside\Db;

class DbTest extends Test
{
    public function testDb()
    {
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
        $this->assertInstanceOf('\Pdo', $db);
        
        $stmt = $db->prepared('use onside_unittest');
        $stmt = $db->prepared('SET autocommit=0;');
        $stmt = $db->prepared('START TRANSACTION');
        $stmt = $db->prepared('rollback');
        
    }
}
