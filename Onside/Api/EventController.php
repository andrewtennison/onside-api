<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Event;

class EventController extends BaseController
{
    protected $filters = array('sport', 'type', 'channel', 'stime');
    private $_mapper;

    public function __construct()
    {
        global $db;
        $this->_mapper = new Event($db);
    }

        public function actionChannel($id, $data)
    {
	$this->results[] = $this->_mapper->addChannel($data['channel'], $data['event']);
    }

    public function actionNochannel($id, $data)
    {
	$this->results[] = $this->_mapper->removeChannel($data['channel'], $data['event']);
    }

    public function actionDelete($id)
    {
	$this->results[] = $this->_mapper->deleteItem($id);
    }

    public function actionGet($data = array())
    {
	$where = $this->getAcceptedFilters($data);
	$this->results[] = $this->_mapper->selectItem($where, $this->getSort($data), $this->limit);
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
