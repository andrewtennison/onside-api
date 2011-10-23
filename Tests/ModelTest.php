<?php
namespace Tests;
use \Onside\Model;
use \Onside\Model\Article;

class ModelTest extends Test
{
    public function provideUpdateModels()
    {
        return array(
            array('\Onside\Model\Article', Article::getModelFromArray(array('name' => 'test name', 'id' => 1))),
        );
    }
    
    public function provideModels()
    {
        return array(
            array('\Onside\Model\Article', Article::getModelFromArray(array('name' => 'test name'))),
        );
    }
    
    /**
     * @dataProvider provideModels
     */
    public function testModel($class, $model)
    {
        $this->assertInstanceOf($class, $model);
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
