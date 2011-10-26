<?php
namespace Tests;
use \Onside\Db;
use \Onside\Mapper;
use \Onside\Mapper\Article;
use \Onside\Mapper\Channel;
use \Onside\Mapper\Discussion;
use \Onside\Mapper\Event;
use \Onside\Mapper\User;

class MapperTest extends Test
{
    public function provideMappers()
    {
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
        return array(
            array(
                '\Onside\Mapper\Article',
                new \Onside\Mapper\Article($db),
                array('name' => 'this is a sample name'),
            ),
            array(
                '\Onside\Mapper\Channel',
                new \Onside\Mapper\Channel($db),
                array('name' => 'this is a sample name'),
            ),
            array(
                '\Onside\Mapper\Discussion',
                new \Onside\Mapper\Discussion($db),
                array('name' => 'this is a sample name'),
            ),
            array(
                '\Onside\Mapper\Event',
                new \Onside\Mapper\Event($db),
                array('name' => 'this is a sample name'),
            ),
            array(
                '\Onside\Mapper\User',
                new \Onside\Mapper\User($db),
                array('name' => 'this is a sample name'),
            ),
        );
    }
    
    public function provideSelectMappers()
    {
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
        return array(
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array(),
                array(),
                null,
            ),
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array('id' => 30),
                array(),
                null,
            ),
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array(),
                array('id' => true),
                null,
            ),
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array(),
                array('id' => false),
                100,
            ),
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array(),
                array('id' => false),
                array(55),
            ),
            array(
                '\Onside\Model\Article',
                new \Onside\Mapper\Article($db),
                array(),
                array('id' => true),
                array(99, 33),
            ),
        );
    }
        
    /**
     * @dataProvider provideMappers
     */
    public function testMapper($class, $mapper, $data)
    {
        $parts = explode('\\', strtolower($class));
        $table = $parts[count($parts) - 1];

        $this->assertInstanceOf($class, $mapper);
        $this->assertInstanceOf('\Onside\Mapper', $mapper);
        
        // add
        $count = $this->countTable($table);
        $id = $mapper->addItem($data);
        $count1 = $this->countTable($table);
        $this->assertGreaterThan($count, $count1);
        
        // update
        unset($data['id']);
        $data['name'] = 'this name has been changed by an update query';
        $this->assertEquals(1, $mapper->updateItem($id, $data));
        $count2 = $this->countTable($table);
        $this->assertEquals($count1, $count2);
        
        // delete
        $this->assertEquals(1, $mapper->deleteItem($id));
        $count3 = $this->countTable($table);
        $this->assertLessThan($count2, $count3);
    }
    
    /**
     * @dataProvider provideSelectMappers
     */
    public function testSelectMapper($class, $mapper, $where, $sort, $limit)
    {
        // select
        $rows = $mapper->selectItem($where, $sort, $limit);
        $this->assertInternalType('array', $rows);
        foreach ($rows as $row) {
            $this->assertInternalType('object', $row);
            $this->assertInstanceOf($class, $row);
        }
//echo '$rows: ' . print_r($rows, true) . "\n";
    }
}
