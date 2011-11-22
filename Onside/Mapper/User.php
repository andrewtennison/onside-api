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
    
    public function doFacebookLogin($uid, $email)
    {
	$return = $this->selectItem(array('facebook' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('facebook' => $uid, 'email' => $email, 'language' => 'en_gb'));
	    // TODO: insert will fail if email address already exists in the system
	}
	
	return $return;
    }
    
    public function doTwitterLogin($uid, $email)
    {
	$return = $this->selectItem(array('twitter' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('twitter' => $uid, 'email' => $email, 'language' => 'en_gb'));
	}
	
	return $return;
    }
    
    public function doGoogleLogin($uid, $email)
    {
	$return = $this->selectItem(array('google' => $uid), array(), null);
	if (count($return) == 0) {
	    $return = $this->addItem(array('google' => $uid, 'email' => $email, 'language' => 'en_gb'));
	}
	
	return $return;
    }
}
