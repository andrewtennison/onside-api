<?php
namespace Tests;
use \Tests\Test;
use Onside\Config\Common;

class ConfigTest extends Test
{
    public function testCommonIni()
    {
        $config = new Common('development');
echo print_r($config, true) . "\n";
    }
}