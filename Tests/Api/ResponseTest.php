<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Api\Response;
use \Onside\Model\Channel;

class ResponseTest extends Test
{
    public function testSendResponse()
    {
        $response = new Response('Channel', 200);
        $this->assertInstanceOf('\Onside\Api\BaseResponse', $response, 'Class found: ' . get_class($response));
        
    }
    
    public function getResponses()
    {
        return array(
//            array('Article'),
//            array('Channel', 200),
            array('Channel', 200, array(array(
                Channel::getModelFromArray(array('id' => 1, 'name' => 'test name 1')),
                Channel::getModelFromArray(array('id' => 2, 'name' => 'test name 2')),
            ))),
//            array('Event', 200, array(), array(
//                array('code' => 10001, 'message' => 'This is a test error message'),
//                array('code' => 20200, 'message' => 'Different error message'),
//            )),
        );
    }
    /**
     * @dataProvider getResponses
     */
    public function testGetJson($type, $code = 200, $data = array(), $errors = array())
    {
        $response = new Response($type, $code, $data, $errors);
	$type = strtolower($type) . 's';
        $object = json_decode($response->getJson());
        $this->assertInstanceOf('\stdClass', $object);
        $this->assertObjectHasAttribute('service', $object);
        $this->assertInternalType('string', $object->service);
        //$this->assertObjectHasAttribute('code', $object);
        //$this->assertInternalType('int', $object->code);
        if (count($data) > 0) {
            $this->assertObjectHasAttribute('count', $object);
            $this->assertObjectHasAttribute('resultset', $object);
//echo "\n" . print_r($object, true) . "\n";
//echo '$object->count: ' . $object->count . "\n";
//echo 'count($object->resultset): ' . count($object->resultset) . "\n";
            $this->assertEquals($object->count, count($object->resultset->$type), print_r($object, true));
	    
            $this->assertInternalType('array', $object->resultset->$type, print_r($object->resultset->$type, true));
            foreach ($object->resultset->$type as $row) {
                $this->assertInternalType('object', $row);
                $this->assertObjectHasAttribute('id', $row);
		$this->assertInternalType('int', $row->id);
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
