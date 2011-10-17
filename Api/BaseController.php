<?php
namespace Api;

abstract class BaseController
{
    public function actionDelete($id)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'DELETE' not implemented yet")));
    }
    
    public function actionGet()
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'GET' not implemented yet")));
    }
    
    public function actionItem($id)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'ITEM($id)' not implemented yet")));
    }
    
    public function actionPost($id, $data)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'POST' not implemented yet")));
    }
    
    public function actionPut($data)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'PUT' not implemented yet")));
    }
}
