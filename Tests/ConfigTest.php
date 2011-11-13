<?php
namespace Tests;
use \Tests\Test;
use \Onside\Config;

class ConfigTest extends Test
{
    public function provideEnvironments()
    {
        return array(
            array('production'),
            array('staging'),
            array('development'),
        );
    }
    
    /**
     * @dataProvider provideEnvironments
     */
    public function testCommonIni($env)
    {
        $config = new Config($env, 'Common.ini');
        $this->assertInstanceOf('\Onside\Config', $config);
        $this->assertObjectHasAttribute('db', $config);
        $this->assertObjectHasAttribute('log', $config);
    }
    
    /**
     * @dataProvider provideEnvironments
     */
    public function testSourcesIni($env)
    {
        $sources = new Config($env, 'Sources.ini');
        $this->assertInstanceOf('\Onside\Config', $sources);
        $this->assertObjectHasAttribute('rss', $sources);
    }
}