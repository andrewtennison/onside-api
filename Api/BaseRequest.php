<?php
namespace Api;
use \Api\Response;

abstract class BaseRequest
{
    protected $defaultController;
    protected $object;
    protected $key;
    protected $method;
    protected $get;
    protected $post;

    public function __construct($uri, $method = 'GET', $get = array(), $post = array())
    {
        assert('!empty($uri)');
        $this->method = strtoupper($method);
        $this->key = null;
        $this->setGet($get);
        $this->setPost($post);
        $this->parseUri($uri);
    }

    public function getGet()
    {
        return $this->get;
    }
    
    public function getPost()
    {
        return $this->post;
    }

    public function getResponse($type, $code, $data = array(), $errors = array())
    {
        return new Response($type, $code, $data, $errors);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getParam($key)
    {
        if (array_key_exists($key, $this->post))
            return $this->post[$key];
        if (array_key_exists($key, $this->get))
            return $this->get[$key];
        return null;
    }
    
    public function getParams()
    {
        return array_merge($this->get, $this->post);
    }
    
    protected function setGet($get)
    {
        assert('is_array($get)');
        $this->get = $get;
    }
    
    protected function setPost($post)
    {
        assert('is_array($post)');
        $this->post = $post;
    }
    
    protected function parseUri($uri)
    {
        if ($uri === '/') {
            $this->object = $this->defaultController;
            return;
        }
        $parts = explode('/', substr($uri, 1));
        assert('count($parts) > 0');
        if (strpos($parts[0], '?')) {
            list($this->object, $queryString) = explode('?', $parts[0]);
        } else {
            $this->object = $parts[0];
        }
        if (count($parts) > 1) {
            if (strpos($parts[1], '?')) {
                list($this->key, $queryString) = explode('?', $parts[1]);
                // TODO: anything needed from query string ?
            } else {
                $this->key = $parts[1];
            }
            if (is_numeric($this->key))
                $this->get['id'] = $this->key;
        }
    }

    protected function parseParams($params)
    {
//        assert('array_key_exists(\'\', $params)');
    }
}
