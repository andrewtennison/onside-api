<?php
namespace Api;
use \Api\BaseController;

class ChannelController extends BaseController
{
    public function actionFollow($id)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'FOLLOW' not implemented yet")));
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
}
