<?php
namespace Tests;
use \Tests\Test;
use \Api\Error;
use \Api\Errors;

class ErrorsTest extends Test
{
    private function getMessage($message, $values)
    {
	rsort($values);
	while (false !== strpos($message, '?')) {
	    $pos = strpos($message, '?');
	    $message = substr($message, 0, $pos) . array_pop($values) . substr($message, $pos+1);
	}
	return $message;
    }
    
    public function provideValidErrors()
    {
	return array(
	    array(101, "Missing required header"),
	    array(102, "Unknown service '?'", array('ServiceName')),
	    array(103, "Invalid action '?' for service '?'", array('ActionName', 'ServiceName')),
	);
    }
    
    /**
     * @dataProvider provideValidErrors
     */
    public function testError($code, $message, $values = array())
    {
	$error = new Error($code, $message);
	foreach ($values as $value)
	    $error->addValue($value);
	$response = $error->getResponse();
	$object = json_decode($response);
	
	$this->assertInternalType('object', $object);
	$this->assertObjectHasAttribute('code', $object);
	$this->assertInternalType('integer', $object->code);
	$this->assertEquals($code, $object->code);
	$this->assertObjectHasAttribute('message', $object);
	$this->assertInternalType('string', $object->message);
	$this->assertEquals($this->getMessage($message, $values), $object->message);
    }
    
    public function testErrors()
    {
	$errors = new Errors();
	$error = $errors->getError(103);
	$error->addValue('ActionName');
	$error->addValue('ServiceName');
	$response = $error->getResponse();
	$object = json_decode($response, true);
    }
}
