<?php
namespace Onside\Mapper;
use \Onside\Mapper;

class User extends Mapper
{
    protected $_table = 'user';
    protected $_model = '\Onside\Model\User';
    
    public function doOnsideLogin($email, $password)
    {
	return $this->selectItem(array('email' => array('=', $email, 'AND'), 'password' => "PASSWORD('$password')"), array(), null);
    }
    
    public function doFacebookLogin($uid)
    {
	return $this->selectItem(array('facebook' => $uid), array(), null);
    }
    
    public function doTwitterLogin($uid)
    {
	return $this->selectItem(array('twitter' => $uid), array(), null);
    }
    
    public function doGoogleLogin($uid)
    {
	return $this->selectItem(array('google' => $uid), array(), null);
    }
}
