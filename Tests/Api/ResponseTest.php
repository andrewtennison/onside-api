<?php
namespace Tests\Api;
use \Tests\Test;
use \Api\Response;

class ResponseTest extends Test
{
    public function testSendResponse()
    {
        $response = new Response('Person', 200);
        $this->assertInstanceOf('\Api\BaseResponse', $response, 'Class found: ' . get_class($response));
        
    }
    
    public function getResponses()
    {
        return array(
            array('Article'),
            array('Channel', 200),
            array('Channel', 200, array(
                array('id' => 1, 'name' => 'test name 1'),
                array('id' => 2, 'name' => 'test name 2'),
            )),
            array('Event', 200, array(), array(
                array('code' => 10001, 'message' => 'This is a test error message'),
                array('code' => 20200, 'message' => 'Different error message'),
            )),
        );
    }
    /**
     * @dataProvider getResponses
     */
    public function testGetJson($type, $code = 200, $data = array(), $errors = array())
    {
        $response = new Response($type, $code, $data, $errors);
        $object = json_decode($response->getJson());
        $this->assertInstanceOf('\stdClass', $object);
        $this->assertObjectHasAttribute('service', $object);
        $this->assertInternalType('string', $object->service);
        //$this->assertObjectHasAttribute('code', $object);
        //$this->assertInternalType('int', $object->code);
        if (count($data) > 0) {
            $this->assertObjectHasAttribute('count', $object);
            $this->assertObjectHasAttribute('resultset', $object);
            $this->assertEquals($object->count, count($object->resultset));
            $this->assertInternalType('array', $object->resultset);
            foreach ($object->resultset as $row) {
                $this->assertObjectHasAttribute('result', $row);
                $this->assertInternalType('object', $row->result);
            }
        }
        if (count($errors) > 0) {
            $this->assertObjectHasAttribute('errorset', $object);
            $this->assertInternalType('array', $object->errorset);
            $this->assertEquals(count($errors), count($object->errorset));
            foreach ($object->errorset as $row) {
                $this->assertObjectHasAttribute('error', $row);
                $this->assertInternalType('object', $row->error);
                $this->assertObjectHasAttribute('code', $row->error);
                $this->assertInternalType('int', $row->error->code);
                $this->assertObjectHasAttribute('message', $row->error);
                $this->assertInternalType('string', $row->error->message);
            }
        }
    }
    
    public function testGetXml()
    {
        $response = new Response('Article', 200, array(), array());
        $this->assertNull($response->getXml());
    }
}
