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
        list($data, $errors) = $this->controller->actionDelete(1);
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionGet()
    {
        $this->markTestIncomplete('Waiting completion of response');
        list($data, $errors) = $this->controller->actionGet();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertEquals(0, count($errors));
    }
    
    public function testActionItem()
    {
        list($data, $errors) = $this->controller->actionItem(1);
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionPost()
    {
        list($data, $errors) = $this->controller->actionPost(1, array());
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionPut()
    {
        list($data, $errors) = $this->controller->actionPut(array());
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
}
