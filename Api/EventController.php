<?php
namespace Api;
use \Api\BaseController;

class EventController extends BaseController
{
    public function actionGet()
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'GET' not implemented yet")));
    }
    
    public function actionItem($id)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'ITEM($id)' not implemented yet")));
    }

}
