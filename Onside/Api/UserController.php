<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\User;

class UserController extends BaseController
{
    // TODO: allow filtering using follower
//    protected $filters = array('channel');
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
	} else if (array_key_exists('email', $data) && array_key_exists('facebook', $data)) {
	    $result = $this->_mapper->doFacebookLogin($data['facebook'], $data['email']);
	} else if (array_key_exists('email', $data) && array_key_exists('twitter', $data)) {
	    $result = $this->_mapper->doTwitterLogin($data['twitter'], $data['email']);
	} else if (array_key_exists('email', $data) && array_key_exists('google', $data)) {
	    $result = $this->_mapper->doGoogleLogin($data['google'], $data['email']);
	} else {
	    // TODO: handle invalid request
	    $result = array();
	    $this->errors[] = array('code' => 201, 'message' => 'Missing required field \'?\'');
	}
//echo "\n" . '$result: ' . print_r($result, true) . "\n";
//exit;
	if (count($result) > 0) {
	    $this->results[] = $result;
	} else {
//    $errors = new \Api\Errors(); $error = $errors->getError(206);
//    throw new Exception(array($error->getResponse()), 405);
	    $this->errors[] = array('code' => 206, 'message' => 'Invalid username / password');
	}
//echo '$result: ' . print_r($this->results, true) . "\n";
//	$this->errors[] = array('code' => '100', 'message' => "Action 'LOGIN' not implemented yet ");
    }
    
    public function actionPost($id, $data)
    {
        $this->results[] = $this->_mapper->updateItem($id, $data);
    }
    
    public function actionRegister($id, $data)
    {
	// TODO
        return array($this->_mapper->addItem($data), array());
    }
    
}
