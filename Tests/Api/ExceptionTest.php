<?php
namespace Tests\Api;
use \Tests\Test;
use \Onside\Exception;

class ExceptionTest extends Test
{
    public function testException()
    {
	$this->markTestIncomplete('waiting full exception handling');
	throw new Exception(
	    array(
		'code' => 1001,
		'message' => 'test exception'
	    ), 500);
    }
}
