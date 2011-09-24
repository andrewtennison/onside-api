<?php
namespace Onside;

class Autoloader
{
    public function loader($className)
    {
//echo "Autoloader::loader($className)\n";
//        $parts  = explode('\\', str_replace('Onside\\', '', $className));
        $parts  = explode('\\', $className);
        $filename = APPLICATION_BASE . '/' . implode('/', $parts) . '.php';
        assert('$this->_assertFileExists($filename)');
        require $filename;
    }
    
    private function assertFileExists($filename)
    {
        $path = stream_resolve_include_path($filename);
        if (!file_exists($path)) {
//            throw new AutoloaderException("File $file could not be found for class $class");
        }
        
        return true;
    }
}
