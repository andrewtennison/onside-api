<?php
namespace Tests\Mapper;
use \Tests\Test;
use \Onside\Mapper;
use \Onside\Mapper\Article;
use \Onside\Db;

class MockArticle extends Article
{
    public function createTable()
    {
        $this->_createTable();
    }
    
    public function truncateTable()
    {
        $this->_truncateTable();
    }
    
}

class ArticleTest extends Test
{
    private $article;
    public function setUp()
    {
        parent::setup();
        $this->markTestSkipped();
        $db = new Db('mysql:host=127.0.0.1;user=onside;pass=onside;dbname=onside_unittest', 'onside', 'onside');
        $db->setAttribute(Db::ATTR_ERRMODE, Db::ERRMODE_EXCEPTION);
        $stmt = $db->prepared('use onside_unittest');
        
        $this->article = new MockArticle($db);
    }
    
    public function tearDown()
    {
        $this->article = null;
        parent::tearDown();
    }    
    
    public function testCreateTable()
    {
        $this->assertNull($this->article->createTable());
        return true;
    }
    
    /**
     * @depends testCreateTable
     */
    public function testAddItem()
    {
        $count = $this->countTable('article');
        $data = array(
            'name' => 'test name',
            'added' => date('Y-m-d H:i:s'),
        );
        $id = $this->article->addItem($data);
        $this->assertGreaterThan($count, $this->countTable('article'));
        $this->assertEquals(1, $id);
        // TODO: test full insert
        $data['someotherfield'] = 'some other text';
        $id = $this->article->addItem($data);
        $this->assertGreaterThan($count, $this->countTable('article'));
        $this->assertEquals(2, $id);
        
        return $id;
    }
    
    /**
     * @depends testAddItem
     */
    public function testUpdateItem($id)
    {
//        $this->markTestIncomplete();
        $data = array(
            'name' => 'different test name',
            'added' => date('Y-m-d H:i:s'),
        );
        $result = $this->article->updateItem($id, $data);
echo 'RESULT: |' . $result . "|\n";
        //$this->assertTrue($result);
        return true;
    }

    /**
     * @depends testUpdateItem
     */
    public function testSelectItem()
    {
        $result = $this->article->selectItem();
echo 'RESULT: |' . $result . "|\n";
//        $this->assertTrue($this->article->selectItem());
        return 1;
    }
    
    /**
     * @depends testSelectItem
     */
    public function testDeleteItem($id)
    {
        $result = $this->article->deleteItem($id);
echo 'RESULT: |' . $result . "|\n";
////        $this->markTestIncomplete();
//        $this->assertTrue($this->article->deleteItem($id));
    }
    
    public function testTruncateTable()
    {
        $this->markTestIncomplete();
        $this->assertTrue($this->article->truncateTable());
    }
}
