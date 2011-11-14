<?php
namespace Api;

class Exception extends \Exception
{
    protected $default_status;
    protected $response_fields;
    protected $http_headers;
    
    public function __construct(array $response_fields = array(), $http_status = null)
    {
	if (null === $http_status) $http_status = $this->default_status;
	
	parent::__construct(json_encode($response_fields), $http_status);
	
	$this->response_fields = $response_fields;
	$this->http_headers = $http_status;
    }
    
    public function getResponseFields()
    {
	return $this->response_fields;
    }
    
    public function getHeaders()
    {
        return $this->http_headers;
    }
}

