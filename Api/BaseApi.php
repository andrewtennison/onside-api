<?php
namespace Api;

class BaseApi
{
    protected $ip;
    protected $request;
    protected $directResponse;
    protected $allowedServices = array();
    protected $errors;
    
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
	$this->errors = new \Api\Errors();
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
		if ($method === 'GET') $controller->actionGet($this->request->getGet());
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
		$error = $this->errors->getError(103, array(ucfirst($key), $controllerName));
		throw new Exception(array($error->getResponse()), 405);
	    }
	} catch (\Exception $e) {
//	    exit;
	    return $this->request->getResponse($this->request->getObject(), $e->getCode(), array(), $e->getResponseFields());
	}
	$data = $controller->getResults();
	$errors = $controller->getErrors();
        return $this->request->getResponse($controllerName, $code, $data, $errors);
    }
    
    protected function getInvalidResponse($controllerName)
    {
	if (!in_array(strtolower($controllerName), $this->allowedServices)) {
	    $error = $this->errors->getError(102, array($controllerName));
	    throw new Exception(array($error->getResponse()), 501);
	}
	// TODO: client authentication throw 401
	
	// basic auth
//	$auth = new \Api\BaseAuth();
//	$auth->canAuth(\Api\BaseAuth::BASIC);
//	if ((!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) || ($_SERVER['PHP_AUTH_USER'] !== 'isaac' || $_SERVER['PHP_AUTH_PW'] !== 'test')) {
//	    $error = $this->errors->getError(101, array());
//	    throw new Exception(array($error->getResponse()), 401);
//	}
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
