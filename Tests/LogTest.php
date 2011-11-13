<?php
namespace Tests;
use \Tests\Test;
use \Onside\Log\Db;
use \Onside\Config;

class LogTest extends Test
{
    private $config;
    private $logdb;
    private $logfile;
    
    public function setUp()
    {
        parent::setUp();
	$this->config = new Config('development', 'Common.ini');
        $this->logdb = new \Onside\Log\Db($this->config);
        $this->logfile = new \Onside\Log\File($this->config);
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
	$db_before = $this->countTable('logs');
        $this->assertTrue($this->logdb->write('this is an example logging message'));
	$db_after = $this->countTable('logs');
	$this->assertGreaterThan($db_before, $db_after);
	
	$file_before = file_get_contents($this->config->log->file);
        $this->assertTrue($this->logfile->write('this is an example logging message'));
	$file_after = file_get_contents($this->config->log->file);
	$this->assertGreaterThan(count(explode("\n", $file_before)), count(explode("\n", $file_after)));
    }
}
