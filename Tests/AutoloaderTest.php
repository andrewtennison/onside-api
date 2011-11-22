<?php
namespace Tests;
use \Tests\Test;
use \Onside\Autoloader;

class AutoloaderTest extends Test
{
    private $autoloader;
    
    public function setUp()
    {
        parent::setUp();
        $this->autoloader = new Autoloader();
    }
    
    public function tearDown()
    {
        $this->autoloader = null;
        parent::tearDown();
    }
    
    public function testAutoloader()
    {
        $this->assertInstanceOf('\Onside\Autoloader', $this->autoloader);
    }
    
    public function providerValidClasses()
    {
        return array(
//            array('Onside\Config'),
//            array('Onside\Db'),
//            array('Onside\Log'),
            array('Onside\Onside'),
            array('Onside\Queue'),
//            array('Onside\Rule'),
            array('Onside\Api\ArticleController'),
        );
    }
    
    /**
     * @dataProvider providerValidClasses
     */
    public function testValidClasses($className)
    {
        $class = new $className();
        $this->assertInstanceOf('\\' . $className, $class);
    }
    
    /**
     * @expectedException \Onside\AutoloaderException
     */
    public function testInvalidClasses()
    {
        $className = 'Onside\NonExistantClass';
        $class = new $className();
    }
}
