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
            // create entries
            if ($store) {
                if (!preg_match('/^;/', $line) && preg_match('/^([0-9a-zA-Z\.]+) = (.+)$/', $line, $matches)) {
                    $this->setValue($matches[1], $matches[2]);
                }
            }
            // start of section
            if (preg_match('/^\[(.+) : (.+)\]$/', $line, $matches) || preg_match('/^\[(.+)\]$/', $line, $matches)) {
                if ($matches[1] == $env) {
                    $store = true;
                } else {
                    $store = false;
                }
            }
        }
    }
    
    protected function setValue($key, $value)
    {
        $ref =& $this;
        $keys = explode('.', $key);
        foreach ($keys as $key) {
            $ref =& $ref->$key;
            if (!isset($ref)) {
                $ref = (object)array();
            }
        }
        $ref = $value;
    }
}
