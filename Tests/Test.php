<?php
namespace Tests;
use \Onside\Db;
use \PHPUnit_Framework_TestCase;
use \PDO;

class Test extends PHPUnit_Framework_TestCase
{
    protected function countTable($table)
    {
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=On2011Side;dbname=onside_unittest', 'onside', 'On2011Side');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
//        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $stmt = $db->prepared('use onside_unittest');
        $row = $db->prepared('SELECT count(1) AS count FROM `' . $table . '`')->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'];
    }
    
    protected function getDb()
    {
	$db = new Db('mysql:host=127.0.0.1;user=onside;pass=On2011Side;dbname=onside_unittest', 'onside', 'On2011Side');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
	$stmt = $db->prepared('use onside_unittest');
	
	return $db;
    }
}
