<?php
namespace Api;

abstract class BaseController
{
    protected $results = array();
    protected $errors = array();
    
    public function actionDelete($id)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'DELETE' not implemented yet ");
    }
    
    public function actionGet()
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'GET' not implemented yet ");
    }
    
    public function actionItem($id)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'ITEM($id)' not implemented yet ");
    }
    
    public function actionPost($id, $data)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'POST' not implemented yet ");
    }
    
    public function actionPut($data)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'PUT' not implemented yet ");
    }
    
    public function getResults()
    {
	return $this->results;
    }
    
    public function getErrors()
    {
	return $this->errors;
    }
}
