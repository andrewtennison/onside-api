<?php
namespace Tests\Api;
use \Tests\Test;
use \Api\Api;
use \Tests\Api\MockController;

class ApiTest extends Test
{
    private $api;
    
    public function setUp()
    {
        parent::setUp();
        $options = array(
            'uri' => '/article/8475th3293fh3ufhejwfkn',
            'method' => 'DELETE',
            'get' => array(),
            'post' => array(),
        );
        $this->api = new Api($options);
    }
    
    public function tearDown()
    {
        $this->api = null;
        parent::tearDown();
    }
    
    public function testApi()
    {
        $this->assertInstanceOf('\Api\BaseApi', $this->api);
    }
    
    public function dataHttpMethods()
    {
        return array(
            array(new Api(
                array(
                    'uri' => '/article/123', 'method' => 'DELETE', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/article', 'method' => 'GET', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/article/123', 'method' => 'GET', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/channel/follow', 'method' => 'GET', 'get' => array('id' => 123), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/article/123', 'method' => 'POST', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/article/123', 'method' => 'PUT', 'get' => array(), 'post' => array()
                )
            )),
        );
    }
    
    /**
     * @dataProvider dataHttpMethods
     */
    public function testRun($api)
    {
        $result = $api->run();
        $this->assertInstanceOf('\Api\Response', $result);
        
    }
}