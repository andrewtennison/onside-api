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
            array('Person'),
            array('Person', 200),
            array('Vote', 200, array(
                array('vote' => 1, 'added' => date('d/m/Y H:i:s')),
                array('votes' => 2, 'added' => date('d/m/Y H:i:s')),
            )),
            array('Person', 200, array(), array(
                array('code' => 10001, 'message' => 'This is a tes error message'),
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
        $this->assertObjectHasAttribute('type', $object);
        $this->assertInternalType('string', $object->type);
        $this->assertObjectHasAttribute('code', $object);
        $this->assertInternalType('int', $object->code);
        if (count($data) > 0) {
            $this->assertObjectHasAttribute('count', $object);
            $this->assertObjectHasAttribute('results', $object);
            $this->assertEquals($object->count, count($object->results));
            $this->assertInternalType('array', $object->results);
            foreach ($object->results as $row) {
                $this->assertObjectHasAttribute('result', $row);
                $this->assertInternalType('object', $row->result);
            }
        }
        if (count($errors) > 0) {
            $this->assertObjectHasAttribute('errors', $object);
            $this->assertInternalType('array', $object->errors);
            $this->assertEquals(count($errors), count($object->errors));
            foreach ($object->errors as $row) {
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
