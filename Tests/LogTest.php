<?php
namespace Tests;
use \Tests\Test;
use Onside\Log\Db;

class LogTest extends Test
{
    private $logdb;
    private $logfile;
    
    public function setUp()
    {
        parent::setUp();
        $this->logdb = new \Onside\Log\Db();
        $this->logfile = new \Onside\Log\File();
    }
    
    public function tearDown()
    {
        $this->logdb = null;
        $this->logfile = null;
        parent::tearDown();
    }
    
    public function testLog()
    {
        $this->assertInstanceOf('\Onside\Log', $this->logdb);
        $this->assertInstanceOf('\Onside\Log', $this->logfile);
    }
    
    public function testWrite()
    {
        $this->logdb->write('this is an example logging message');
        $this->logfile->write('this is an example logging message');
    }
}
