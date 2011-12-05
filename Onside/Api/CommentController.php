<?php
namespace Onside\Api;
use \Onside\Api\BaseController;
use \Onside\Mapper\Comment;

class CommentController extends BaseController
{
    protected $filters = array('article', 'channel', 'event', 'user');
    private $_mapper;
    
    public function __construct()
    {
        global $db;
        $this->_mapper = new Comment($db);
    }
    
    public function actionDelete($id)
    {
        $this->results[] = $this->_mapper->deleteItem($id);
    }
    
    public function actionGet($data = array())
    {
	$where = $this->getAcceptedFilters($data);
        $this->results[] = $this->_mapper->selectItem($where, array(), $this->limit);
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
