<?php
namespace Api;

class BaseApi
{
    protected $ip;
    protected $request;
    protected $directResponse;
    protected $allowedServices = array();
    
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
	try {
	    $code = 200;
	    
	    // check request, authorization
	    $this->getInvalidResponse($this->request->getObject());
	    
	    $controllerName = $this->getControllerName($this->request->getObject());
	    $controller = $this->getControllerClass($this->request->getObject());

	    $key = $this->request->getKey();
	    $method = $this->request->getMethod();
	    // handle complex GET/POST
	    if (null === $key && in_array($method, array('GET', 'POST'))) {
		if ($method === 'POST') $controller->actionPut($this->request->getPost());
		if ($method === 'GET') $controller->actionGet();
	    } else if (is_numeric($key) && $method !== 'PUT') {
		if ($method === 'DELETE') $controller->actionDelete($this->request->getParam('id'));
		if ($method === 'POST') $controller->actionPost($this->request->getParam('id'), $this->request->getPost());
		if ($method === 'GET') $controller->actionItem($key);
	    } else if (
		(string)$key === $key && 
		in_array($method, array('GET', 'POST')) && 
		method_exists($controller, 'action' . ucfirst($key))
	    ) {
		$action = 'action' . ucfirst($key);
		$controller->$action($this->request->getParam('id'), $this->request->getPost());
	    } else {
		throw new Exception(array(
		    array('code' => 2001, 'message' => "This call doesn't support the '$method' method "),
		), 404);
	    }
	} catch (\Exception $e) {
	    return $this->request->getResponse($this->request->getObject(), $e->getCode(), array(), $e->getResponseFields());
	}
	$data = $controller->getResults();
	$errors = $controller->getErrors();
        return $this->request->getResponse($controllerName, $code, $data, $errors);
    }
    
    protected function getInvalidResponse($controllerName)
    {
	if (!in_array(strtolower($controllerName), $this->allowedServices)) {
	    throw new Exception(array(
		array('code' => 1002, 'message' => "Unknown service '$controllerName' "),
	    ), 404);
	}
	// TODO: client authentication throw 401
        
//	return null;
    }
    
    protected function getControllerName($controllerName)
    {
        return ucfirst($controllerName);
    }
    
    protected function getControllerClass($controllerName)
    {
	$className = '\Api\\' . ucfirst($controllerName) . 'Controller';
        return new $className();
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
