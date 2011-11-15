<?php
namespace Api;
use \Api\Error;

class Errors
{
    private $errors;
    
    public function __construct()
    {
	$this->errors = array(
	    // Service call errors
	    new Error(101, "Missing required header"),
	    new Error(102, "Unknown service '?'"),
	    new Error(103, "Invalid action '?' for service '?'"),
	    new Error(104, "Service '?' not implemented"),
	    new Error(105, "Client login required for this call"),
	    
	    // Client input errors
	    new Error(201, "Missing required field '?'"),
	    new Error(202, "Invalid field '?', accepted format ?"),
	    new Error(203, "Record failed to be created"),
	    new Error(204, "Record failed to be updated"),
	    new Error(205, "Record failed to be deleted"),
	    
	);
    }
    
    public function getError($code, $values = array())
    {
	foreach ($this->errors as $error) {
	    if ($code === $error->getCode()) {
		foreach ($values as $value) $error->addValue($value);
		return $error;
	    }
	}
	
	return null;
    }
}
