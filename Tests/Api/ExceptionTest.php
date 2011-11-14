<?php
namespace Tests\Api;
use \Tests\Test;
use \Api\Exception;

class ExceptionTest extends Test
{
    public function testException()
    {
	throw new Exception(
	    array(
		'code' => 1001,
		'message' => 'test exception'
	    ), 500);
    }
}
