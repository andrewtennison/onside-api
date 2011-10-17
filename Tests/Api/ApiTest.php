<?php
namespace Tests\Api;
use \Tests\Test;
use \Tests\MockApi;
use \Tests\MockController;

class ApiTest extends Test
{
    public function testApi()
    {
        $this->markTestIncomplete();
        $options = array(
            'uri' => '/controller/8475th3293fh3ufhejwfkn',
            'method' => 'GET',
            'get' => array(),
            'post' => array(),
        );
        $api = new MockApi($options);
        $response = $api->run();
echo '$response: ' . print_r($response, true) . "\n";
        $this->assertInstanceOf('\Api\Api', $api);
    }
}
