<?php
namespace Onside;
use \Exception;

// Self contained to avoid issues with
// using Autoloader to load exception file
class AutoloaderException extends Exception
{}

class Autoloader
{
    public function loader($className)
    {
//echo "Autoloader::loader($className)\n";
//        $parts  = explode('\\', str_replace('Onside\\', '', $className));
        $parts  = explode('\\', $className);
        $filename = APPLICATION_BASE . '/' . implode('/', $parts) . '.php';
//echo "Autoloader::\$filename: $filename\n";
        $this->assertFileExists($filename);
        assert('$this->assertFileExists($filename)');
        require $filename;
    }
    
    private function assertFileExists($filename)
    {
        $path = stream_resolve_include_path($filename);
//echo 'Autoloader::assertFileExists($filename): ' . $filename . "\n";
//echo 'file_exists($path): ' . $path . ' ' . (file_exists($path) ? 'true' : 'false') . "\n";
        if (!file_exists($path)) {
            throw new AutoloaderException("File $filename could not be found at path $path");
        }
        
        return true;
    }
}
