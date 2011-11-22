<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\Request;

class RequestTest extends Test
{
    public function getRequests()
    {
        return array(
            array('/article', 'GET'),
            array('/article/1', 'GET'),
        );
    }
    
    /**
     * @dataProvider getRequests
     */
    public function testGetRequest($uri, $method, $get = array(), $post = array())
    {
        list($object, $key) = strpos(substr($uri, 1), '/') ?
            explode('/', substr($uri, 1)) :
            array(substr($uri, 1), null)
        ;
        $request = new Request($uri, $method, $get, $post);
        $this->assertInstanceOf('\Onside\Api\BaseRequest', $request);
        $this->assertEquals($object, $request->getObject());
        $this->assertEquals($key, $request->getKey());
        $this->assertEquals($method, $request->getMethod());

        $response = $request->getResponse('Article', 200, array());
        $this->assertInstanceOf('\Onside\Api\BaseResponse', $response);
    }
    
    public function getRequestsWithParams()
    {
        return array(
            array('/article', 'GET', array('channel' => '8475th3293fh3ufhejwfkn')),
            array('/article/8475th3293fh3ufhejwfkn', 'GET', array('event' => '8475th3293fh3ufhejwfkn')),
        );
    }
    
    /**
     * @dataProvider getRequestsWithParams
     */
    public function testGetParam($uri, $method, $get = array(), $post = array())
    {
        list($object, $key) = strpos(substr($uri, 1), '/') ?
            explode('/', substr($uri, 1)) :
            array(substr($uri, 1), substr($uri, 1))
        ;
        $keys = array_keys($get);
        $key = $get[$keys[0]];
        $request = new Request($uri, $method, $get, $post);
        $this->assertEquals($key, $request->getParam($keys[0]), print_r($request, true));
        $this->assertNull($request->getParam('abcdefghijklmnopqrstuvwxyz0123456789'));
    }
    
    public function dataGetPost()
    {
        return array(
            array(array('description' => 'some text updated', 'abc' => 123)),
        );
    }
    
    /**
     * @dataProvider dataGetPost
     */
    public function testGetPost($post)
    {
        $request = new Request('/article', 'POST', array(), $post);
        $this->assertInternalType('array', $request->getPost());
    }
    
    public function testGetGet()
    {
	$request = new Request('/article', 'GET', array('title' => 'test article'), null);
	$get = $request->getGet();
	$this->assertInternalType('array', $get);
    }
}
