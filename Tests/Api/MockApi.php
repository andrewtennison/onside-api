<?php
namespace Tests\Api;
use \Onside\Api\BaseApi;
use \Tests\Api\MockController;

class MockApi extends BaseApi
{
    public function __construct($options = array())
    {
        $this->assertOptions($options);
        if (count($options) > 0) {
            $this->ip = isset($options['remote_addr']) ? $options['remote_addr'] : '';
            $this->directResponse = true;
            $this->request = new MockRequest($options['uri'], $options['method'], $options['get'], $options['post']);
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->directReseponse = false;
            $this->request = new MockRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_GET, $_POST);
        }
    }
        
    protected function getControllerName($controllerName)
    {
        $controllerName = 'Mock' . ucfirst($controllerName);
echo '$controllerName: ' . $controllerName . '[' . class_exists($controllerName) . ']' . "\n";
        return array($controllerName, new $controllerName());
    }
}
