<?php
namespace Tests;
use \Onside\Model;
use \Onside\Model\Article;
use \Onside\Model\Channel;
use \Onside\Model\Comment;
use \Onside\Model\Event;
use \Onside\Model\User;

class ModelTest extends Test
{    
    public function provideModels()
    {
        return array(
            array('\Onside\Model\Article', Article::getModelFromArray(array('title' => 'test name article'))),
            array('\Onside\Model\Channel', Channel::getModelFromArray(array('name' => 'test name channel', 'level' => 2))),
            array('\Onside\Model\Comment', Comment::getModelFromArray(array('name' => 'test name discussion'))),
            array('\Onside\Model\Event', Event::getModelFromArray(array('name' => 'test name event'))),
            array('\Onside\Model\User', User::getModelFromArray(array('name' => 'test name user'))),
        );
    }
    
    public function provideUpdateModels()
    {
        return array(
            array('\Onside\Model\Article', Article::getModelFromArray(array('title' => 'test name article', 'id' => 1))),
            array('\Onside\Model\Channel', Channel::getModelFromArray(array('name' => 'test name channel', 'id' => 1, 'level' => 2))),
            array('\Onside\Model\Comment', Comment::getModelFromArray(array('name' => 'test name discussion', 'id' => 1))),
            array('\Onside\Model\Event', Event::getModelFromArray(array('name' => 'test name event', 'id' => 1))),
            array('\Onside\Model\User', User::getModelFromArray(array('name' => 'test name user', 'id' => 1))),
        );
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testModel($class, $model)
    {
        $this->assertInstanceOf($class, $model);
        $this->assertNull($model->clearSort());
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testGetInsertSQL($class, $model)
    {
        $sql = $model->getInsertSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('INSERT INTO ', $sql);
        $values = $model->getValues();
        $this->assertInternalType('array', $values);
        $this->assertGreaterThan(0, count($values));
    }
    
    /**
     * @dataProvider provideUpdateModels
     */
    public function testGetUpdateSQL($class, $model)
    {
        $sql = $model->getUpdateSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('UPDATE ', $sql);
        $values = $model->getValues();
        $this->assertInternalType('array', $values);
        $this->assertGreaterThan(1, count($values));
        $this->assertEquals(1, $values[count($values) - 1]);
    }
    
    /**
     * @dataProvider provideUpdateModels
     */
    public function testGetDeleteSQL($class, $model)
    {
        $sql = $model->getDeleteSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('DELETE FROM ', $sql);
        $values = $model->getValues();
        $this->assertInternalType('array', $values);
        $this->assertEquals(1, count($values));
        $this->assertEquals(1, $values[0]);
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testGetCreateSQL($class, $model)
    {
        $sql = $model->getCreateSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('CREATE TABLE IF NOT EXISTS ', $sql);
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testGetDropSQL($class, $model)
    {
        $sql = $model->getDropSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('DROP TABLE IF EXISTS ', $sql);
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testGetTruncateSQL($class, $model)
    {
        $sql = $model->getTruncateSQL();
        $this->assertInternalType('string', $sql);
        $this->assertStringStartsWith('TRUNCATE TABLE ', $sql);
    }
}
