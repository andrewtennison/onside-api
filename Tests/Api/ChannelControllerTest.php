<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\ChannelController;

class ChannelControllerTest extends Test
{
    public function setUp()
    {
        parent::setUp();
        $this->controller = new ChannelController();
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
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionGet()
    {
        $this->controller->actionGet();
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
//        $this->assertCount(0, $data);
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
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionPost()
    {
        $this->controller->actionPost(1, array('sport' => 'tennis'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(1, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionPut()
    {
        $this->controller->actionPut(array('level' => 2));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionFollow()
    {
        $this->controller->actionFollow(null, array('channel' => 1, 'user' => 1));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertGreaterThan(0, count($data));
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
}
