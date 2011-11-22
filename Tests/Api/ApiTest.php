<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\Api;
use \Tests\Api\MockController;

class ApiTest extends Test
{
    private $api;
    
    public function setUp()
    {
        parent::setUp();
        $options = array(
            'uri' => '/article',
            'method' => 'GET',
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
        $this->assertInstanceOf('\Onside\Api\BaseApi', $this->api);
    }
    
    public function dataHttpMethods()
    {
        return array(
//            array(new Api(
//                array(
//                    'uri' => '/article/123', 'method' => 'DELETE', 'get' => array(), 'post' => array()
//                )
//            )),
            array(new Api(
                array(
                    'uri' => '/article', 'method' => 'GET', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/channel/1', 'method' => 'GET', 'get' => array(), 'post' => array()
                )
            )),
            array(new Api(
                array(
                    'uri' => '/channel/follow', 'method' => 'POST', 'get' => array(), 'post' => array('channel' => 123, 'user' => 321)
                )
            )),
            array(new Api(
                array(
                    'uri' => '/channel/1', 'method' => 'POST', 'get' => array(), 'post' => array('name' => 'sample title')
                )
            )),
            array(new Api(
                array(
                    'uri' => '/article', 'method' => 'POST', 'get' => array(), 'post' => array('title' => 'sample title', 'source' => 'test sources', 'type' => 'rss')
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
        $this->assertInstanceOf('\Onside\Api\Response', $result);
        
    }
}
