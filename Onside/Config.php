<?php
namespace Onside;

abstract class Config
{
    public function __construct($env)
    {
        $store = false;
        $class = str_replace('Onside\Config\\', '', get_class($this)) . '.ini';
        $content = file_get_contents(APPLICATION_CONFIG . '/' . $class);
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            // start of section
            if (preg_match('/^\[(.+) : (.+)\]$/', $line, $matches) || preg_match('/^\[(.+)\]$/', $line, $matches)) {
echo print_r($matches, true) . "\n";
                if ($matches[1] == $env) {
                    $store = true;
                } else {
                    $store = false;
                }
            }
            // create entries
            if ($store) {
                if (!preg_match('/^;/', $line) && preg_match('/^([0-9a-zA-Z\.]+) = (.+)$/', $line, $matches)) {
echo print_r($matches, true) . "\n";
                    $this->setValue($matches[1], $matches[2]);
                }
            }
        }
    }
    
    protected function setValue($key, $value)
    {
        $key = str_replace('.', '->', $key);
        $this->$key = $value;
    }
}
