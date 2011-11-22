<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\UserController;

class UserControllerTest extends Test
{
    public function setUp()
    {
        parent::setUp();
        $this->controller = new UserController();
    }
    
    public function tearDown()
    {
        $this->controller = null;
        parent::tearDown();
    }
    
    public function testActionDelete()
    {
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
        $this->controller->actionGet(array());
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionPost()
    {
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
        $this->controller->actionPut(array());
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
    
    public function testActionLogin()
    {
        $this->controller->actionLogin(null, array('email' => 'test@testing.com', 'password' => 'test'));
        $data = $this->controller->getResults();
	$errors = $this->controller->getErrors();
        $this->assertInternalType('array', $data);
        $this->assertEquals(0, count($data));
//        $this->assertCount(0, $data);
        $this->assertInternalType('array', $errors);
        $this->assertGreaterThan(0, count($errors));
    }
}
