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
        
    public function actionLogin()
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'LOGIN' not implemented yet")));
    }
}
