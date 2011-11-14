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
    
    public function actionFollow($id, $data)
    {
	$this->errors[] = array('code' => '100', 'message' => "Action 'FOLLOW' not implemented yet ");
    }
    
    public function actionDelete($id)
    {
        $this->results[] = $this->_mapper->deleteItem($id);
    }
    
    public function actionGet()
    {
        $this->results[] = $this->_mapper->selectItem();
    }
    
    public function actionItem($id)
    {
        $this->results[] = $this->_mapper->getItem($id);
    }
    
    public function actionPost($id, $data)
    {
        $this->results[] = $this->_mapper->updateItem($id, $data);
    }
    
    public function actionPut($data)
    {
        $this->results[] = $this->_mapper->addItem($data);
    }
}
