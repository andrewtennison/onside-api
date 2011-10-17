<?php
namespace Api;
use \Api\BaseController;

class UserController extends BaseController
{
    public function actionLogin()
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'LOGIN' not implemented yet")));
    }
}
