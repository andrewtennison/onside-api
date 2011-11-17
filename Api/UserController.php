<?php
namespace Api;
use \Api\BaseController;
use \Onside\Mapper\User;

class UserController extends BaseController
{
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new User($db);
    }
        
    public function actionLogin($id, $data)
    {
//echo '$id: ' . $id . "\n";
//echo '$data: ' . print_r($data, true) . "\n";
	if (array_key_exists('email', $data) && array_key_exists('password', $data)) {
	    $result = $this->_mapper->doOnsideLogin($data['email'], $data['password']);
	} else if (array_key_exists('facebook', $data)) {
	    $result = $this->_mapper->doFacebookLogin($data['facebook']);
	} else if (array_key_exists('twitter', $data)) {
	    $result = $this->_mapper->doTwitterLogin($data['twitter']);
	} else if (array_key_exists('google', $data)) {
	    $result = $this->_mapper->doGoogleLogin($data['google']);
	} else {
	    // TODO: handle invalid request
	}
if (count($result[0]) > 0) {
    $this->results[] = $result;
} else {
//    $errors = new \Api\Errors(); $error = $errors->getError(206);
//    throw new Exception(array($error->getResponse()), 405);
    $this->errors[] = array('code' => 206, 'message' => 'Invalid username / password');
}
//echo '$result: ' . print_r($this->results, true) . "\n";
//	$this->errors[] = array('code' => '100', 'message' => "Action 'LOGIN' not implemented yet ");
    }
    
    public function actionRegister($id, $data)
    {
	// TODO
        return array($this->_mapper->addItem($data), array());
    }
    
}
