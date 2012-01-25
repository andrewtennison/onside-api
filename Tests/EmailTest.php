<?php
namespace Tests;
use \Tests\Test;
use \Onside\Email;

class EmailTest extends Test
{
    public function testEmail()
    {
	$email = new Email();
	$this->assertInstanceOf('\Onside\Email', $email);
    }
}
