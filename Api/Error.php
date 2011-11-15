<?php
namespace Api;

class Error
{
	private $code;
	private $message;
	private $values;
	
	public function __construct($code, $message, $values = array())
	{
		$this->code = $code;
		$this->message = $message;
		$this->values = $values;
	}

	public function getCode() { return $this->code; }

	public function getMessage() { return $this->message; }
	
	public function addValue($value)
	{
		$this->values[] = $value;
	}
	
	public function getResponse()
	{
		$message = $this->message;
		$values = $this->values;
		krsort($values);
		while (false !== strpos($message, '?')) {
			$pos = strpos($message, '?');
			$message = substr($message, 0, $pos) . array_pop($values) . substr($message, $pos+1);
		}
		return array('code' => $this->code, 'message' => $message);
	}
}
