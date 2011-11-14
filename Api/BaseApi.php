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
	    $response = $this->getInvalidResponse($this->request->getObject());
	    if (null !== $response && $response instanceof \Api\BaseResponse) {
		$response->sendResponse();
		exit;
	    }
	    list ($controllerName, $controller) = $this->getControllerName($this->request->getObject());

	    $key = $this->request->getKey();
	    $method = $this->request->getMethod();
	    // handle complex GET/POST
	    if (null === $key && in_array($method, array('GET', 'POST'))) {
		if ($method === 'POST') list($data, $errors) = $controller->actionPut($this->request->getPost());
		if ($method === 'GET') list($data, $errors) = $controller->actionGet();
	    } else if (is_numeric($key) && $method !== 'PUT') {
		if ($method === 'DELETE') list($data, $errors) = $controller->actionDelete($this->request->getParam('id'));
		if ($method === 'POST') list($data, $errors) = $controller->actionPost($this->request->getParam('id'), $this->request->getPost());
		if ($method === 'GET') list($data, $errors) = $controller->actionItem($key);
	    } else if (
		(string)$key === $key && 
		in_array($method, array('GET', 'POST')) && 
		method_exists($controller, 'action' . ucfirst($key))
	    ) {
		$action = 'action' . ucfirst($key);
		list($data, $errors) = $controller->$action($this->request->getParam('id'), $this->request->getPost());
	    } else {
		$code = 401;
		$errors[] = array('code' => 2001, 'message' => "This call doesn't support the '{$method}' method");
	    }
	} catch (\Exception $e) {
	    return $this->request->getResponse($this->request->getObject(), 500, array(), array(array(
		'code' => 1001,
		'message' => "Unknown service '{$this->request->getObject()}'",
		'traceroute' => ''
	    )));
	}
        return $this->request->getResponse($controllerName, $code, $data, $errors);
    }
    
    protected function getInvalidResponse($controllerName)
    {
	if (!in_array(ucfirst($controllerName), $this->allowedServices)) {
	    return $this->request->getResponse(
		$controllerName,
		404,
		array(), 
		array('code' => 404, 'message' => 'Not Found')
	    );
	}
	// TODO: client authentication
        
	return null;
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
