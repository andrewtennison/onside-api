<?php
namespace Api;

class BaseApi
{
    protected $ip;
    protected $request;
    protected $directResponse;
    
    public function __construct($options = array())
    {
        $this->assertOptions($options);
        if (count($options) > 0) {
            $this->ip = isset($options['remote_addr']) ? $options['remote_addr'] : '';
            $this->directResponse = true;
            $this->request = new Request($options['uri'], $options['method'], $options['get'], $options['post']);
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->directReseponse = false;
            $this->request = new Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_GET, $_POST);
        }
    }
    
    public function run()
    {
        // TODO: client authentication
        $code = 200;
        list ($controllerName, $controller) = $this->getControllerName($this->request->getObject());
        switch($this->request->getMethod()) {
            case 'DELETE':
                list($data, $errors) = $controller->actionDelete($this->request->getParam('id'));
                break;
            case 'GET':
                $key = $this->request->getKey();
                if ((string)$key === $key && method_exists($controller, 'action' . ucfirst($key))) {
                        $action = 'action' . ucfirst($key);
                        list($data, $errors) = $controller->$action();
                } else if (is_numeric($key)) {
                    list($data, $errors) = $controller->actionItem($key);
                } else {
                    list($data, $errors) = $controller->actionGet();
                }
                break;
            case 'POST':
                list($data, $errors) = $controller->actionPost($this->request->getParam('id'), $this->request->getPost());
                break;
            case 'PUT':
                list($data, $errors) = $controller->actionPut($this->request->getPost());
                break;
        }
        return $this->request->getResponse($controllerName, $code, $data, $errors);
    }
        
    protected function getControllerName($controllerName)
    {
        $className = '\Api\\' . ucfirst($controllerName) . 'Controller';
        return array(ucfirst($controllerName), new $className());
    }
    
    protected function assertOptions($options)
    {
        if (count($options) == 0)
            return;
        foreach (array('uri', 'method', 'get', 'post') as $key) {
            assert('array_key_exists($key, $options)');
        }
    }
}
