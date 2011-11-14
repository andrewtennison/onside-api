<?php
namespace Api;

class Error
{
    private $code;
    private $message;
    private $values = array();
    
    public function __construct($code, $message)
    {
	$this->code = $code;
	$this->message = $message;
    }
    
    public function getCode()
    {
	return $this->code;
    }
    
    public function getMessage()
    {
	return $this->message;
    }
    
    public function addValue($value)
    {
	$this->values[] = $value;
    }
    
    public function getResponse()
    {
	$message = $this->message;
	$values = $this->values;
	rsort($values);
	while (false !== strpos($message, '?')) {
	    $pos = strpos($message, '?');
	    $message = substr($message, 0, $pos) . array_pop($values) . substr($message, $pos+1);
	}
	return json_encode(array('code' => $this->code, 'message' => $message));
    }
}
