<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Channel;

class ChannelController extends BaseController
{
    protected $filters = array('sport', 'type', 'user');
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new Channel($db);
    }
    
    public function actionFollow($id, $data)
    {
	$this->results[] = $this->_mapper->addFollower($data['channel'], $data['user']);
    }
    
    public function actionUnfollow($id, $data)
    {
	$this->_mapper->te();
//    throw new Exception(array('some message standard exception'), 999);
//	$this->errors[] = array('code' => '100', 'message' => "Action 'FOLLOW' not implemented yet ");
    }
    
    public function actionDelete($id)
    {
        $this->results[] = $this->_mapper->deleteItem($id);
    }
    
    public function actionGet($data = array())
    {
	$where = $this->getAcceptedFilters($data);
        $this->results[] = $this->_mapper->selectItem($where);
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