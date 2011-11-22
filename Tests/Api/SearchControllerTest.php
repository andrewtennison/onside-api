<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\SearchController;

class SearchControllerTest extends Test
{
    public function setUp()
    {
        parent::setUp();
        $this->controller = new SearchController();
    }
    
    public function tearDown()
    {
        $this->controller = null;
        parent::tearDown();
    }
    
    public function testActionDelete()
    {
        $this->markTestIncomplete('test for error response');
        $this->controller->actionDelete(1);
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionGet()
    {
        $this->controller->actionGet(array('q' => 'football'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionPost()
    {
	$this->markTestIncomplete('test for error response');
        $this->controller->actionPost(1, array());
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionPut()
    {
	$this->markTestIncomplete('test for error response');
        $this->controller->actionPut(array());
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionList()
    {
        $this->controller->actionList(array('q' => 'football'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionSave()
    {}
}
