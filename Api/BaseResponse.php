<?php
namespace Api;

abstract class BaseResponse
{
    protected $allowedTypes = array();
    protected $integerFields = array();
    protected $booleanFields = array();
    
    protected $responseCode;
    protected $responseType;

    public function __construct($responseType = 'unknown', $responseCode = 200, $object = array(), $errors = array())
    {
        assert('!empty($responseCode)');
        $this->assertResponseType($responseType);
        $this->responseCode = $responseCode;
        $this->responseType = $responseType;
        $this->response = $this->parseResponse($object, $errors);
    }

    public function sendResponse()
    {
        header('HTTP/1.1 ' . $this->responseCode . ' api');
        header('X-Content-Type-Options:nosniff');
        header('Content-Type:application/javascript;charset=UTF-8');
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

    protected function assertResponseType($responseType)
    {
        if (!in_array($responseType, $this->allowedTypes)) {
//            throw new Exception('Incorrect response type passed: ' . $responseType);
        }
    }
    
    protected function parseResponse($object, $errors)
    {
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
        $response->count = count($object);
        $response->resultset = array();
        foreach ($object as $row) {
            foreach ($row as $key => $value) {
		// TODO: use array_key_exists for better optimization
                if (in_array($key, $this->integerFields)) $row[$key] = (int)$value;
                if (in_array($key, $this->booleanFields)) $row[$key] = (bool)$value;
            }
            $response->resultset[] = array('result' => $row);
        }
        return $response;
    }
}
