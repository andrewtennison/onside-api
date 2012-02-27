<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Channel;

class ChannelController extends BaseController
{
    protected $filters = array('sport', 'type', 'user', 'event', 'channel', 'status');
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
	$this->results[] = $this->_mapper->removeFollower($data['channel'], $data['user']);
    }

    public function actionChannel($id, $data)
    {
	$this->results[] = $this->_mapper->addChannel($data['channel1'], $data['channel2']);
    }

    public function actionNochannel($id, $data)
    {
	$this->results[] = $this->_mapper->removeChannel($data['channel1'], $data['channel2']);
    }

    public function actionDelete($id)
    {
        $this->results[] = $this->_mapper->deleteItem($id);
    }

    public function actionGet($data = array())
    {
	$where = $this->getAcceptedFilters($data);
        $sort = $this->getSort($data);
        $this->results[] = $this->_mapper->selectItem($where, $sort, $this->limit);
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
