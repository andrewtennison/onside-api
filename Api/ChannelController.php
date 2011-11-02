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
    }
    
    public function actionGet()
    {
        return array($this->_mapper->selectItem(), array());
    }
    
    public function actionItem($id)
    {
        return array($this->_mapper->getItem($id), array());
    }
    
    public function actionPost($id, $data)
    {
        return array($this->_mapper->updateItem($id, $data), array());
    }
    
    public function actionPut($data)
    {
        return array($this->_mapper->addItem($data), array());
    }
}
