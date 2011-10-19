<?php
namespace Tests;
use \Tests\Test;
use Onside\Config\Common;
use Onside\Config\Sources;

class ConfigTest extends Test
{
    public function testCommonIni()
    {
        $config = new Common('development');
        $this->assertInstanceOf('\Onside\Config', $config);
        $this->assertObjectHasAttribute('db', $config);
        $this->assertObjectHasAttribute('log', $config);
    }
    
    public function testSourcesIni()
    {
        $sources = new Sources('development');
        $this->assertInstanceOf('\Onside\Config', $sources);
        $this->assertObjectHasAttribute('rss', $sources);
    }
}