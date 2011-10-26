<?php
namespace Onside;

class Config
{
    public function __construct($env, $filename)
    {
        assert('null !== $env && null !== $filename');

        $store = false;
        // TODO: throw exception if file doesn't exists
        $content = file_get_contents(APPLICATION_CONFIG . '/' . $filename);
        $lines = explode("\n", $content);
        $array = $this->arrayOfSections($lines);
        
        // TODO: throw exception if $env is not in $array
        $sections = array($env);
        while(null !== $array[$env]['parent']) {
            $sections[] = $array[$env]['parent'];
            $env = $array[$env]['parent'];
        }
        rsort($sections);
        
        $this->setValues($array, $sections);
    }
    
    protected function setValues(array $array, array $sections)
    {
        foreach ($sections as $section) {
            // TODO: throw an exception
            if (!is_array($array[$section]['lines'])) {
            } else {
                foreach ($array[$section]['lines'] as $line) {
                    $this->setValue($line[0], $line[1]);
                }
            }
        }
    }
    
    protected function arrayOfSections($lines)
    {
        $ref = null;
        $array = array();
        foreach ($lines as $line) {
            // create entries
            if (null !== $ref) {
                if (!preg_match('/^;/', $line) && preg_match('/^([0-9a-zA-Z\.]+) = (.+)$/', $line, $matches)) {
                    $ref[] = array($matches[1], $matches[2]);
                }
            }
            // start of section
            if (preg_match('/^\[(.+) : (.+)\]$/', $line, $matches) || preg_match('/^\[(.+)\]$/', $line, $matches)) {
                $array[$matches[1]]['parent'] = count($matches) === 3 ? $matches[2] : null;
                $array[$matches[1]]['lines'] = array();
                $ref =& $array[$matches[1]]['lines'];
            }
        }
        
        return $array;
    }
    
    protected function setValue($key, $value)
    {
        $value = str_replace('"', '', $value);
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
