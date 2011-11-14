<?php
namespace Tests\Api;
use \Tests\Test;
use \Api\DiscussionController;

class DiscussionControllerTest extends Test
{
    public function setUp()
    {
        parent::setUp();
        $this->controller = new DiscussionController();
    }
    
    public function tearDown()
    {
        $this->controller = null;
        parent::tearDown();
    }
    
    public function testActionDelete()
    {
        $this->markTestIncomplete('Waiting completion of response');
        $this->controller->actionDelete(1);
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionGet()
    {
        $this->markTestIncomplete('Waiting completion of response');
        $this->controller->actionGet();
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionItem()
    {
        $this->controller->actionItem(1);
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionPost()
    {
        $this->controller->actionPost(1, array('name' => 'test discussion'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionPut()
    {
        $this->controller->actionPut(array('name' => 'test discussion'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
}
