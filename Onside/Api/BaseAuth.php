<?php
namespace Onside\Api;

class BaseAuth
{
    const NONE = 1;
    const BASIC = 2;
    const DIGEST = 3;
    const OAUTH = 4;

//    public function tryAuthenticate()
//    {}
    
    public function canAuth($type, $username, $password)
    {
	switch ($type) {
	    case self::OAUTH:
		$this->doOAuth();
		break;
	    case self::DIGEST:
		$this->doDigestAuth();
		break;
	    case self::BASIC:
		$this->doBasicAuth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		break;
	    default:
		break;
	}
    }
    
    private function doOAuth()
    {}
    
    private function doDigestAuth()
    {}
    
    private function doBasicAuth($username, $password)
    {
	if ($username !== 'isaac' || $password !== 'test') {
	    $errors = new \Onside\Api\Errors();
	    $error = $errors->getError(101, array());
	    throw new Exception(array($error->getResponse()), 401);
	}
    }
    
}
