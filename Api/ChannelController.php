<?php
namespace Api;
use \Api\BaseController;
use \Onside\Mapper\Channel;

class ChannelController extends BaseController
{
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new Channel($db);
    }
    
    public function actionFollow($id)
    {
        return array(array(), array(array('code' => '100', 'message' => "Action 'FOLLOW' not implemented yet")));
    }
    
    public function actionDelete($id)
    {
        return array($this->_mapper->deleteItem($id), array());
//        return array(array(), array(array('code' => '100', 'message' => "Action 'DELETE' not implemented yet")));
    }
    
    public function actionGet()
    {
        return array($this->_mapper->selectItem(), array());
//        return array($results, array(array('code' => '100', 'message' => "Action 'GET' not implemented yet")));
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
