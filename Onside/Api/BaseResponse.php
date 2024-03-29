<?php
namespace Onside\Api;

abstract class BaseResponse
{
    //protected $allowedTypes = array();
    protected $integerFields = array();
    protected $booleanFields = array();
    
    protected $responseCode;
    protected $responseType;

    public function __construct($responseType = 'unknown', $responseCode = 200, $object = array(), $errors = array())
    {
        assert('!empty($responseCode)');
        //$this->assertResponseType($responseType);
        $this->responseCode = $responseCode;
        $this->responseType = $responseType;
        $this->response = $this->parseResponse($object, $errors);
    }

    public function sendResponse()
    {
        header('HTTP/1.1 ' . $this->responseCode . ' OK');
        header('X-Content-Type-Options:nosniff');
        header('Content-Type:application/json;charset=UTF-8');
//	header('Access-Control-Allow-Origin: *');
//	header('Access-Control-Max-Age: 3628800');
//	header('Access-Control-Allow-Methods: GET, POST, DELETE');
//	header('Access-Control-Allow-Headers: OnsideAuth');
        echo $this->getJson();
    }

    public function getJson()
    {
        return json_encode($this->response);
    }

    public function getXml()
    {
        return null;
    }

//    protected function assertResponseType($responseType)
//    {
//        if (!in_array($responseType, $this->allowedTypes)) {
//            throw new Exception('Incorrect response type passed: ' . $responseType);
//        }
//    }
    
    protected function parseResponse($objects, $errors)
    {
//	echo print_r($objects, true) . "\n";
        $response = new \stdClass;
        $response->service = $this->responseType;
//        $response->code = $this->responseCode;
        if (count($errors) > 0) {
            $response->errorset = array();
            foreach ($errors as $error) {
                $response->errorset[] = array('error' => array('code' => $error['code'], 'message' => $error['message']));
            }
            return $response;
        }
//echo "\nOBJECTS:\n" . print_r($objects, true) . "\n";
//echo "\nOBJECTS:\n" . count($objects) . ':' . count($objects[0]) . "\n";
        $response->count = array_key_exists(0, $objects) ? count($objects[0]) : 0;
        $response->resultset = array();
	if ('search' === strtolower($this->responseType)) {
	    if (!isset($objects[0]['articles']) && !isset($objects[0]['channels']) && !isset($objects[0]['events'])) {
		$response->resultset['searches'] = $objects[0];
	    } else {
		$response->count = count($objects[0]['articles']) + count($objects[0]['channels']) + count($objects[0]['events']);
    //die(print_r($objects, true));
		$response->resultset['articles'] = $objects[0]['articles'];
		$response->resultset['channels'] = $objects[0]['channels'];
		$response->resultset['events'] = $objects[0]['events'];
	    }
	    
	    return $response;
	}
        foreach ($objects as $row) {
	    $response->resultset[strtolower($this->responseType) . 's'] = $row;
        }
//echo "\n" . '$response: ' . print_r($response, true) . "\n";
	
        return $response;
    }
}
