<?php
namespace Tests;
use \Tests\Test;
use Onside\Db;

class DbTest extends Test
{
    private function getValidDb()
    {
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
        $stmt = $db->prepared('use onside_unittest');
        return $db;
    }
    
    public function testDb()
    {
        $db = $this->getValidDb();
        $this->assertInstanceOf('\Pdo', $db);
        
        $stmt = $db->prepared('SET autocommit=0;');
        $stmt = $db->prepared('start transaction');
        $stmt = $db->prepared('rollback');
        $stmt = $db->prepared('SET autocommit=1;');
    }
    
    public function getDSN()
    {
        return array(
            array('mysql:host=127.0.0.2;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside'),
            array('mysql:host=127.0.0.1;user=onside;pass=wrong;dbname=onside_unittest', 'onside', 'wrong'),
        );
    }
    
    /**
     * @dataProvider getDSN
     * @expectedException PDOException
     */
    public function testPdoException($dsn, $username, $password)
    {
        $db = new Db($dsn, $username, $password);
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
        $stmt = $db->prepared('random text to trigger exception');
    }
    
    public function testReturnStmt()
    {
        $db = $this->getValidDb();
        $stmt = $db->prepared('SHOW TABLES');
        $this->assertInstanceOf('\PDOStatement', $stmt);
    }
    
    public function testReturnRowCount()
    {
        $db = $this->getValidDb();
        $count = $db->prepared('INSERT INTO `logs` (message) VALUES("message one"), ("message two")');
        $this->assertGreaterThan(1, $count);
    }
}