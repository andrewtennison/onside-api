<?php
namespace Onside;

class Session
{
    static public function startSession($token)
    {
	assert('!empty($token)');
	session_start();
	session_id($token);
    }
    
    static public function destroySession()
    {
	session_destroy();
    }
}