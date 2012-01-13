<?php
namespace Tests\Feed;
use \Tests\Test;
use \Onside\Feed\Source;

class SourceTest extends Test
{
    private $sources;
    
    public function setUp()
    {
	parent::setUp();
	$model = \Onside\Model\Source::getModelFromArray(array());
	$this->sources = $this->getDb()->prepared($model->getSelectSQL())->fetchAll(\PDO::FETCH_CLASS, '\Onside\Model\Source');
//	echo print_r($this->sources, true) . "\n";
    }
    
    public function tearDown()
    {
	$this->sources = null;
	parent::tearDown();
    }
    
    /**
     * @expectedException ErrorException
     */
    public function testInitFail()
    {
	$source = new Source();
	$this->assertInstanceOf('\Onside\Feed\Source', $source);
    }
    
    public function testInitSuccess()
    {
	$source = new Source(\Onside\Model\Source::getModelFromArray(array()));
	$this->assertInstanceOf('\Onside\Feed\Source', $source);
    }
    
    public function dbSources()
    {
	return array($this->sources[0]);
    }
    
    /**
     */
    public function testDbSources()
    {
	$model = $this->sources[0];
	$this->assertInstanceOf('\Onside\Model\Source', $model);
	$source = new Source($model);
	$this->assertInstanceOf('\Onside\Feed\Source', $source);
    }
    
    public function testGetArticles()
    {
	$model = $this->sources[0];
	$this->assertInstanceOf('\Onside\Model\Source', $model);
	$source = new Source($model);
	$this->assertInstanceOf('\Onside\Feed\Source', $source);
	$articles = $source->getArticles();
	$this->assertInternalType('array', $articles);
	
    }
}